@extends('layouts.app_a')

@section('title', 'Admin Dashboard')

@section('content')
<div class="header-section">
    <h1>Dashboard</h1>
    <p>Overview of renters, shelves, stock, and inventory activity.</p>
</div>

<div class="cards-grid" style="margin-top:12px;">
    <div class="stat-card">
        <div class="stat-label">Active Renters</div>
        <div class="stat-value">{{ $activeRenters ?? 0 }}</div>
        <div class="stat-footer">Lessees with active contracts</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Occupied Shelves</div>
        <div class="stat-value">{{ $occupiedShelves ?? 0 }} / {{ $totalShelves ?? 0 }}</div>
        <div class="stat-footer">Occupied vs total shelves</div>
    </div>

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
        <div class="stat-label">Pending Approvals</div>
        <div class="stat-value">{{ $pendingApprovalsCount ?? 0 }}</div>
        <div class="stat-footer">Transactions waiting for review</div>
    </div>
</div>

<div class="activity-section" style="margin-top:16px;">
    <div class="activity-header">Quick Actions</div>

    <div style="padding:20px; display:flex; flex-wrap:wrap; gap:12px;">
        <a href="{{ route('admin.renters.create') }}" class="btn-primary">+ Add Renter</a>
        <a href="{{ route('admin.shelves.create') }}" class="btn-outline">+ Add Shelf</a>
        <a href="{{ route('admin.products.create') }}" class="btn-outline">+ Add Product</a>
        <a href="{{ route('admin.inventory.stockin.create') }}" class="btn-outline">Stock In</a>
        <a href="{{ route('admin.inventory.stockout.create') }}" class="btn-outline">Stock Out</a>
        <a href="{{ route('admin.inventory.adjust.create') }}" class="btn-outline">Adjustment</a>
        <a href="{{ route('admin.inventory.pending') }}" class="btn-outline">Pending Approvals</a>
        <a href="{{ route('admin.logs.index') }}" class="btn-outline">Audit Logs</a>
    </div>
</div>

<div class="activity-section" style="margin-top:16px;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; padding:18px 20px 0;">
        <div class="activity-header" style="padding:0; margin:0;">Recent Activities</div>
        <a href="{{ route('admin.logs.index') }}" class="btn-mini-outline">View Audit Logs</a>
    </div>

    <div class="activity-table-scrollable" style="margin-top:14px;">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Module</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($recentActivities ?? []) as $log)
                    <tr>
                        <td>{{ $log['date'] ?? '-' }}</td>
                        <td>{{ $log['user'] ?? 'System' }}</td>
                        <td>
                            <span class="badge">{{ $log['action'] ?? '-' }}</span>
                        </td>
                        <td>{{ $log['module'] ?? '-' }}</td>
                        <td>{{ $log['description'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No recent activities yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection