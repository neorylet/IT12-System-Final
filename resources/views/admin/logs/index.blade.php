@extends('layouts.app_a')
@section('title', 'Audit Logs')

@section('content')
<div class="header-section">
    <h1>Audit Logs</h1>
    <p>Track system activities, approvals, edits, stock movements, and other important transactions.</p>
</div>

<div class="toolbar">
    <form method="GET" action="#" class="search-form">
        <input
            class="input-field"
            type="text"
            name="q"
            placeholder="Search user, module, action, or description..."
        >

        <select class="input-field" name="user" style="min-width: 180px;">
            <option value="">All Users</option>
            <option>Admin User</option>
            <option>Staff User</option>
            <option>Renter User</option>
        </select>

        <select class="input-field" name="module" style="min-width: 180px;">
            <option value="">All Modules</option>
            <option>Products</option>
            <option>Inventory</option>
            <option>Shelves</option>
            <option>Renters</option>
            <option>Contracts</option>
            <option>Payments</option>
            <option>Approvals</option>
        </select>

        <select class="input-field" name="action" style="min-width: 180px;">
            <option value="">All Actions</option>
            <option>Create</option>
            <option>Update</option>
            <option>Delete</option>
            <option>Stock In</option>
            <option>Stock Out</option>
            <option>Adjust</option>
            <option>Approve</option>
            <option>Reject</option>
        </select>

        <input class="input-field" type="date" name="date" style="min-width: 180px;">

        <button class="btn-outline" type="submit">Filter</button>
    </form>
</div>

<div class="cards-grid" style="margin-top:12px;">
    <div class="stat-card">
        <div class="stat-label">Total Logs</div>
        <div class="stat-value">1,248</div>
        <div class="stat-footer">All recorded system activities</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Today’s Activity</div>
        <div class="stat-value">37</div>
        <div class="stat-footer">Logs created today</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Pending Approvals</div>
        <div class="stat-value">12</div>
        <div class="stat-footer">Requests awaiting review</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Stock Movements</div>
        <div class="stat-value">84</div>
        <div class="stat-footer">Stock in, out, and adjustments</div>
    </div>
</div>

<div class="activity-section" style="margin-top:16px;">
    <div class="activity-header">Recent Audit Records</div>

    <div class="activity-table-scrollable">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Action</th>
                    <th>Module</th>
                    <th>Record</th>
                    <th>Description</th>
                    <th style="text-align:center;">View</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2026-03-06 09:15 AM</td>
                    <td>Admin User</td>
                    <td><span class="badge">Admin</span></td>
                    <td><span class="badge">Update</span></td>
                    <td>Products</td>
                    <td>#PRD-102</td>
                    <td>Updated product price and reorder level.</td>
                    <td style="text-align:center;">
                        <a href="{{ route('admin.logs.view', 1) }}" class="btn-mini-outline">View</a>
                    </td>
                </tr>

                <tr>
                    <td>2026-03-06 09:42 AM</td>
                    <td>Staff User</td>
                    <td><span class="badge">Staff</span></td>
                    <td><span class="badge">Stock In</span></td>
                    <td>Inventory</td>
                    <td>#INV-245</td>
                    <td>Added 20 units to Shelf 3 inventory.</td>
                    <td style="text-align:center;">
                        <a href="{{ route('admin.logs.view', 2) }}" class="btn-mini-outline">View</a>
                    </td>
                </tr>

                <tr>
                    <td>2026-03-06 10:05 AM</td>
                    <td>Renter User</td>
                    <td><span class="badge">Renter</span></td>
                    <td><span class="badge">Request</span></td>
                    <td>Approvals</td>
                    <td>#REQ-031</td>
                    <td>Submitted stock in request for review.</td>
                    <td style="text-align:center;">
                        <a href="{{ route('admin.logs.view', 3) }}" class="btn-mini-outline">View</a>
                    </td>
                </tr>

                <tr>
                    <td>2026-03-06 10:21 AM</td>
                    <td>Admin User</td>
                    <td><span class="badge">Admin</span></td>
                    <td><span class="badge">Approve</span></td>
                    <td>Approvals</td>
                    <td>#REQ-031</td>
                    <td>Approved restocking request for Shelf 3.</td>
                    <td style="text-align:center;">
                        <a href="{{ route('admin.logs.view', 4) }}" class="btn-mini-outline">View</a>
                    </td>
                </tr>

                <tr>
                    <td>2026-03-06 11:00 AM</td>
                    <td>Admin User</td>
                    <td><span class="badge">Admin</span></td>
                    <td><span class="badge">Contract</span></td>
                    <td>Contracts</td>
                    <td>#CTR-014</td>
                    <td>Updated renter contract end date and monthly fee.</td>
                    <td style="text-align:center;">
                        <a href="{{ route('admin.logs.view', 5) }}" class="btn-mini-outline">View</a>
                    </td>
                </tr>

                <tr>
                    <td>2026-03-06 11:28 AM</td>
                    <td>Staff User</td>
                    <td><span class="badge">Staff</span></td>
                    <td><span class="badge">Adjust</span></td>
                    <td>Inventory</td>
                    <td>#ADJ-008</td>
                    <td>Adjusted quantity after physical stock count discrepancy.</td>
                    <td style="text-align:center;">
                        <a href="{{ route('admin.logs.view', 6) }}" class="btn-mini-outline">View</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div style="margin: 14px 28px 28px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
    <div style="font-size:13px; color:#6b7280;">
        Showing 1 to 6 of 1,248 logs
    </div>

    <div style="display:flex; gap:8px;">
        <button class="btn-outline" type="button">Previous</button>
        <button class="btn-primary" type="button">1</button>
        <button class="btn-outline" type="button">2</button>
        <button class="btn-outline" type="button">3</button>
        <button class="btn-outline" type="button">Next</button>
    </div>
</div>
@endsection