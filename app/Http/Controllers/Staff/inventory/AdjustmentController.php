<?php

namespace App\Http\Controllers\Staff\Inventory;

use App\Http\Controllers\Controller;
use App\Models\InventoryTransaction;
use App\Models\InventoryTransactionItem;
use App\Models\Product;
use App\Models\Shelf;
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
            ->where('status', 'Approved')
            ->when($selectedShelfId, fn($q) => $q->where('shelf_id', $selectedShelfId))
            ->orderBy('product_name')
            ->get();

        return view('staff.inventory.adjustment', [
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

        DB::transaction(function () use ($validated) {
            $shelf = Shelf::with('renter')
                ->where('shelf_id', $validated['shelf_id'])
                ->firstOrFail();

            if (!$shelf->renter_id) {
                abort(422, 'This shelf has no assigned renter. Assign a renter first.');
            }

            $reference = 'PADJ-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));

            $transaction = InventoryTransaction::create([
                'transaction_type' => 'ADJUSTMENT',
                'renter_id'        => $shelf->renter_id,
                'shelf_id'         => $shelf->shelf_id,
                'transaction_date' => now(),
                'reference_no'     => $reference,
                'remarks'          => $validated['remarks'] ?? null,
                'status'           => 'Pending',
                'created_by'       => auth()->id(),
                'approved_by'      => null,
                'approved_at'      => null,
                'review_remarks'   => null,
            ]);

            foreach ($validated['items'] as $row) {
                $product = Product::with('inventory')
                    ->where('product_id', $row['product_id'])
                    ->where('status', 'Approved')
                    ->firstOrFail();

                if (
                    (int) $product->shelf_id !== (int) $shelf->shelf_id ||
                    (int) $product->renter_id !== (int) $shelf->renter_id
                ) {
                    abort(422, "Product '{$product->product_name}' does not belong to the selected shelf/renter.");
                }

                InventoryTransactionItem::create([
                    'transaction_id'      => $transaction->transaction_id,
                    'product_id'          => $product->product_id,
                    'batch_id'            => null,
                    'lot_number'          => null,
                    'manufacturing_date'  => null,
                    'expiration_date'     => null,
                    'quantity'            => (int) $row['quantity'],
                    'adjustment_mode'     => $row['mode'],
                    'unit_cost'           => null,
                ]);
            }
        });

        return redirect()
            ->route('staff.inventory.index')
            ->with('success', 'Adjustment request submitted and is now pending admin approval.');
    }
}