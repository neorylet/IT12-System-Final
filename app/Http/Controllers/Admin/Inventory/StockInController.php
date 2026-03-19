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

class StockInController extends Controller
{
    public function create(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
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

        $products = Product::with(['shelf', 'renter', 'inventory'])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('product_name', 'like', "%{$q}%")
                       ->orWhere('category', 'like', "%{$q}%");
                });
            })
            ->orderBy('product_name')
            ->get();

        return view('admin.inventory.stock_in', [
            'shelves' => $shelves,
            'products' => $products,
            'q' => $q,
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
            'items.*.lot_number' => ['nullable', 'string', 'max:50'],
            'items.*.manufacturing_date' => ['nullable', 'date'],
            'items.*.expiration_date' => ['nullable', 'date'],
            'items.*.unit_cost' => ['nullable', 'numeric', 'min:0'],
        ]);

        return DB::transaction(function () use ($validated) {
            $shelf = Shelf::with('renter')->where('shelf_id', $validated['shelf_id'])->firstOrFail();

            if (!$shelf->renter_id) {
                return back()->withErrors([
                    'shelf_id' => 'This shelf has no assigned renter. Assign a renter first.'
                ])->withInput();
            }

            $reference = 'IN-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));

            $trx = InventoryTransaction::create([
                'transaction_type' => 'IN',
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

            foreach ($validated['items'] as $row) {
                $product = Product::where('product_id', $row['product_id'])->firstOrFail();

                if ((int) $product->shelf_id !== (int) $shelf->shelf_id || (int) $product->renter_id !== (int) $shelf->renter_id) {
                    return back()->withErrors([
                        'items' => "Product '{$product->product_name}' does not belong to the selected shelf/renter."
                    ])->withInput();
                }

                $hasBatchData = !empty($row['expiration_date']) || !empty($row['lot_number']);

                $batch = ProductBatch::create([
                    'product_id'         => $product->product_id,
                    'lot_number'         => $hasBatchData
                        ? ($row['lot_number'] ?? ('LOT-' . Str::upper(Str::random(6))))
                        : ('NOEXP-' . Str::upper(Str::random(6))),
                    'manufacturing_date' => $row['manufacturing_date'] ?? null,
                    'expiration_date'    => $row['expiration_date'] ?? now()->addYears(50)->toDateString(),
                    'quantity_received'  => (int) $row['quantity'],
                    'quantity_remaining' => (int) $row['quantity'],
                    'date_received'      => now()->toDateString(),
                    'status'             => 'Active',
                ]);

                InventoryTransactionItem::create([
                    'transaction_id'      => $trx->transaction_id,
                    'product_id'          => $product->product_id,
                    'batch_id'            => $batch->batch_id,
                    'lot_number'          => $row['lot_number'] ?? null,
                    'manufacturing_date'  => $row['manufacturing_date'] ?? null,
                    'expiration_date'     => $row['expiration_date'] ?? null,
                    'quantity'            => (int) $row['quantity'],
                    'unit_cost'           => $row['unit_cost'] ?? null,
                ]);

                $logItems[] = [
                    'product_id' => $product->product_id,
                    'product_name' => $product->product_name,
                    'quantity' => (int) $row['quantity'],
                    'lot_number' => $batch->lot_number,
                    'manufacturing_date' => $batch->manufacturing_date,
                    'expiration_date' => $batch->expiration_date,
                    'unit_cost' => $row['unit_cost'] ?? null,
                ];

                $inv = Inventory::firstOrCreate(
                    ['product_id' => $product->product_id],
                    ['quantity_on_hand' => 0, 'reorder_level' => 5]
                );

                $inv->quantity_on_hand = (int) $inv->quantity_on_hand + (int) $row['quantity'];
                $inv->last_updated = now();
                $inv->save();
            }

            $totalUnits = collect($logItems)->sum('quantity');

            AuditLogService::log(
                'Stock In',
                'Inventory',
                "Stock In {$reference} for Shelf {$shelf->shelf_number}" .
                ($shelf->renter?->renter_company_name ? " ({$shelf->renter->renter_company_name})" : '') .
                " with " . count($logItems) . " item(s), total {$totalUnits} unit(s).",
                $trx->transaction_id,
                $reference,
                [
                    'transaction_type' => 'IN',
                    'transaction_date' => now()->format('Y-m-d H:i:s'),
                    'shelf_id' => $shelf->shelf_id,
                    'shelf_number' => $shelf->shelf_number,
                    'renter_id' => $shelf->renter_id,
                    'renter_name' => $shelf->renter->renter_company_name ?? null,
                    'remarks' => $validated['remarks'] ?? null,
                    'total_items' => count($logItems),
                    'total_units' => $totalUnits,
                    'items' => $logItems,
                ]
            );

            return redirect()
                ->route('admin.inventory.index')
                ->with('success', "Stock In saved. Ref: {$reference}");
        });
    }
}