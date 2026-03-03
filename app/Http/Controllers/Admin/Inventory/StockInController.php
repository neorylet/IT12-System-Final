<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\InventoryTransactionItem;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\Shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StockInController extends Controller
{
public function create(Request $request)
{
    $q = trim((string) $request->query('q', ''));
    $selectedShelfId = $request->query('shelf_id'); // ✅ from modal redirect
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
        'selectedShelfId' => $selectedShelfId,  // ✅ add
        'selectedShelf' => $selectedShelf,      // ✅ add
    ]);
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shelf_id' => ['required', 'exists:shelves,shelf_id'],
            'remarks'  => ['nullable', 'string', 'max:500'],

            // line items
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,product_id'],
            'items.*.quantity'   => ['required', 'integer', 'min:1'],

            // optional batch fields (for expiring goods)
            'items.*.lot_number'          => ['nullable', 'string', 'max:50'],
            'items.*.manufacturing_date'  => ['nullable', 'date'],
            'items.*.expiration_date'     => ['nullable', 'date'],
            'items.*.unit_cost'           => ['nullable', 'numeric', 'min:0'],
        ]);

        return DB::transaction(function () use ($validated) {

            $shelf = Shelf::with('renter')->where('shelf_id', $validated['shelf_id'])->firstOrFail();

            // business rule: stock in must be tied to an assigned renter
            if (!$shelf->renter_id) {
                return back()->withErrors(['shelf_id' => 'This shelf has no assigned renter. Assign a renter first.'])->withInput();
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
                'approved_by'      => auth()->id(),      // since you said admin doesn’t need approval for now
                'approved_at'      => now(),
            ]);

            foreach ($validated['items'] as $row) {

                $product = Product::where('product_id', $row['product_id'])->firstOrFail();

                // enforce: product must belong to same shelf and renter
                if ((int)$product->shelf_id !== (int)$shelf->shelf_id || (int)$product->renter_id !== (int)$shelf->renter_id) {
                    return back()->withErrors([
                        'items' => "Product '{$product->product_name}' does not belong to the selected shelf/renter."
                    ])->withInput();
                }

                // Create a batch only if expiration_date OR lot_number is provided
                $batchId = null;
                $hasBatchData = !empty($row['expiration_date']) || !empty($row['lot_number']);

                if ($hasBatchData) {
                    $batch = ProductBatch::create([
                        'product_id'         => $product->product_id,
                        'lot_number'         => $row['lot_number'] ?? ('LOT-' . Str::upper(Str::random(6))),
                        'manufacturing_date' => $row['manufacturing_date'] ?? null,
                        'expiration_date'    => $row['expiration_date'] ?? now()->addYears(50)->toDateString(), // fallback
                        'quantity_received'  => (int)$row['quantity'],
                        'quantity_remaining' => (int)$row['quantity'],
                        'date_received'      => now()->toDateString(),
                        'status'             => 'Active',
                    ]);
                    $batchId = $batch->batch_id;
                } else {
                    // For non-expiring goods, create a “virtual batch” with far-future expiry to keep FK consistent
                    $batch = ProductBatch::create([
                        'product_id'         => $product->product_id,
                        'lot_number'         => 'NOEXP-' . Str::upper(Str::random(6)),
                        'manufacturing_date' => null,
                        'expiration_date'    => now()->addYears(50)->toDateString(),
                        'quantity_received'  => (int)$row['quantity'],
                        'quantity_remaining' => (int)$row['quantity'],
                        'date_received'      => now()->toDateString(),
                        'status'             => 'Active',
                    ]);
                    $batchId = $batch->batch_id;
                }

                InventoryTransactionItem::create([
                    'transaction_id' => $trx->transaction_id,
                    'batch_id'       => $batchId,
                    'quantity'       => (int)$row['quantity'],
                    'unit_cost'      => $row['unit_cost'] ?? null,
                ]);

                // Update inventory table (create if missing)
                $inv = Inventory::firstOrCreate(
                    ['product_id' => $product->product_id],
                    ['quantity_on_hand' => 0, 'reorder_level' => 5]
                );

                $inv->quantity_on_hand = (int)$inv->quantity_on_hand + (int)$row['quantity'];
                $inv->last_updated = now();
                $inv->save();
            }

            return redirect()
                ->route('admin.inventory.index')
                ->with('success', "Stock In saved. Ref: {$reference}");
        });
    }
}