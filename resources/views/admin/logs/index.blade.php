@extends('layouts.app_a')
@section('title', 'Audit Logs')

@section('content')
<div class="header-section">
    <h1>Audit Logs</h1>
    <p>Track system activities, approvals, edits, stock movements, and other important transactions.</p>
</div>

<div class="toolbar">
    <form method="GET" action="{{ route('admin.logs.index') }}" class="search-form audit-filter-form">
        <input
            class="input-field"
            type="text"
            name="q"
            value="{{ $q ?? '' }}"
            placeholder="Search user, module, action, or description..."
        >

        <select class="input-field audit-filter-select" name="user">
            <option value="">All Users</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}" {{ (string)($user ?? '') === (string)$u->id ? 'selected' : '' }}>
                    {{ $u->name }}
                </option>
            @endforeach
        </select>

        <select class="input-field audit-filter-select" name="module">
            <option value="">All Modules</option>
            @foreach($modules as $m)
                <option value="{{ $m }}" {{ ($module ?? '') === $m ? 'selected' : '' }}>
                    {{ $m }}
                </option>
            @endforeach
        </select>

        <select class="input-field audit-filter-select" name="action">
            <option value="">All Actions</option>
            @foreach($actions as $a)
                <option value="{{ $a }}" {{ ($action ?? '') === $a ? 'selected' : '' }}>
                    {{ $a }}
                </option>
            @endforeach
        </select>

        <input
            class="input-field audit-filter-date"
            type="date"
            name="date"
            value="{{ $date ?? '' }}"
        >

        <button class="btn-outline" type="submit">Filter</button>
    </form>
</div>

<div class="cards-grid audit-cards-grid">
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

<div class="activity-section audit-logs-section">
    <div class="activity-header">Recent Audit Records</div>

    <div class="activity-table-scrollable">
        <table class="activity-table audit-logs-table">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Action</th>
                    <th>Module</th>
                    <th>Record</th>
                    <th>Description</th>
                    <th class="text-center">View</th>
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
                        <td class="text-center">
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

<div class="pagination-wrap">
    <div class="pagination-meta">
        Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} logs
    </div>

    @if ($logs->hasPages())
        <div class="pagination-bar">
            @if ($logs->onFirstPage())
                <span class="pagination-btn pagination-btn-disabled">Previous</span>
            @else
                <a href="{{ $logs->appends(request()->query())->previousPageUrl() }}" class="pagination-btn">Previous</a>
            @endif

            @php
                $current = $logs->currentPage();
                $last = $logs->lastPage();
                $start = max(1, $current - 2);
                $end = min($last, $current + 2);
            @endphp

            @if ($start > 1)
                <a href="{{ $logs->appends(request()->query())->url(1) }}" class="pagination-btn">1</a>
                @if ($start > 2)
                    <span class="pagination-ellipsis">…</span>
                @endif
            @endif

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $current)
                    <span class="pagination-btn pagination-btn-active">{{ $page }}</span>
                @else
                    <a href="{{ $logs->appends(request()->query())->url($page) }}" class="pagination-btn">{{ $page }}</a>
                @endif
            @endfor

            @if ($end < $last)
                @if ($end < $last - 1)
                    <span class="pagination-ellipsis">…</span>
                @endif
                <a href="{{ $logs->appends(request()->query())->url($last) }}" class="pagination-btn">{{ $last }}</a>
            @endif

            @if ($logs->hasMorePages())
                <a href="{{ $logs->appends(request()->query())->nextPageUrl() }}" class="pagination-btn">Next</a>
            @else
                <span class="pagination-btn pagination-btn-disabled">Next</span>
            @endif
        </div>
    @endif
</div>

<div class="modal-backdrop" id="auditLogModal" style="display:none;">
    <div class="modal-card audit-log-modal" role="dialog" aria-modal="true" aria-labelledby="auditLogModalTitle">
        <div class="modal-head audit-log-modal-head">
            <div>
                <div class="modal-title" id="auditLogModalTitle">Audit Log Details</div>
                <div class="modal-sub">View full activity information</div>
            </div>
            <button class="modal-close" type="button" id="auditLogModalClose">✕</button>
        </div>

        <div class="modal-body audit-log-modal-body">
            <div class="audit-log-detail-wrap">
                <table class="activity-table audit-log-detail-table">
                    <tbody>
                        <tr>
                            <th>Date & Time</th>
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

        <div class="modal-foot audit-log-modal-foot">
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