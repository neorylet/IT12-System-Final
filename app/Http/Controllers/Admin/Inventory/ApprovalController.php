<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\ProductBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApprovalController extends Controller
{
    public function index()
    {
        $pendingTransactions = InventoryTransaction::with([
                'shelf',
                'renter',
                'actionedBy',
                'items.product'
            ])
            ->where('status', 'Pending')
            ->where('transaction_type', 'IN')
            ->latest('transaction_date')
            ->get();

        return view('admin.inventory.pending', compact('pendingTransactions'));
    }

    public function approve(InventoryTransaction $transaction)
    {
        if ($transaction->status !== 'Pending') {
            return back()->withErrors([
                'approve' => 'Only pending transactions can be approved.'
            ]);
        }

        DB::transaction(function () use ($transaction) {
            $transaction->load(['items', 'shelf', 'renter']);

            foreach ($transaction->items as $item) {
                $product = Product::findOrFail($item->product_id);

                $batch = ProductBatch::create([
                    'product_id'         => $product->product_id,
                    'lot_number'         => $item->lot_number ?? ('LOT-' . Str::upper(Str::random(6))),
                    'manufacturing_date' => $item->manufacturing_date,
                    'expiration_date'    => $item->expiration_date ?? now()->addYears(50)->toDateString(),
                    'quantity_received'  => (int) $item->quantity,
                    'quantity_remaining' => (int) $item->quantity,
                    'date_received'      => now()->toDateString(),
                    'status'             => 'Active',
                ]);

                $item->batch_id = $batch->batch_id;
                $item->save();

                $inventory = Inventory::firstOrCreate(
                    ['product_id' => $product->product_id],
                    ['quantity_on_hand' => 0, 'reorder_level' => 5]
                );

                $inventory->quantity_on_hand = (int) $inventory->quantity_on_hand + (int) $item->quantity;
                $inventory->last_updated = now();
                $inventory->save();
            }

            $transaction->update([
                'status'       => 'Approved',
                'approved_by'  => auth()->id(),
                'approved_at'  => now(),
            ]);
        });

        return redirect()
            ->route('admin.inventory.pending')
            ->with('success', 'Pending stock-in request approved successfully.');
    }

    public function reject(Request $request, InventoryTransaction $transaction)
    {
        if ($transaction->status !== 'Pending') {
            return back()->withErrors([
                'reject' => 'Only pending transactions can be rejected.'
            ]);
        }

        $transaction->update([
            'status'         => 'Rejected',
            'approved_by'    => auth()->id(),
            'approved_at'    => now(),
            'review_remarks' => $request->review_remarks,
        ]);

        return redirect()
            ->route('admin.inventory.pending')
            ->with('success', 'Pending stock-in request rejected.');
    }
}