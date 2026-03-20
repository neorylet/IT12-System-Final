<?php

namespace App\Http\Controllers\Staff\Inventory;

use App\Http\Controllers\Controller;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;

class PendingController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $pendingTransactions = InventoryTransaction::with([
                'items.product',
                'items.batch.product',
                'shelf',
                'renter',
                'actionedBy',
            ])
            ->where('created_by', $userId)
            ->where('status', 'Pending')
            ->orderByDesc('transaction_date')
            ->get();

        $requestHistory = InventoryTransaction::with([
                'items.product',
                'items.batch.product',
                'shelf',
                'renter',
                'actionedBy',
            ])
            ->where('created_by', $userId)
            ->whereIn('status', ['Approved', 'Rejected'])
            ->orderByDesc('approved_at')
            ->limit(20)
            ->get();

        return view('staff.inventory.pending', compact(
            'pendingTransactions',
            'requestHistory'
        ));
    }
}