<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\InventoryTransaction;
use App\Models\User;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $q      = trim((string) $request->query('q', ''));
        $user   = trim((string) $request->query('user', ''));
        $module = trim((string) $request->query('module', ''));
        $action = trim((string) $request->query('action', ''));
        $date   = trim((string) $request->query('date', ''));

        $logs = AuditLog::with('user')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('action', 'like', "%{$q}%")
                        ->orWhere('module', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhere('reference_no', 'like', "%{$q}%")
                        ->orWhereHas('user', function ($uq) use ($q) {
                            $uq->where('name', 'like', "%{$q}%");
                        });
                });
            })
            ->when($user, fn($query) => $query->where('user_id', $user))
            ->when($module, fn($query) => $query->where('module', $module))
            ->when($action, fn($query) => $query->where('action', $action))
            ->when($date, fn($query) => $query->whereDate('created_at', $date))
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        $totalLogs = AuditLog::count();
        $todayCount = AuditLog::whereDate('created_at', now()->toDateString())->count();
        $pendingApprovals = InventoryTransaction::where('status', 'Pending')->count();
        $stockMovements = AuditLog::whereIn('action', ['Stock In', 'Stock Out', 'Adjust'])->count();

        $users = User::orderBy('name')->get();
        $modules = AuditLog::select('module')->distinct()->orderBy('module')->pluck('module');
        $actions = AuditLog::select('action')->distinct()->orderBy('action')->pluck('action');

        return view('admin.logs.index', compact(
            'logs',
            'q',
            'user',
            'module',
            'action',
            'date',
            'totalLogs',
            'todayCount',
            'pendingApprovals',
            'stockMovements',
            'users',
            'modules',
            'actions'
        ));
    }
}