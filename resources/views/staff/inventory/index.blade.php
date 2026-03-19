@extends('layouts.app_s')
@section('title', 'Inventory')

@section('content')

<style>
    .inventory-page {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .inventory-topbar {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .inventory-cards-grid {
        margin-top: 4px;
    }

    .panel {
        background: #fff;
        border: 1px solid #efe5da;
        border-radius: 16px;
        overflow: hidden;
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding: 16px 18px;
        border-bottom: 1px solid #f3e8dd;
        background: #fffdf9;
    }

    .panel-title-wrap {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .panel-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #3b2f2f;
    }

    .panel-subtitle {
        margin: 0;
        font-size: 12px;
        color: #8b7b70;
    }

    .panel-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .panel-body {
        padding: 16px 18px;
    }

    .panel-body.no-pad {
        padding: 0;
    }

    .panel-scroll {
        overflow: auto;
    }

    .panel-scroll.shelves-scroll {
        max-height: min(58vh, 420px);
        padding: 12px;
    }

    .panel-scroll.expiry-scroll {
        max-height: min(55vh, 340px);
    }

    .panel-scroll.transactions-scroll {
        max-height: min(55vh, 300px);
    }

    .stack-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .shelf-card {
        background: #fffdf9;
        border: 1px solid #efe5da;
        border-radius: 14px;
        padding: 14px 16px;
    }

    .shelf-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 14px;
        flex-wrap: wrap;
    }

    .shelf-card-main {
        min-width: 240px;
    }

    .shelf-title {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        font-size: 15px;
        color: #2f2a26;
    }

    .shelf-sub {
        margin-top: 6px;
        font-size: 13px;
        color: #7b6d63;
    }

    .shelf-stats {
        display: flex;
        align-items: stretch;
        gap: 10px;
        flex-wrap: wrap;
    }

    .mini-stat {
        min-width: 76px;
        background: #fff;
        border: 1px solid #efe5da;
        border-radius: 12px;
        padding: 10px 12px;
    }

    .mini-label {
        font-size: 11px;
        color: #8b7b70;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .mini-value {
        margin-top: 4px;
        font-size: 18px;
        font-weight: 700;
        color: #3b2f2f;
    }

    .inventory-filter-form,
    .expiry-filter-form {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .quick-actions-row {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .card-link-reset {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .stat-card-highlight {
        border-color: #d6a77a !important;
        background: #fffaf5 !important;
    }

    .stat-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
    }

    .panel-toggle {
        border: 1px solid #e7d8ca;
        background: #fff;
        color: #5c4636;
        border-radius: 10px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .panel-toggle:hover {
        background: #fff7ee;
    }

    .panel.is-collapsed .panel-body,
    .panel.is-collapsed .panel-scroll,
    .panel.is-collapsed .panel-header + .panel-body,
    .panel.is-collapsed .panel-header + .panel-scroll {
        display: none;
    }

    .modal-card-lg {
        max-width: 860px;
        width: min(94vw, 860px);
        padding: 0;
        overflow: hidden;
    }

    .modal-head-clean {
        padding: 16px 20px;
        border-bottom: 1px solid #efe5da;
    }

    .modal-action-row-clean {
        padding: 14px 20px 0;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .modal-body-clean {
        padding: 20px;
    }

    .modal-foot-clean {
        padding: 14px 20px;
        border-top: 1px solid #efe5da;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .modal-table-wrap {
        border: 1px solid #efe5da;
        border-radius: 12px;
        overflow: hidden;
    }

    .align-right {
        text-align: right;
    }

    .align-center {
        text-align: center;
    }

    .muted-text {
        font-size: 12px;
        color: #8b7b70;
    }

    .w-180 {
        min-width: 180px;
    }
</style>

<div class="inventory-page">

    <div class="inventory-topbar">
        <div class="header-section">
            <h1>Inventory</h1>
            <p>View shelf items and submit inventory requests for admin approval.</p>
        </div>

        @if(session('success'))
            <div class="success-box">{{ session('success') }}</div>
        @endif

        <div class="toolbar">
            <form method="GET" action="{{ route('staff.inventory.index') }}" class="search-form inventory-filter-form">
                <input class="input-field" name="q" value="{{ $q ?? '' }}" placeholder="Search shelf, renter, product...">
                <button class="btn-outline" type="submit">Search</button>
                @if(!empty($q))
                    <a href="{{ route('staff.inventory.index') }}" class="btn-outline">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <div class="inventory-cards-grid">
        <div class="stat-card">
            <div class="stat-label">Total Products</div>
            <div class="stat-value">{{ $totalProducts ?? 0 }}</div>
            <div class="stat-footer">Catalog items across all shelves</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Total Stock</div>
            <div class="stat-value">{{ $totalQty ?? 0 }}</div>
            <div class="stat-footer">Units currently on hand</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Low Stock Alerts</div>
            <div class="stat-value">{{ $lowStockCount ?? 0 }}</div>
            <div class="stat-footer">Items at or below reorder level</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Expiring Soon</div>
            <div class="stat-value">{{ $expiringSoon ?? 0 }}</div>
            <div class="stat-footer">Batches expiring within 7 days</div>
        </div>

        <div class="stat-card {{ ($pendingRequests ?? 0) > 0 ? 'stat-card-highlight' : '' }}">
            <div class="stat-card-top">
                <div>
                    <div class="stat-label">Pending Requests</div>
                    <div class="stat-value">{{ $pendingRequests ?? 0 }}</div>
                </div>

                <span class="btn-action-chip">
                    Review
                </span>
            </div>

            <div class="stat-footer">
                @if(($pendingRequests ?? 0) > 0)
                    Recent requests are still awaiting admin review
                @else
                    No pending requests right now
                @endif
            </div>
        </div>
    </div>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-title-wrap">
                <h2 class="panel-title">Quick Actions</h2>
                <p class="panel-subtitle">Start common inventory tasks.</p>
            </div>
        </div>

        <div class="panel-body">
            <div class="quick-actions-row">
                <a href="{{ route('staff.inventory.stockin.create') }}" class="btn-action-chip">
                    New Stock In Request
                </a>

                <a href="{{ route('staff.inventory.stockout.create') }}" class="btn-action-chip">
                    New Stock Out Request
                </a>

                <a href="{{ route('staff.inventory.adjust.create') }}" class="btn-action-chip">
                    New Adjustment Request
                </a>
            </div>
        </div>
    </section>

    {{-- SHELVES --}}
    <section class="panel js-collapsible-panel" data-panel="shelves">
        <div class="panel-header">
            <div class="panel-title-wrap">
                <h2 class="panel-title">Shelves</h2>
                <p class="panel-subtitle">Shelf assignment, renter info, and stock summary.</p>
            </div>

            <div class="panel-actions">
                <button type="button" class="panel-toggle js-panel-toggle">Collapse</button>
            </div>
        </div>

        <div class="panel-scroll shelves-scroll">
            <div class="stack-list">
                @forelse($shelves as $shelf)
                    @php
                        $products = $shelf->products ?? collect();

                        $uniqueProducts = $products->count();
                        $shelfQty = $products->sum(fn($p) => $p->inventory?->quantity_on_hand ?? 0);

                        $shelfLow = $products->filter(function($p){
                            $onHand = $p->inventory?->quantity_on_hand ?? 0;
                            $reorder = $p->inventory?->reorder_level ?? 0;
                            return $reorder > 0 && $onHand <= $reorder;
                        })->count();

                        $itemsPayload = $products->map(function ($p) {
                            return [
                                'name'    => $p->product_name,
                                'category'=> $p->category,
                                'price'   => (float) $p->price,
                                'on_hand' => (int) optional($p->inventory)->quantity_on_hand,
                                'reorder' => (int) optional($p->inventory)->reorder_level,
                                'status'  => $p->status,
                            ];
                        })->values();
                    @endphp

                    <div class="shelf-card">
                        <div class="shelf-card-top">
                            <div class="shelf-card-main">
                                <div class="shelf-title">
                                    Shelf <strong>{{ $shelf->shelf_number }}</strong>
                                    <span class="badge {{ $shelf->shelf_status === 'Available' ? 'badge-available' : 'badge-occupied' }}">
                                        {{ strtoupper($shelf->shelf_status) }}
                                    </span>
                                </div>

                                <div class="shelf-sub">
                                    {{ $shelf->renter?->renter_company_name ?? '— Unassigned —' }}
                                </div>
                            </div>

                            <div class="shelf-stats">
                                <div class="mini-stat">
                                    <div class="mini-label">Products</div>
                                    <div class="mini-value">{{ $uniqueProducts }}</div>
                                </div>

                                <div class="mini-stat">
                                    <div class="mini-label">Qty</div>
                                    <div class="mini-value">{{ $shelfQty }}</div>
                                </div>

                                <div class="mini-stat">
                                    <div class="mini-label">Low</div>
                                    <div class="mini-value">{{ $shelfLow }}</div>
                                </div>

                                <button type="button"
                                        class="btn-action-chip js-open-items"
                                        data-shelf-id="{{ $shelf->shelf_id }}"
                                        data-shelf="{{ $shelf->shelf_number }}"
                                        data-renter="{{ $shelf->renter?->renter_company_name ?? '— Unassigned —' }}"
                                        data-items='@json($itemsPayload)'>
                                    Manage Items
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">No shelves found.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- EXPIRY DETAILS --}}
    <section class="panel js-collapsible-panel" data-panel="expiry">
        <div class="panel-header">
            <div class="panel-title-wrap">
                <h2 class="panel-title">Expiry Details</h2>
                <p class="panel-subtitle">Batches, lot tracking, and expiry monitoring.</p>
            </div>

            <div class="panel-actions">
                <form method="GET" action="{{ route('staff.inventory.index') }}" class="expiry-filter-form">
                    <input type="hidden" name="q" value="{{ $q ?? '' }}">

                    <select name="expiry_status" class="input-field w-180">
                        <option value="">All Statuses</option>
                        <option value="Expired" {{ ($expiryStatus ?? '') === 'Expired' ? 'selected' : '' }}>Expired</option>
                        <option value="Expires Today" {{ ($expiryStatus ?? '') === 'Expires Today' ? 'selected' : '' }}>Expires Today</option>
                        <option value="Expiring Soon" {{ ($expiryStatus ?? '') === 'Expiring Soon' ? 'selected' : '' }}>Expiring Soon</option>
                        <option value="Fresh" {{ ($expiryStatus ?? '') === 'Fresh' ? 'selected' : '' }}>Fresh</option>
                        <option value="No Expiry" {{ ($expiryStatus ?? '') === 'No Expiry' ? 'selected' : '' }}>No Expiry</option>
                    </select>

                    <select name="expiry_shelf" class="input-field w-180">
                        <option value="">All Shelves</option>
                        @foreach(($expiryShelves ?? []) as $s)
                            <option value="{{ $s->shelf_id }}" {{ (string)($expiryShelf ?? '') === (string)$s->shelf_id ? 'selected' : '' }}>
                                Shelf {{ $s->shelf_number }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn-outline" type="submit">Filter</button>
                    <a href="{{ route('staff.inventory.index') }}" class="btn-outline">Reset</a>
                    <button type="button" class="panel-toggle js-panel-toggle">Collapse</button>
                </form>
            </div>
        </div>

        <div class="panel-scroll expiry-scroll">
            <table class="activity-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Lot No.</th>
                        <th>Shelf</th>
                        <th>Renter</th>
                        <th>Expiry Date</th>
                        <th class="align-right">Qty Remaining</th>
                        <th class="align-right">Days Left</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($expiryBatches ?? []) as $batch)
                        <tr>
                            <td>
                                <strong>{{ $batch['product_name'] }}</strong>
                                <div class="muted-text">{{ $batch['category'] }}</div>
                            </td>
                            <td>{{ $batch['lot_number'] }}</td>
                            <td>{{ $batch['shelf_number'] }}</td>
                            <td>{{ $batch['renter_name'] }}</td>
                            <td>{{ $batch['expiration_date'] ?? '—' }}</td>
                            <td class="align-right">{{ $batch['quantity_remaining'] }}</td>
                            <td class="align-right">
                                {{ is_null($batch['days_left']) ? '—' : $batch['days_left'] }}
                            </td>
                            <td>
                                <span class="badge">{{ $batch['expiry_status'] }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-state">No expiry records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- RECENT TRANSACTIONS --}}
    <section class="panel js-collapsible-panel" data-panel="transactions">
        <div class="panel-header">
            <div class="panel-title-wrap">
                <h2 class="panel-title">Recent Inventory Transactions</h2>
                <p class="panel-subtitle">Latest stock movement and request history.</p>
            </div>

            <div class="panel-actions">
                <button type="button" class="panel-toggle js-panel-toggle">Collapse</button>
            </div>
        </div>

        <div class="panel-scroll transactions-scroll">
            <table class="activity-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Reference</th>
                        <th class="align-center">Type</th>
                        <th>Shelf</th>
                        <th>Renter</th>
                        <th>Status</th>
                        <th>Actioned By</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($t->transaction_date)->format('Y-m-d') }}</td>
                            <td>{{ $t->reference_no ?? '—' }}</td>
                            <td class="align-center">
                                <span class="badge">{{ $t->transaction_type }}</span>
                            </td>
                            <td>{{ $t->shelf?->shelf_number ?? '—' }}</td>
                            <td>{{ $t->renter?->renter_company_name ?? '—' }}</td>
                            <td>
                                <span class="badge">{{ $t->status ?? '—' }}</span>
                            </td>
                            <td>{{ $t->actionedBy?->name ?? '—' }}</td>
                            <td>{{ $t->remarks ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-state">No transactions yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

<div class="modal-backdrop" id="itemsModal" style="display:none;">
    <div class="modal-card modal-card-lg" role="dialog" aria-modal="true" aria-labelledby="itemsModalTitle">
        <div class="modal-head modal-head-clean">
            <div>
                <div class="modal-title" id="itemsModalTitle">Manage Items</div>
                <div class="modal-sub" id="itemsModalSub">—</div>
            </div>
            <button class="modal-close" type="button" id="itemsModalClose">✕</button>
        </div>

        <div class="modal-action-row modal-action-row-clean">
            <button class="btn-action-chip" type="button" id="btnStockIn">Stock In</button>
            <button class="btn-action-chip" type="button" id="btnStockOut">Stock Out</button>
            <button class="btn-action-chip" type="button" id="btnAdjust">Adjust</button>
        </div>

        <div class="modal-body modal-body-clean">
            <div class="activity-table-scrollable modal-table-wrap">
                <table class="activity-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th class="align-right">Price</th>
                            <th class="align-right">On Hand</th>
                            <th class="align-right">Reorder</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="itemsModalTbody">
                        <tr>
                            <td colspan="6" class="empty-state">No items.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-foot modal-foot-clean">
            <button class="btn-outline" type="button" id="itemsModalOk">Close</button>
        </div>
    </div>
</div>

<script>
(function () {
    const modal = document.getElementById('itemsModal');
    const closeBtn = document.getElementById('itemsModalClose');
    const okBtn = document.getElementById('itemsModalOk');
    const sub = document.getElementById('itemsModalSub');
    const tbody = document.getElementById('itemsModalTbody');

    const btnStockIn = document.getElementById('btnStockIn');
    const btnStockOut = document.getElementById('btnStockOut');
    const btnAdjust = document.getElementById('btnAdjust');

    let currentShelfId = null;

    function openModal() {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    function escapeHtml(str) {
        return String(str ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function peso(n) {
        const val = Number(n || 0);
        try {
            return new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP'
            }).format(val);
        } catch (e) {
            return '₱' + val.toFixed(2);
        }
    }

    document.querySelectorAll('.js-open-items').forEach(btn => {
        btn.addEventListener('click', () => {
            currentShelfId = btn.getAttribute('data-shelf-id');

            const shelfNo = btn.getAttribute('data-shelf');
            const renter = btn.getAttribute('data-renter');
            const items = JSON.parse(btn.getAttribute('data-items') || '[]');

            sub.textContent = `Shelf ${shelfNo} • ${renter}`;

            if (!items.length) {
                tbody.innerHTML = `<tr><td colspan="6" class="empty-state">No products on this shelf yet.</td></tr>`;
            } else {
                tbody.innerHTML = items.map(i => `
                    <tr>
                        <td><strong>${escapeHtml(i.name)}</strong></td>
                        <td>${escapeHtml(i.category)}</td>
                        <td class="align-right">${peso(i.price)}</td>
                        <td class="align-right">${Number(i.on_hand || 0)}</td>
                        <td class="align-right">${Number(i.reorder || 0)}</td>
                        <td>${escapeHtml(i.status)}</td>
                    </tr>
                `).join('');
            }

            openModal();
        });
    });

    btnStockIn.addEventListener('click', () => {
        if (!currentShelfId) return;
        window.location.href = `{{ route('staff.inventory.stockin.create') }}?shelf_id=${encodeURIComponent(currentShelfId)}`;
    });

    btnStockOut.addEventListener('click', () => {
        if (!currentShelfId) return;
        window.location.href = `{{ route('staff.inventory.stockout.create') }}?shelf_id=${encodeURIComponent(currentShelfId)}`;
    });

    btnAdjust.addEventListener('click', () => {
        if (!currentShelfId) return;
        window.location.href = `{{ route('staff.inventory.adjust.create') }}?shelf_id=${encodeURIComponent(currentShelfId)}`;
    });

    closeBtn.addEventListener('click', closeModal);
    okBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.style.display !== 'none') closeModal();
    });

    document.querySelectorAll('.js-collapsible-panel').forEach(panel => {
        const toggle = panel.querySelector('.js-panel-toggle');
        if (!toggle) return;

        toggle.addEventListener('click', () => {
            panel.classList.toggle('is-collapsed');
            toggle.textContent = panel.classList.contains('is-collapsed') ? 'Expand' : 'Collapse';
        });
    });
})();
</script>

@endsection