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

class AdjustmentController extends Controller
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

        return view('admin.inventory.adjustment', [
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
            'items.*.mode'       => ['required', 'in:set,increase,decrease'],
            'items.*.quantity'   => ['required', 'integer', 'min:0'],
        ]);

        return DB::transaction(function () use ($validated) {
            $shelf = Shelf::with('renter')->where('shelf_id', $validated['shelf_id'])->firstOrFail();

            if (!$shelf->renter_id) {
                return back()->withErrors([
                    'shelf_id' => 'This shelf has no assigned renter. Assign a renter first.'
                ])->withInput();
            }

            $reference = 'ADJ-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));

            $trx = InventoryTransaction::create([
                'transaction_type' => 'ADJUSTMENT',
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

                $inv = Inventory::firstOrCreate(
                    ['product_id' => $product->product_id],
                    ['quantity_on_hand' => 0, 'reorder_level' => 5]
                );

                $current = (int) $inv->quantity_on_hand;
                $mode = $row['mode'];
                $qty = (int) $row['quantity'];

                $newQty = $current;
                if ($mode === 'set') {
                    $newQty = $qty;
                }
                if ($mode === 'increase') {
                    $newQty = $current + $qty;
                }
                if ($mode === 'decrease') {
                    $newQty = max(0, $current - $qty);
                }

                $delta = $newQty - $current;

                if ($delta === 0) {
                    continue;
                }

                if ($delta > 0) {
                    $batch = ProductBatch::create([
                        'product_id'         => $product->product_id,
                        'lot_number'         => 'ADJ+' . Str::upper(Str::random(6)),
                        'manufacturing_date' => null,
                        'expiration_date'    => now()->addYears(50)->toDateString(),
                        'quantity_received'  => $delta,
                        'quantity_remaining' => $delta,
                        'date_received'      => now()->toDateString(),
                        'status'             => 'Active',
                    ]);

                    InventoryTransactionItem::create([
                        'transaction_id'      => $trx->transaction_id,
                        'product_id'          => $product->product_id,
                        'batch_id'            => $batch->batch_id,
                        'lot_number'          => $batch->lot_number,
                        'manufacturing_date'  => $batch->manufacturing_date,
                        'expiration_date'     => $batch->expiration_date,
                        'quantity'            => $delta,
                        'unit_cost'           => null,
                    ]);

                    $batchBreakdown[] = [
                        'product_id' => $product->product_id,
                        'product_name' => $product->product_name,
                        'type' => 'added',
                        'batch_id' => $batch->batch_id,
                        'lot_number' => $batch->lot_number,
                        'expiration_date' => $batch->expiration_date,
                        'quantity' => $delta,
                    ];
                } else {
                    $toRemove = abs($delta);

                    $batches = ProductBatch::where('product_id', $product->product_id)
                        ->where('quantity_remaining', '>', 0)
                        ->orderBy('expiration_date')
                        ->orderBy('date_received')
                        ->orderBy('batch_id')
                        ->lockForUpdate()
                        ->get();

                    foreach ($batches as $batch) {
                        if ($toRemove <= 0) {
                            break;
                        }

                        $take = min($toRemove, (int) $batch->quantity_remaining);
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
                            'type' => 'removed',
                            'batch_id' => $batch->batch_id,
                            'lot_number' => $batch->lot_number,
                            'expiration_date' => $batch->expiration_date,
                            'quantity' => $take,
                        ];

                        $toRemove -= $take;
                    }

                    if ($toRemove > 0) {
                        return back()->withErrors([
                            'items' => "Batches are insufficient for '{$product->product_name}' adjustment. Check product_batch."
                        ])->withInput();
                    }
                }

                $logItems[] = [
                    'product_id' => $product->product_id,
                    'product_name' => $product->product_name,
                    'mode' => $mode,
                    'input_quantity' => $qty,
                    'quantity_before' => $current,
                    'quantity_after' => $newQty,
                    'delta' => $delta,
                ];

                $inv->quantity_on_hand = $newQty;
                $inv->last_updated = now();
                $inv->save();
            }

            $totalChangedUnits = collect($logItems)->sum(function ($item) {
                return abs((int) $item['delta']);
            });

            AuditLogService::log(
                'Adjust',
                'Inventory',
                "Adjustment {$reference} for Shelf {$shelf->shelf_number}" .
                ($shelf->renter?->renter_company_name ? " ({$shelf->renter->renter_company_name})" : '') .
                " with " . count($logItems) . " item(s), total changed units {$totalChangedUnits}.",
                $trx->transaction_id,
                $reference,
                [
                    'transaction_type' => 'ADJUSTMENT',
                    'transaction_date' => now()->format('Y-m-d H:i:s'),
                    'shelf_id' => $shelf->shelf_id,
                    'shelf_number' => $shelf->shelf_number,
                    'renter_id' => $shelf->renter_id,
                    'renter_name' => $shelf->renter->renter_company_name ?? null,
                    'remarks' => $validated['remarks'] ?? null,
                    'total_items' => count($logItems),
                    'total_changed_units' => $totalChangedUnits,
                    'items' => $logItems,
                    'batch_breakdown' => $batchBreakdown,
                ]
            );

            return redirect()
                ->route('admin.inventory.index')
                ->with('success', "Adjustment saved. Ref: {$reference}");
        });
    }
}