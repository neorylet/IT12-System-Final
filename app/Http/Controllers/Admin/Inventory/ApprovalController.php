<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApprovalController extends Controller
{
public function index(Request $request)
{
    $historyDate = trim((string) $request->query('history_date', ''));
    $historyShelf = trim((string) $request->query('history_shelf', ''));

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

    $approvalHistory = InventoryTransaction::with([
            'shelf',
            'renter',
            'actionedBy',
            'items.product'
        ])
        ->where('transaction_type', 'IN')
        ->whereIn('status', ['Approved', 'Rejected'])
        ->when($historyDate, function ($query) use ($historyDate) {
            $query->whereDate('approved_at', $historyDate);
        })
        ->when($historyShelf, function ($query) use ($historyShelf) {
            $query->where('shelf_id', $historyShelf);
        })
        ->latest('approved_at')
        ->take(50)
        ->get();

    $historyShelves = \App\Models\Shelf::orderBy('shelf_number')->get();

    return view('admin.inventory.pending', compact(
        'pendingTransactions',
        'approvalHistory',
        'historyDate',
        'historyShelf',
        'historyShelves'
    ));
}

    public function approve(InventoryTransaction $transaction)
    {
        if ($transaction->status !== 'Pending') {
            return back()->withErrors([
                'approve' => 'Only pending transactions can be approved.'
            ]);
        }

        $logItems = [];
        $batchBreakdown = [];

        DB::transaction(function () use ($transaction, &$logItems, &$batchBreakdown) {
            $transaction->load(['items.product', 'shelf', 'renter', 'actionedBy']);

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

                $beforeQty = (int) $inventory->quantity_on_hand;
                $afterQty = $beforeQty + (int) $item->quantity;

                $inventory->quantity_on_hand = $afterQty;
                $inventory->last_updated = now();
                $inventory->save();

                $logItems[] = [
                    'product_id' => $product->product_id,
                    'product_name' => $product->product_name,
                    'quantity' => (int) $item->quantity,
                    'quantity_before' => $beforeQty,
                    'quantity_after' => $afterQty,
                    'lot_number' => $batch->lot_number,
                    'manufacturing_date' => $batch->manufacturing_date,
                    'expiration_date' => $batch->expiration_date,
                ];

                $batchBreakdown[] = [
                    'product_id' => $product->product_id,
                    'product_name' => $product->product_name,
                    'batch_id' => $batch->batch_id,
                    'lot_number' => $batch->lot_number,
                    'expiration_date' => $batch->expiration_date,
                    'quantity_received' => (int) $item->quantity,
                ];
            }

            $transaction->update([
                'status'       => 'Approved',
                'approved_by'  => auth()->id(),
                'approved_at'  => now(),
            ]);
        });

        $transaction->load(['shelf', 'renter', 'actionedBy', 'items.product']);

        $totalUnits = collect($logItems)->sum('quantity');

        AuditLogService::log(
            'Approve',
            'Approvals',
            "Approved transaction {$transaction->reference_no}" .
            ($transaction->shelf?->shelf_number ? " for Shelf {$transaction->shelf->shelf_number}" : '') .
            ($transaction->renter?->renter_company_name ? " ({$transaction->renter->renter_company_name})" : '') .
            " with " . count($logItems) . " item(s), total {$totalUnits} unit(s).",
            $transaction->transaction_id,
            $transaction->reference_no,
            [
                'decision' => 'Approved',
                'transaction_type' => $transaction->transaction_type,
                'transaction_date' => optional($transaction->transaction_date)->format('Y-m-d H:i:s'),
                'approved_at' => now()->format('Y-m-d H:i:s'),
                'requested_by' => $transaction->actionedBy->name ?? null,
                'shelf_id' => $transaction->shelf_id,
                'shelf_number' => $transaction->shelf->shelf_number ?? null,
                'renter_id' => $transaction->renter_id,
                'renter_name' => $transaction->renter->renter_company_name ?? null,
                'remarks' => $transaction->remarks,
                'total_items' => count($logItems),
                'total_units' => $totalUnits,
                'items' => $logItems,
                'batch_breakdown' => $batchBreakdown,
            ]
        );

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

        $transaction->load(['items.product', 'shelf', 'renter', 'actionedBy']);

        $reviewRemarks = $request->review_remarks;

        $logItems = $transaction->items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'product_name' => $item->product->product_name ?? 'Unknown Product',
                'quantity' => (int) $item->quantity,
                'lot_number' => $item->lot_number,
                'manufacturing_date' => $item->manufacturing_date,
                'expiration_date' => $item->expiration_date,
            ];
        })->values()->all();

        $transaction->update([
            'status'         => 'Rejected',
            'approved_by'    => auth()->id(),
            'approved_at'    => now(),
            'review_remarks' => $reviewRemarks,
        ]);

        $totalUnits = collect($logItems)->sum('quantity');

        AuditLogService::log(
            'Reject',
            'Approvals',
            "Rejected transaction {$transaction->reference_no}" .
            ($transaction->shelf?->shelf_number ? " for Shelf {$transaction->shelf->shelf_number}" : '') .
            ($transaction->renter?->renter_company_name ? " ({$transaction->renter->renter_company_name})" : '') .
            " with " . count($logItems) . " item(s), total {$totalUnits} unit(s).",
            $transaction->transaction_id,
            $transaction->reference_no,
            [
                'decision' => 'Rejected',
                'transaction_type' => $transaction->transaction_type,
                'transaction_date' => optional($transaction->transaction_date)->format('Y-m-d H:i:s'),
                'reviewed_at' => now()->format('Y-m-d H:i:s'),
                'requested_by' => $transaction->actionedBy->name ?? null,
                'shelf_id' => $transaction->shelf_id,
                'shelf_number' => $transaction->shelf->shelf_number ?? null,
                'renter_id' => $transaction->renter_id,
                'renter_name' => $transaction->renter->renter_company_name ?? null,
                'remarks' => $transaction->remarks,
                'review_remarks' => $reviewRemarks,
                'total_items' => count($logItems),
                'total_units' => $totalUnits,
                'items' => $logItems,
            ]
        );

        return redirect()
            ->route('admin.inventory.pending')
            ->with('success', 'Pending stock-in request rejected.');
    }
}