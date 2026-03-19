@extends('layouts.app_s')

@section('title', 'Staff Dashboard')

@section('content')
<div class="header-section">
    <h1>Dashboard</h1>
    <p>Quick overview of stock status, requests, and recent activity.</p>
</div>

<div class="cards-grid" style="margin-top:12px;">
    <div class="stat-card">
        <div class="stat-label">Total Inventory</div>
        <div class="stat-value">{{ $totalInventoryUnits ?? 0 }}</div>
        <div class="stat-footer">Units currently in stock</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Low Stock Alerts</div>
        <div class="stat-value">{{ $lowStockCount ?? 0 }}</div>
        <div class="stat-footer">Items below reorder level</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Expiring Soon</div>
        <div class="stat-value">{{ $expiringSoonCount ?? 0 }}</div>
        <div class="stat-footer">Batches expiring within 7 days</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Pending Requests</div>
        <div class="stat-value">{{ $pendingRequestsCount ?? 0 }}</div>
        <div class="stat-footer">Requests waiting for admin review</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Occupied Shelves</div>
        <div class="stat-value">{{ $occupiedShelves ?? 0 }} / {{ $totalShelves ?? 0 }}</div>
        <div class="stat-footer">Occupied vs total shelves</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Tracked Products</div>
        <div class="stat-value">{{ $totalProducts ?? 0 }}</div>
        <div class="stat-footer">Products currently visible in inventory</div>
    </div>
</div>

<div class="activity-section" style="margin-top:16px;">
    <div class="activity-header">Quick Actions</div>

    <div style="padding:20px; display:flex; flex-wrap:wrap; gap:12px;">
        <a href="{{ route('staff.inventory.stockin.create') }}" class="btn-primary">New Stock In Request</a>
        <a href="{{ route('staff.inventory.stockout.create') }}" class="btn-outline">New Stock Out Request</a>
        <a href="{{ route('staff.inventory.adjust.create') }}" class="btn-outline">New Adjustment Request</a>
        <a href="{{ route('staff.inventory.index') }}" class="btn-outline">Open Inventory</a>
    </div>
</div>

<div class="activity-section" style="margin-top:16px;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; padding:18px 20px 0;">
        <div class="activity-header" style="padding:0; margin:0;">Recent Activity</div>
        <a href="{{ route('staff.inventory.index') }}" class="btn-mini-outline">Open Inventory</a>
    </div>

    <div class="activity-table-scrollable" style="margin-top:14px;">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Reference</th>
                    <th>Type</th>
                    <th>Shelf</th>
                    <th>Renter</th>
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($recentTransactions ?? []) as $trx)
                    <tr>
                        <td>{{ $trx['date'] ?? '-' }}</td>
                        <td>{{ $trx['reference'] ?? '-' }}</td>
                        <td>
                            <span class="badge">{{ $trx['type'] ?? '-' }}</span>
                        </td>
                        <td>{{ $trx['shelf'] ?? '-' }}</td>
                        <td>{{ $trx['renter'] ?? '-' }}</td>
                        <td>{{ $trx['status'] ?? '-' }}</td>
                        <td>{{ $trx['remarks'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">No recent activity yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection