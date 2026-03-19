<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\Shelf;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $sevenDaysFromNow = Carbon::today()->addDays(7);

        $totalShelves = Shelf::count();
        $occupiedShelves = Shelf::whereRaw('LOWER(shelf_status) = ?', ['occupied'])->count();

        $totalInventoryUnits = Inventory::sum('quantity_on_hand');

        $totalProducts = Product::count();

        $lowStockCount = Inventory::whereColumn('quantity_on_hand', '<=', 'reorder_level')->count();

        $expiringSoonCount = ProductBatch::whereNotNull('expiration_date')
            ->where('quantity_remaining', '>', 0)
            ->whereDate('expiration_date', '>=', $today)
            ->whereDate('expiration_date', '<=', $sevenDaysFromNow)
            ->count();

        $pendingRequestsCount = InventoryTransaction::whereRaw('LOWER(status) = ?', ['pending'])->count();

        $recentTransactions = InventoryTransaction::with(['shelf', 'renter'])
            ->latest('transaction_date')
            ->take(5)
            ->get()
            ->map(function ($trx) {
                return [
                    'date' => optional($trx->transaction_date)
                        ? Carbon::parse($trx->transaction_date)->format('Y-m-d h:i A')
                        : '-',
                    'reference' => $trx->reference_no ?? '-',
                    'type' => $trx->transaction_type ?? '-',
                    'shelf' => $trx->shelf?->shelf_number ?? '-',
                    'renter' => $trx->renter?->renter_company_name ?? '-',
                    'status' => $trx->status ?? '-',
                    'remarks' => $trx->remarks ?? '-',
                ];
            });

        return view('staff.dashboard', compact(
            'totalShelves',
            'occupiedShelves',
            'totalInventoryUnits',
            'totalProducts',
            'lowStockCount',
            'expiringSoonCount',
            'pendingRequestsCount',
            'recentTransactions'
        ));
    }
}