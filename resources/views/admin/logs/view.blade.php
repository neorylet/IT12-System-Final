@extends('layouts.app_a')
@section('title', 'View Audit Log')

@section('content')
<div class="header-section">
    <h1>Audit Log Details</h1>
    <p>View the full details of a recorded activity, including affected records and placeholder change history.</p>
</div>

<div class="form-page-wrap">
    <div class="detail-shell">

        <div class="detail-card">
            <div class="detail-card-header">
                <h2 class="detail-card-title">Activity Information</h2>
                <p class="detail-card-subtitle">Basic details of the selected audit record.</p>
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Log ID</div>
                    <div class="detail-value">#LOG-0001</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Date & Time</div>
                    <div class="detail-value">2026-03-06 09:15 AM</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">User</div>
                    <div class="detail-value">Admin User</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Role</div>
                    <div class="detail-value">Administrator</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Action</div>
                    <div class="detail-value">Update</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Module</div>
                    <div class="detail-value">Products</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Affected Record</div>
                    <div class="detail-value">#PRD-102</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Reference No.</div>
                    <div class="detail-value">REF-2026-000124</div>
                </div>

                <div class="detail-item detail-item-full">
                    <div class="detail-label">Description</div>
                    <div class="detail-value" style="min-height:64px; align-items:flex-start; padding-top:12px; padding-bottom:12px;">
                        Updated product price and reorder level after inventory review.
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-card" style="margin-top:16px;">
            <div class="detail-card-header">
                <h2 class="detail-card-title">Affected Context</h2>
                <p class="detail-card-subtitle">Placeholder details for related shelf, renter, and module references.</p>
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Shelf</div>
                    <div class="detail-value">Shelf 3</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Renter</div>
                    <div class="detail-value">Casa Leticia Boutique Vendor</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">Completed</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Approval State</div>
                    <div class="detail-value">Approved</div>
                </div>
            </div>
        </div>

        <div class="activity-section" style="margin:16px 0 0;">
            <div class="activity-header">Field Changes</div>

            <div class="activity-table-scrollable">
                <table class="activity-table">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Price</td>
                            <td>₱120.00</td>
                            <td>₱150.00</td>
                        </tr>
                        <tr>
                            <td>Reorder Level</td>
                            <td>5</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>Active</td>
                            <td>Active</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="detail-card" style="margin-top:16px;">
            <div class="detail-card-header">
                <h2 class="detail-card-title">Technical Details</h2>
                <p class="detail-card-subtitle">Optional system metadata placeholder for future backend integration.</p>
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">IP Address</div>
                    <div class="detail-value">192.168.1.12</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Device / Browser</div>
                    <div class="detail-value">Chrome on Windows</div>
                </div>

                <div class="detail-item detail-item-full">
                    <div class="detail-label">Remarks</div>
                    <div class="detail-value" style="min-height:64px; align-items:flex-start; padding-top:12px; padding-bottom:12px;">
                        Placeholder only. Later this can store notes, reason for change, approval comments, or automatic system descriptions.
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions" style="padding-bottom: 10px;">
            <a href="{{ route('admin.logs.index') }}" class="btn-outline">Back to Logs</a>
        </div>
    </div>
</div>
@endsection