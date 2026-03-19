<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Renter;
use App\Models\Shelf;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\ProductBatch;
use App\Models\AuditLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $sevenDaysFromNow = Carbon::today()->addDays(7);

        $activeRenters = Renter::whereRaw('LOWER(status) = ?', ['active'])->count();

        $totalShelves = Shelf::count();
        $occupiedShelves = Shelf::whereRaw('LOWER(shelf_status) = ?', ['occupied'])->count();

        $totalInventoryUnits = Inventory::sum('quantity_on_hand');

        $lowStockCount = Inventory::whereColumn('quantity_on_hand', '<=', 'reorder_level')->count();

        $expiringSoonCount = ProductBatch::whereNotNull('expiration_date')
            ->where('quantity_remaining', '>', 0)
            ->whereDate('expiration_date', '>=', $today)
            ->whereDate('expiration_date', '<=', $sevenDaysFromNow)
            ->count();

        $pendingApprovalsCount = InventoryTransaction::whereRaw('LOWER(status) = ?', ['pending'])->count();

        $recentActivities = AuditLog::with('user')
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function ($log) {
                return [
                    'date' => optional($log->created_at)->format('Y-m-d h:i A'),
                    'user' => optional($log->user)->name ?? 'System',
                    'action' => $log->action ?? '-',
                    'module' => $log->module ?? '-',
                    'description' => $log->description ?? '-',
                ];
            });

        return view('admin.dashboard', compact(
            'activeRenters',
            'totalShelves',
            'occupiedShelves',
            'totalInventoryUnits',
            'lowStockCount',
            'expiringSoonCount',
            'pendingApprovalsCount',
            'recentActivities'
        ));
    }
}