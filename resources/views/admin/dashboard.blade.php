@extends('layouts.app_a')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="header-section">
        <h1>Dashboard</h1>
        <p style="margin: 6px 0 0; opacity: .75;">
            Overview of renters, shelves, stock, and recent activity.
        </p>
    </div>

    {{-- KPI CARDS --}}
    <div class="cards-grid">
        <div class="stat-card">
            <div class="stat-label">Active Renters</div>
            <div class="stat-value">{{ $activeRenters ?? 0 }}</div>
            <div class="stat-footer">Lessees with active contracts</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Occupied Shelves</div>
            <div class="stat-value">
                {{ $occupiedShelves ?? 0 }} / {{ $totalShelves ?? 0 }}
            </div>
            <div class="stat-footer">Occupied vs total shelves</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Total Inventory</div>
            <div class="stat-value">{{ $totalInventoryUnits ?? 0 }}</div>
            <div class="stat-footer">Units currently in stock</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Inventory Retail Value</div>
            <div class="stat-value">₱{{ number_format($inventoryRetailValue ?? 0, 2) }}</div>
            <div class="stat-footer">Estimated value (qty × product price)</div>
        </div>
    </div>

    {{-- ALERTS / ATTENTION --}}
    <div class="cards-grid" style="margin-top: 14px;">
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
            <div class="stat-footer">Products / transactions waiting review</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Today's Sales</div>
            <div class="stat-value">₱{{ number_format($todaySalesTotal ?? 0, 2) }}</div>
            <div class="stat-footer">Sales recorded today</div>
        </div>
    </div>

    {{-- RECENT INVENTORY TRANSACTIONS --}}
    <div class="activity-section">
        <div class="activity-header" style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
            <span>Recent Transactions</span>
            <a href="/transactions" style="font-size:12px; text-decoration:none;">
                View all →
            </a>
        </div>

        <div class="activity-table-scrollable">
            <table class="activity-table">
                <thead>
                    <tr style="border-bottom: 2px solid #f4f1ee;">
                        <th style="text-align: left; padding: 12px 15px; width: 14%;">Date</th>
                        <th style="text-align: left; padding: 12px 15px; width: 14%;">Reference</th>
                        <th style="text-align: center; padding: 12px 15px; width: 8%;">Type</th>
                        <th style="text-align: center; padding: 12px 15px; width: 8%;">Shelf</th>
                        <th style="text-align: left; padding: 12px 15px; width: 20%;">Renter</th>
                        <th style="text-align: left; padding: 12px 15px; width: 18%;">Actioned By</th>
                        <th style="text-align: right; padding: 12px 15px; width: 10%;">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse(($recentTransactions ?? []) as $trx)
                        <tr>
                            <td>{{ $trx['date'] ?? '-' }}</td>
                            <td>{{ $trx['reference'] ?? '-' }}</td>
                            <td style="text-align:center;">
                                <span class="badge">{{ $trx['type'] ?? '-' }}</span>
                            </td>
                            <td style="text-align:center;">{{ $trx['shelf'] ?? '-' }}</td>
                            <td>{{ $trx['renter'] ?? '-' }}</td>
                            <td>{{ $trx['actioned_by'] ?? '-' }}</td>
                            <td style="text-align:right;">{{ $trx['status'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="7" class="empty-state"
                                style="text-align: center; padding: 2rem; background: #fcfaf8;">
                                No transactions yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection