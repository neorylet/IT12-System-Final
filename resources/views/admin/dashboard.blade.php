@extends('layouts.app_a')

@section('title', 'Admin Dashboard')

@section('content')
<div class="dashboard-page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">
                Overview of renters, shelves, stock, and recent activity.
            </p>
        </div>
    </div>

    <div class="stats-grid">
        <div class="metric-card">
            <div class="metric-label">Active Renters</div>
            <div class="metric-value">{{ $activeRenters ?? 0 }}</div>
            <div class="metric-note">Lessees with active contracts</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Occupied Shelves</div>
            <div class="metric-value">{{ $occupiedShelves ?? 0 }} / {{ $totalShelves ?? 0 }}</div>
            <div class="metric-note">Occupied vs total shelves</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Total Inventory</div>
            <div class="metric-value">{{ $totalInventoryUnits ?? 0 }}</div>
            <div class="metric-note">Units currently in stock</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Inventory Retail Value</div>
            <div class="stat-value">₱{{ number_format($inventoryRetailValue ?? 0, 2) }}</div>
            <div class="stat-footer">Estimated value (qty × product price)</div>
        </div>
    </div>

    <div class="stats-grid secondary-grid">
        <div class="metric-card">
            <div class="metric-label">Low Stock Alerts</div>
            <div class="metric-value">{{ $lowStockCount ?? 0 }}</div>
            <div class="metric-note">Items below reorder level</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Expiring Soon</div>
            <div class="metric-value">{{ $expiringSoonCount ?? 0 }}</div>
            <div class="metric-note">Batches expiring within 7 days</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Pending Approvals</div>
            <div class="metric-value">{{ $pendingApprovalsCount ?? 0 }}</div>
            <div class="metric-note">Products or transactions waiting review</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Today's Sales</div>
            <div class="stat-value">₱{{ number_format($todaySalesTotal ?? 0, 2) }}</div>
            <div class="stat-footer">Sales recorded today</div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Recent Transactions</h2>
            <a href="/transactions" class="panel-link">View all</a>
        </div>

        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Reference</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Shelf</th>
                        <th>Renter</th>
                        <th>Actioned By</th>
                        <th class="text-right">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($recentTransactions ?? []) as $trx)
                        <tr>
                            <td>{{ $trx['date'] ?? '-' }}</td>
                            <td>{{ $trx['reference'] ?? '-' }}</td>
                            <td class="text-center">
                                <span class="status-chip">{{ $trx['type'] ?? '-' }}</span>
                            </td>
                            <td class="text-center">{{ $trx['shelf'] ?? '-' }}</td>
                            <td>{{ $trx['renter'] ?? '-' }}</td>
                            <td>{{ $trx['actioned_by'] ?? '-' }}</td>
                            <td class="text-right">{{ $trx['status'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-cell">No transactions yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection