@extends('layouts.app_a')
@section('title', 'Renter Payouts')

@section('content')

<div class="header-section">
    <h1>Renter Payouts</h1>
    <p>Record payouts to renters based on sales settlement.</p>
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
               placeholder="Search renter, payout ref, date...">
        <button type="submit" class="btn-outline">Search</button>
    </form>

    <a href="#" class="btn-primary" onclick="alert('Create Payout - coming soon'); return false;">
        + Create Payout
    </a>
</div>

<div class="cards-grid">
    <div class="stat-card">
        <div class="stat-label">Paid This Month</div>
        <div class="stat-value">₱0.00</div>
        <div class="stat-footer">Placeholder</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Pending Approval</div>
        <div class="stat-value">0</div>
        <div class="stat-footer">Waiting approval</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Unpaid Balances</div>
        <div class="stat-value">₱0.00</div>
        <div class="stat-footer">Settlement needed</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Payouts</div>
        <div class="stat-value">0</div>
        <div class="stat-footer">All payout records</div>
    </div>
</div>

<div class="activity-section" style="margin-top:12px;">
    <div class="activity-header">Payout Records</div>

    <div class="activity-table-scrollable">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Renter</th>
                    <th>Period</th>
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
                        <a href="#" class="btn-mini-outline" title="Approve" onclick="alert('Approve - coming soon'); return false;">
                            <i data-lucide="check-circle-2" width="16" height="16"></i>
                        </a>
                        <button class="btn-danger-mini" title="Delete" onclick="alert('Delete - coming soon'); return false;">
                            <i data-lucide="trash-2" width="16" height="16"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td colspan="7" class="empty-state">
                        No renter payouts yet.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection