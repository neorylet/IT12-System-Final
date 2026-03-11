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
            ->where('status', 'Approved') // only approved products should be stockable
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('product_name', 'like', "%{$q}%")
                       ->orWhere('category', 'like', "%{$q}%");
                });
            })
            ->orderBy('product_name')
            ->get();

        return view('staff.inventory.stock_in', [
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

            // request details to be reviewed by admin later
            'items.*.lot_number'         => ['nullable', 'string', 'max:50'],
            'items.*.manufacturing_date' => ['nullable', 'date'],
            'items.*.expiration_date'    => ['nullable', 'date'],
            'items.*.unit_cost'          => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($validated) {
            $shelf = Shelf::with('renter')
                ->where('shelf_id', $validated['shelf_id'])
                ->firstOrFail();

            if (!$shelf->renter_id) {
                abort(422, 'This shelf has no assigned renter. Assign a renter first.');
            }

            $reference = 'PIN-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));

            $transaction = InventoryTransaction::create([
                'transaction_type' => 'IN',
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
                $product = Product::where('product_id', $row['product_id'])
                    ->where('status', 'Approved')
                    ->firstOrFail();

                // enforce matching shelf and renter
                if ((int) $product->shelf_id !== (int) $shelf->shelf_id ||
                    (int) $product->renter_id !== (int) $shelf->renter_id) {
                    abort(422, "Product '{$product->product_name}' does not belong to the selected shelf/renter.");
                }

                InventoryTransactionItem::create([
                    'transaction_id'      => $transaction->transaction_id,
                    'product_id'          => $product->product_id,
                    'batch_id'            => null, // real batch will be created upon admin approval
                    'lot_number'          => $row['lot_number'] ?? null,
                    'manufacturing_date'  => $row['manufacturing_date'] ?? null,
                    'expiration_date'     => $row['expiration_date'] ?? null,
                    'quantity'            => (int) $row['quantity'],
                    'unit_cost'           => $row['unit_cost'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('staff.inventory.index')
            ->with('success', 'Stock-in request submitted and is now pending admin approval.');
    }
}