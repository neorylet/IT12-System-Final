<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\InventoryTransactionItem;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\Shelf;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StockOutController extends Controller
{
    public function create(Request $request)
    {
        $selectedShelfId = $request->query('shelf_id');
        $selectedShelf = null;

        $shelves = Shelf::with('renter')
            ->orderBy('shelf_number')
            ->get();

        if ($selectedShelfId) {
            $selectedShelf = Shelf::with('renter')
                ->where('shelf_id', $selectedShelfId)
                ->first();
        }

        $products = Product::with(['inventory', 'shelf', 'renter'])
            ->when($selectedShelfId, fn($q) => $q->where('shelf_id', $selectedShelfId))
            ->orderBy('product_name')
            ->get();

        return view('admin.inventory.stock_out', [
            'shelves' => $shelves,
            'products' => $products,
            'selectedShelfId' => $selectedShelfId,
            'selectedShelf' => $selectedShelf,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shelf_id' => ['required', 'exists:shelves,shelf_id'],
            'remarks'  => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,product_id'],
            'items.*.quantity'   => ['required', 'integer', 'min:1'],
        ]);

        return DB::transaction(function () use ($validated) {
            $shelf = Shelf::with('renter')->where('shelf_id', $validated['shelf_id'])->firstOrFail();

            if (!$shelf->renter_id) {
                return back()->withErrors([
                    'shelf_id' => 'This shelf has no assigned renter. Assign a renter first.'
                ])->withInput();
            }

            $reference = 'OUT-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));

            $trx = InventoryTransaction::create([
                'transaction_type' => 'OUT',
                'renter_id'        => $shelf->renter_id,
                'shelf_id'         => $shelf->shelf_id,
                'transaction_date' => now(),
                'reference_no'     => $reference,
                'remarks'          => $validated['remarks'] ?? null,
                'created_by'       => auth()->id(),
                'approved_by'      => auth()->id(),
                'approved_at'      => now(),
            ]);

            $logItems = [];
            $batchBreakdown = [];

            foreach ($validated['items'] as $row) {
                $product = Product::with('inventory')
                    ->where('product_id', $row['product_id'])
                    ->firstOrFail();

                if ((int) $product->shelf_id !== (int) $shelf->shelf_id || (int) $product->renter_id !== (int) $shelf->renter_id) {
                    return back()->withErrors([
                        'items' => "Product '{$product->product_name}' does not belong to the selected shelf/renter."
                    ])->withInput();
                }

                $requestedQty = (int) $row['quantity'];
                $qtyToRemove = $requestedQty;
                $onHand = (int) optional($product->inventory)->quantity_on_hand;

                if ($onHand < $qtyToRemove) {
                    return back()->withErrors([
                        'items' => "Not enough stock for '{$product->product_name}'. On hand: {$onHand}, requested: {$qtyToRemove}."
                    ])->withInput();
                }

                $batches = ProductBatch::where('product_id', $product->product_id)
                    ->where('quantity_remaining', '>', 0)
                    ->orderBy('expiration_date')
                    ->orderBy('date_received')
                    ->orderBy('batch_id')
                    ->lockForUpdate()
                    ->get();

                foreach ($batches as $batch) {
                    if ($qtyToRemove <= 0) {
                        break;
                    }

                    $take = min($qtyToRemove, (int) $batch->quantity_remaining);

                    $batch->quantity_remaining = (int) $batch->quantity_remaining - $take;
                    $batch->save();

                    InventoryTransactionItem::create([
                        'transaction_id'      => $trx->transaction_id,
                        'product_id'          => $product->product_id,
                        'batch_id'            => $batch->batch_id,
                        'lot_number'          => $batch->lot_number,
                        'manufacturing_date'  => $batch->manufacturing_date,
                        'expiration_date'     => $batch->expiration_date,
                        'quantity'            => $take,
                        'unit_cost'           => null,
                    ]);

                    $batchBreakdown[] = [
                        'product_id' => $product->product_id,
                        'product_name' => $product->product_name,
                        'batch_id' => $batch->batch_id,
                        'lot_number' => $batch->lot_number,
                        'expiration_date' => $batch->expiration_date,
                        'quantity_taken' => $take,
                    ];

                    $qtyToRemove -= $take;
                }

                if ($qtyToRemove > 0) {
                    return back()->withErrors([
                        'items' => "Batches are insufficient for '{$product->product_name}'. Please check product_batch records."
                    ])->withInput();
                }

                $logItems[] = [
                    'product_id' => $product->product_id,
                    'product_name' => $product->product_name,
                    'quantity' => $requestedQty,
                    'quantity_before' => $onHand,
                    'quantity_after' => $onHand - $requestedQty,
                ];

                $inv = Inventory::firstOrCreate(
                    ['product_id' => $product->product_id],
                    ['quantity_on_hand' => 0, 'reorder_level' => 5]
                );

                $inv->quantity_on_hand = (int) $inv->quantity_on_hand - $requestedQty;
                $inv->last_updated = now();
                $inv->save();
            }

            $totalUnits = collect($logItems)->sum('quantity');

            AuditLogService::log(
                'Stock Out',
                'Inventory',
                "Stock Out {$reference} for Shelf {$shelf->shelf_number}" .
                ($shelf->renter?->renter_company_name ? " ({$shelf->renter->renter_company_name})" : '') .
                " with " . count($logItems) . " item(s), total {$totalUnits} unit(s).",
                $trx->transaction_id,
                $reference,
                [
                    'transaction_type' => 'OUT',
                    'transaction_date' => now()->format('Y-m-d H:i:s'),
                    'shelf_id' => $shelf->shelf_id,
                    'shelf_number' => $shelf->shelf_number,
                    'renter_id' => $shelf->renter_id,
                    'renter_name' => $shelf->renter->renter_company_name ?? null,
                    'remarks' => $validated['remarks'] ?? null,
                    'total_items' => count($logItems),
                    'total_units' => $totalUnits,
                    'items' => $logItems,
                    'batch_breakdown' => $batchBreakdown,
                ]
            );

            return redirect()
                ->route('admin.inventory.index')
                ->with('success', "Stock Out saved. Ref: {$reference}");
        });
    }
}