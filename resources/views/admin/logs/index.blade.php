@extends('layouts.app_a')
@section('title', 'Audit Logs')

@section('content')
<div class="header-section">
    <h1>Audit Logs</h1>
    <p>Track system activities, approvals, edits, stock movements, and other important transactions.</p>
</div>

<div class="toolbar">
    <form method="GET" action="{{ route('admin.logs.index') }}" class="search-form">
        <input
            class="input-field"
            type="text"
            name="q"
            value="{{ $q ?? '' }}"
            placeholder="Search user, module, action, or description..."
        >

        <select class="input-field" name="user" style="min-width: 180px;">
            <option value="">All Users</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}" {{ (string)($user ?? '') === (string)$u->id ? 'selected' : '' }}>
                    {{ $u->name }}
                </option>
            @endforeach
        </select>

        <select class="input-field" name="module" style="min-width: 180px;">
            <option value="">All Modules</option>
            @foreach($modules as $m)
                <option value="{{ $m }}" {{ ($module ?? '') === $m ? 'selected' : '' }}>
                    {{ $m }}
                </option>
            @endforeach
        </select>

        <select class="input-field" name="action" style="min-width: 180px;">
            <option value="">All Actions</option>
            @foreach($actions as $a)
                <option value="{{ $a }}" {{ ($action ?? '') === $a ? 'selected' : '' }}>
                    {{ $a }}
                </option>
            @endforeach
        </select>

        <input
            class="input-field"
            type="date"
            name="date"
            value="{{ $date ?? '' }}"
            style="min-width: 180px;"
        >

        <button class="btn-outline" type="submit">Filter</button>
    </form>
</div>

<div class="cards-grid" style="margin-top:12px;">
    <div class="stat-card">
        <div class="stat-label">Total Logs</div>
        <div class="stat-value">{{ number_format($totalLogs) }}</div>
        <div class="stat-footer">All recorded system activities</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Today’s Activity</div>
        <div class="stat-value">{{ $todayCount }}</div>
        <div class="stat-footer">Logs created today</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Pending Approvals</div>
        <div class="stat-value">{{ $pendingApprovals }}</div>
        <div class="stat-footer">Requests awaiting review</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Stock Movements</div>
        <div class="stat-value">{{ $stockMovements }}</div>
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
                @forelse($logs as $log)
                    <tr>
                        <td>{{ optional($log->created_at)->format('Y-m-d h:i A') }}</td>
                        <td>{{ $log->user->name ?? 'System' }}</td>
                        <td>
                            <span class="badge">{{ $log->user->role ?? 'System' }}</span>
                        </td>
                        <td>
                            <span class="badge">{{ $log->action }}</span>
                        </td>
                        <td>{{ $log->module }}</td>
                        <td>{{ $log->reference_no ?? '-' }}</td>
                        <td>{{ $log->description }}</td>
                        <td style="text-align:center;">
                            <button
                                type="button"
                                class="btn-mini-outline"
                                onclick="openAuditModal(
                                    @js(optional($log->created_at)->format('Y-m-d h:i A')),
                                    @js($log->user->name ?? 'System'),
                                    @js($log->user->role ?? 'System'),
                                    @js($log->action),
                                    @js($log->module),
                                    @js($log->reference_no ?? '-'),
                                    @js($log->description),
                                    @js($log->ip_address ?? '-')
                                )"
                            >
                                View
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">No audit logs recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin: 14px 28px 28px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
    <div style="font-size:13px; color:#6b7280;">
        Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} logs
    </div>

    <div>
        {{ $logs->links() }}
    </div>
</div>

<div class="modal-backdrop" id="auditLogModal" style="display:none;">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="auditLogModalTitle"
         style="max-width: 860px; width:min(94vw, 860px); padding:0; overflow:hidden;">

        <div class="modal-head" style="padding:16px 20px; border-bottom:1px solid #efe5da;">
            <div>
                <div class="modal-title" id="auditLogModalTitle">Audit Log Details</div>
                <div class="modal-sub">View full activity information</div>
            </div>
            <button class="modal-close" type="button" id="auditLogModalClose">✕</button>
        </div>

        <div class="modal-body" style="padding:20px;">
            <div class="activity-table-scrollable" style="border:1px solid #efe5da; border-radius:12px; overflow:hidden;">
                <table class="activity-table">
                    <tbody>
                        <tr>
                            <th style="width:220px;">Date & Time</th>
                            <td id="modalLogDate">—</td>
                        </tr>
                        <tr>
                            <th>User</th>
                            <td id="modalLogUser">—</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td id="modalLogRole">—</td>
                        </tr>
                        <tr>
                            <th>Action</th>
                            <td id="modalLogAction">—</td>
                        </tr>
                        <tr>
                            <th>Module</th>
                            <td id="modalLogModule">—</td>
                        </tr>
                        <tr>
                            <th>Record</th>
                            <td id="modalLogRecord">—</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td id="modalLogDescription">—</td>
                        </tr>
                        <tr>
                            <th>IP Address</th>
                            <td id="modalLogIp">—</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-foot" style="padding:14px 20px; border-top:1px solid #efe5da; display:flex; justify-content:flex-end; gap:10px;">
            <button class="btn-outline" type="button" id="auditLogModalOk">Close</button>
        </div>
    </div>
</div>

<script>
    function openAuditModal(date, user, role, action, module, record, description, ip) {
        document.getElementById('modalLogDate').innerText = date || '—';
        document.getElementById('modalLogUser').innerText = user || '—';
        document.getElementById('modalLogRole').innerText = role || '—';
        document.getElementById('modalLogAction').innerText = action || '—';
        document.getElementById('modalLogModule').innerText = module || '—';
        document.getElementById('modalLogRecord').innerText = record || '—';
        document.getElementById('modalLogDescription').innerText = description || '—';
        document.getElementById('modalLogIp').innerText = ip || '—';

        document.getElementById('auditLogModal').style.display = 'flex';
    }

    function closeAuditModal() {
        document.getElementById('auditLogModal').style.display = 'none';
    }

    document.getElementById('auditLogModalClose').addEventListener('click', closeAuditModal);
    document.getElementById('auditLogModalOk').addEventListener('click', closeAuditModal);

    document.getElementById('auditLogModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAuditModal();
        }
    });
</script>
@endsection