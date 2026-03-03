@extends('layouts.app_a')
@section('title', 'Rental Payments')

@section('content')

<div class="header-section">
    <h1>Rental Payments</h1>
    <p>Track and verify shelf rental payments.</p>
</div>

@if(session('success'))
    <div class="success-box">
        {{ session('success') }}
    </div>
@endif

<div class="toolbar">
    <form method="GET" action="#" class="search-form">
        <input class="input-field"
               name="q"
               value="{{ request('q') }}"
               placeholder="Search renter, reference no., shelf...">
        <button type="submit" class="btn-outline">Search</button>
    </form>

    <a href="#" class="btn-primary" onclick="alert('Add Payment - coming soon'); return false;">
        + Add Payment
    </a>
</div>

<div class="cards-grid">
    <div class="stat-card">
        <div class="stat-label">Collected This Month</div>
        <div class="stat-value">₱0.00</div>
        <div class="stat-footer">Placeholder</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Pending Verification</div>
        <div class="stat-value">0</div>
        <div class="stat-footer">Payments waiting approval</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Overdue</div>
        <div class="stat-value">0</div>
        <div class="stat-footer">Contracts past due</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Records</div>
        <div class="stat-value">0</div>
        <div class="stat-footer">All payments logged</div>
    </div>
</div>

<div class="activity-section" style="margin-top:12px;">
    <div class="activity-header">Payment Records</div>

    <div class="activity-table-scrollable">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Renter</th>
                    <th>Shelf</th>
                    <th>Reference</th>
                    <th style="text-align:right;">Amount</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- FRONT-END ONLY PLACEHOLDERS --}}
                <tr>
                    <td>—</td>
                    <td>—</td>
                    <td>—</td>
                    <td>—</td>
                    <td style="text-align:right;">₱0.00</td>
                    <td><span class="badge">PENDING</span></td>
                    <td style="text-align:right; white-space:nowrap;">
                        <a href="#" class="btn-mini-outline" title="View" onclick="alert('View - coming soon'); return false;">
                            <i data-lucide="eye" width="16" height="16"></i>
                        </a>
                        <a href="#" class="btn-mini-outline" title="Verify" onclick="alert('Verify - coming soon'); return false;">
                            <i data-lucide="badge-check" width="16" height="16"></i>
                        </a>
                        <button class="btn-danger-mini" title="Delete" onclick="alert('Delete - coming soon'); return false;">
                            <i data-lucide="trash-2" width="16" height="16"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td colspan="7" class="empty-state">
                        No rental payments yet.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection