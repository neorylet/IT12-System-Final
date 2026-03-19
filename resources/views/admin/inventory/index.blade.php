@extends('layouts.app_a')
@section('title', 'Inventory')

@section('content')
<div class="header-section">
    <h1>Inventory</h1>
    <p>Overview of products, shelf stock, and recent activity.</p>
</div>

@if(session('success'))
    <div class="success-box">{{ session('success') }}</div>
@endif

<div class="toolbar">
    <form method="GET" action="{{ route('admin.inventory.index') }}" class="search-form">
        <input class="input-field" name="q" value="{{ $q ?? '' }}" placeholder="Search shelf, renter, product...">
        <button class="btn-outline" type="submit">Search</button>
    </form>
</div>

@php
    $allProducts = collect();
    foreach(($shelves ?? []) as $sh){
        $allProducts = $allProducts->merge($sh->products ?? collect());
    }

    $totalProducts = $allProducts->count();
    $totalQty = $allProducts->sum(fn($p) => $p->inventory?->quantity_on_hand ?? 0);

    $lowStockCount = $allProducts->filter(function($p){
        $onHand = $p->inventory?->quantity_on_hand ?? 0;
        $reorder = $p->inventory?->reorder_level ?? 0;
        return $reorder > 0 && $onHand <= $reorder;
    })->count();

    $expiringSoon = $expiringSoon ?? 0;
    $pendingApprovals = $pendingApprovals ?? 0;
@endphp

<div class="inventory-cards-grid" style="margin-top:12px;">
    <div class="stat-card">
        <div class="stat-label">Total Products</div>
        <div class="stat-value">{{ $totalProducts }}</div>
        <div class="stat-footer">Catalog items across all shelves</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Stock</div>
        <div class="stat-value">{{ $totalQty }}</div>
        <div class="stat-footer">Units currently on hand</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Low Stock Alerts</div>
        <div class="stat-value">{{ $lowStockCount }}</div>
        <div class="stat-footer">Items at or below reorder level</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Expiring Soon</div>
        <div class="stat-value">{{ $expiringSoon }}</div>
        <div class="stat-footer">Batches expiring soon (placeholder)</div>
    </div>

    <a href="{{ route('admin.inventory.pending') }}" style="text-decoration:none; color:inherit; display:block;">
        <div class="stat-card" style="{{ ($pendingCount ?? 0) > 0 ? 'border-color:#d6a77a; background:#fffaf5;' : '' }}">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:10px;">
                <div>
                    <div class="stat-label">Pending Approvals</div>
                    <div class="stat-value">{{ $pendingCount ?? 0 }}</div>
                </div>

                <span class="btn-action-chip" style="min-height:auto; padding:6px 12px;">
                    Open
                </span>
            </div>

            <div class="stat-footer">
                @if(($pendingCount ?? 0) > 0)
                    Click this card to review approval requests
                @else
                    No pending requests right now
                @endif
            </div>
        </div>
    </a>
</div>

<div class="activity-section" style="margin-top:16px;">
    <div class="activity-header">Shelves</div>

    <div class="scroll-box" style="padding:12px;">
        <div style="display:flex; flex-direction:column; gap:12px;">
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
                        <div style="min-width:240px;">
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
</div>

<div class="activity-section" style="margin-top:16px;">
    <div class="activity-header">Recent Inventory Transactions</div>

    <div class="activity-table-scrollable" style="max-height:min(55vh, 300px);">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Reference</th>
                    <th style="text-align:center;">Type</th>
                    <th>Shelf</th>
                    <th>Renter</th>
                    <th>Actioned By</th>
                    <th>Remarks</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                    @php
                        $receiptItems = $t->items->map(function ($item) {
                            return [
                                'product_name' => $item->batch?->product?->product_name
                                    ?? $item->product?->product_name
                                    ?? 'Unknown Product',
                                'lot_number' => $item->batch?->lot_number
                                    ?? $item->lot_number
                                    ?? '—',
                                'mfg_date' => $item->batch?->manufacturing_date
                                    ?? $item->manufacturing_date,
                                'exp_date' => $item->batch?->expiration_date
                                    ?? $item->expiration_date,
                                'quantity' => (int) ($item->quantity ?? 0),
                                'unit_cost' => is_null($item->unit_cost) ? null : (float) $item->unit_cost,
                                'amount' => is_null($item->unit_cost)
                                    ? null
                                    : ((int) ($item->quantity ?? 0) * (float) $item->unit_cost),
                            ];
                        })->values();

                        $receiptPayload = [
                            'reference_no' => $t->reference_no ?? '—',
                            'transaction_type' => $t->transaction_type ?? '—',
                            'transaction_date' => $t->transaction_date
                                ? \Carbon\Carbon::parse($t->transaction_date)->format('Y-m-d h:i A')
                                : '—',
                            'status' => $t->status ?? 'Approved',
                            'shelf' => $t->shelf?->shelf_number ?? '—',
                            'renter' => $t->renter?->renter_company_name ?? '—',
                            'actioned_by' => $t->actionedBy?->name ?? '—',
                            'remarks' => $t->remarks ?? '—',
                            'items' => $receiptItems,
                        ];
                    @endphp

                    <tr>
                        <td>{{ \Carbon\Carbon::parse($t->transaction_date)->format('Y-m-d') }}</td>
                        <td>{{ $t->reference_no ?? '—' }}</td>
                        <td style="text-align:center;">
                            <span class="badge">{{ $t->transaction_type }}</span>
                        </td>
                        <td>{{ $t->shelf?->shelf_number ?? '—' }}</td>
                        <td>{{ $t->renter?->renter_company_name ?? '—' }}</td>
                        <td>{{ $t->actionedBy?->name ?? '—' }}</td>
                        <td>{{ $t->remarks ?? '—' }}</td>
                        <td style="text-align:center;">
                            <button
                                type="button"
                                class="btn-action-chip js-open-receipt"
                                data-receipt='@json($receiptPayload)'>
                                View
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">No transactions yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL --}}
{{-- MODAL --}}
<div class="modal-backdrop" id="itemsModal" style="display:none;">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="itemsModalTitle"
         style="max-width: 860px; width:min(94vw, 860px); padding:0; overflow:hidden;">

        <div class="modal-head" style="padding:16px 20px; border-bottom:1px solid #efe5da;">
            <div>
                <div class="modal-title" id="itemsModalTitle">Manage Items</div>
                <div class="modal-sub" id="itemsModalSub">—</div>
            </div>
            <button class="modal-close" type="button" id="itemsModalClose">✕</button>
        </div>

        <div class="modal-action-row" style="padding:14px 20px 0; display:flex; gap:10px; flex-wrap:wrap;">
            <button class="btn-action-chip" type="button" id="btnStockIn">Stock In</button>
            <button class="btn-action-chip" type="button" id="btnStockOut">Stock Out</button>
            <button class="btn-action-chip" type="button" id="btnAdjust">Adjust</button>
        </div>

        <div class="modal-body" style="padding:20px;">
            <div class="activity-table-scrollable" style="border:1px solid #efe5da; border-radius:12px; overflow:hidden;">
                <table class="activity-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th style="text-align:right;">Price</th>
                            <th style="text-align:right;">On Hand</th>
                            <th style="text-align:right;">Reorder</th>
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

        <div class="modal-foot" style="padding:14px 20px; border-top:1px solid #efe5da; display:flex; justify-content:flex-end; gap:10px;">
            <button class="btn-outline" type="button" id="itemsModalOk">Close</button>
        </div>
    </div>
</div>


{{-- RECEIPT MODAL --}}
<div class="modal-backdrop" id="receiptModal" style="display:none;">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="receiptModalTitle"
         style="max-width: 860px; width:min(94vw, 860px); padding:0; overflow:hidden;">

        <div class="modal-head" style="padding:16px 20px; border-bottom:1px solid #efe5da;">
            <div>
                <div class="modal-title" id="receiptModalTitle">Transaction Receipt</div>
                <div class="modal-sub">View inventory transaction details</div>
            </div>
            <button class="modal-close" type="button" id="receiptModalClose">✕</button>
        </div>

        <div class="modal-body" style="padding:20px;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; flex-wrap:wrap; margin-bottom:18px;">
                <div>
                    <div style="font-size:20px; font-weight:700; color:#3b2f2f;">Receipt</div>
                    <div style="font-size:13px; color:#7b6d63; margin-top:2px;">
                        Inventory transaction summary
                    </div>
                </div>

                <div style="text-align:right;">
                    <div style="font-size:12px; color:#8b7b70;">Reference No.</div>
                    <div id="r_reference" style="font-size:20px; font-weight:700; color:#3b2f2f;">—</div>
                </div>
            </div>

            <div style="border:1px solid #efe5da; border-radius:14px; overflow:hidden; background:#fffdf9;">
                <div style="padding:16px 18px;">
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px 24px;">
                        <div>
                            <div style="font-size:12px; color:#8b7b70;">Transaction Type</div>
                            <div id="r_type" style="font-size:15px; font-weight:600; color:#2f2a26;">—</div>
                        </div>

                        <div>
                            <div style="font-size:12px; color:#8b7b70;">Date</div>
                            <div id="r_date" style="font-size:15px; font-weight:600; color:#2f2a26;">—</div>
                        </div>

                        <div>
                            <div style="font-size:12px; color:#8b7b70;">Status</div>
                            <div id="r_status" style="font-size:15px; font-weight:600; color:#2f2a26;">—</div>
                        </div>

                        <div>
                            <div style="font-size:12px; color:#8b7b70;">Actioned By</div>
                            <div id="r_actioned_by" style="font-size:15px; font-weight:600; color:#2f2a26;">—</div>
                        </div>

                        <div>
                            <div style="font-size:12px; color:#8b7b70;">Shelf</div>
                            <div id="r_shelf" style="font-size:15px; font-weight:600; color:#2f2a26;">—</div>
                        </div>

                        <div>
                            <div style="font-size:12px; color:#8b7b70;">Renter</div>
                            <div id="r_renter" style="font-size:15px; font-weight:600; color:#2f2a26;">—</div>
                        </div>
                    </div>

                    <div style="margin-top:14px;">
                        <div style="font-size:12px; color:#8b7b70;">Remarks</div>
                        <div id="r_remarks" style="font-size:15px; font-weight:600; color:#2f2a26;">—</div>
                    </div>
                </div>

                <div style="border-top:1px solid #efe5da; padding:16px 18px;">
                    <div style="font-size:14px; font-weight:700; color:#3b2f2f; margin-bottom:10px;">
                        Included Items
                    </div>

                    <div style="overflow-x:auto;">
                        <table class="activity-table" style="min-width:700px;">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Lot No.</th>
                                    <th>MFG</th>
                                    <th>EXP</th>
                                    <th style="text-align:right;">Qty</th>
                                    <th style="text-align:right;">Unit Cost</th>
                                    <th style="text-align:right;">Amount</th>
                                </tr>
                            </thead>
                            <tbody id="receiptItemsTbody">
                                <tr>
                                    <td colspan="7" class="empty-state">No items found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div style="display:flex; justify-content:flex-end; margin-top:12px;">
                        <div style="min-width:240px; display:flex; justify-content:space-between; gap:16px; font-size:18px; font-weight:700; color:#2f2a26;">
                            <span>Grand Total</span>
                            <span id="receiptGrandTotal">—</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-foot" style="padding:14px 20px; border-top:1px solid #efe5da; display:flex; justify-content:flex-end; gap:10px;">
            <button class="btn-outline" type="button" id="receiptPrintBtn">Print</button>
            <button class="btn-action-chip" type="button" id="receiptModalOk">Close</button>
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

    const btnStockIn  = document.getElementById('btnStockIn');
    const btnStockOut = document.getElementById('btnStockOut');
    const btnAdjust   = document.getElementById('btnAdjust');

    const receiptModal = document.getElementById('receiptModal');
    const receiptModalClose = document.getElementById('receiptModalClose');
    const receiptModalOk = document.getElementById('receiptModalOk');
    const receiptPrintBtn = document.getElementById('receiptPrintBtn');

    const rReference = document.getElementById('r_reference');
    const rType = document.getElementById('r_type');
    const rDate = document.getElementById('r_date');
    const rStatus = document.getElementById('r_status');
    const rActionedBy = document.getElementById('r_actioned_by');
    const rShelf = document.getElementById('r_shelf');
    const rRenter = document.getElementById('r_renter');
    const rRemarks = document.getElementById('r_remarks');
    const receiptItemsTbody = document.getElementById('receiptItemsTbody');
    const receiptGrandTotal = document.getElementById('receiptGrandTotal');

    let currentShelfId = null;
    let currentShelfNo = null;
    let currentRenter = null;

    function openModal() {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    function openReceiptModal() {
        receiptModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeReceiptModal() {
        receiptModal.style.display = 'none';
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

    function formatDate(val) {
        if (!val || val === '—') return '—';
        return val;
    }

    document.querySelectorAll('.js-open-items').forEach(btn => {
        btn.addEventListener('click', () => {
            currentShelfId = btn.getAttribute('data-shelf-id');
            currentShelfNo = btn.getAttribute('data-shelf');
            currentRenter = btn.getAttribute('data-renter');

            const items = JSON.parse(btn.getAttribute('data-items') || '[]');

            sub.textContent = `Shelf ${currentShelfNo} • ${currentRenter}`;

            if (!items.length) {
                tbody.innerHTML = `<tr><td colspan="6" class="empty-state">No products on this shelf yet.</td></tr>`;
            } else {
                tbody.innerHTML = items.map(i => `
                    <tr>
                        <td><strong>${escapeHtml(i.name)}</strong></td>
                        <td>${escapeHtml(i.category)}</td>
                        <td style="text-align:right;">${peso(i.price)}</td>
                        <td style="text-align:right;">${Number(i.on_hand || 0)}</td>
                        <td style="text-align:right;">${Number(i.reorder || 0)}</td>
                        <td>${escapeHtml(i.status)}</td>
                    </tr>
                `).join('');
            }

            openModal();
        });
    });

    document.querySelectorAll('.js-open-receipt').forEach(btn => {
        btn.addEventListener('click', () => {
            const receipt = JSON.parse(btn.getAttribute('data-receipt') || '{}');
            const items = receipt.items || [];

            rReference.textContent = receipt.reference_no || '—';
            rType.textContent = receipt.transaction_type || '—';
            rDate.textContent = formatDate(receipt.transaction_date);
            rStatus.textContent = receipt.status || '—';
            rActionedBy.textContent = receipt.actioned_by || '—';
            rShelf.textContent = receipt.shelf || '—';
            rRenter.textContent = receipt.renter || '—';
            rRemarks.textContent = receipt.remarks || '—';

            let grandTotal = 0;
            let hasAnyAmount = false;

            if (!items.length) {
                receiptItemsTbody.innerHTML = `<tr><td colspan="7" class="empty-state">No items found for this transaction.</td></tr>`;
            } else {
                receiptItemsTbody.innerHTML = items.map(item => {
                    const unitCost = item.unit_cost;
                    const amount = item.amount;

                    if (amount !== null && amount !== undefined) {
                        grandTotal += Number(amount);
                        hasAnyAmount = true;
                    }

                    return `
                        <tr>
                            <td><strong>${escapeHtml(item.product_name || 'Unknown Product')}</strong></td>
                            <td>${escapeHtml(item.lot_number || '—')}</td>
                            <td>${escapeHtml(item.mfg_date || '—')}</td>
                            <td>${escapeHtml(item.exp_date || '—')}</td>
                            <td style="text-align:right;">${Number(item.quantity || 0)}</td>
                            <td style="text-align:right;">${unitCost === null || unitCost === undefined ? '—' : peso(unitCost)}</td>
                            <td style="text-align:right;">${amount === null || amount === undefined ? '—' : peso(amount)}</td>
                        </tr>
                    `;
                }).join('');
            }

            receiptGrandTotal.textContent = hasAnyAmount ? peso(grandTotal) : '—';

            openReceiptModal();
        });
    });

    btnStockIn.addEventListener('click', () => {
        if (!currentShelfId) return;
        window.location.href = `{{ route('admin.inventory.stockin.create') }}?shelf_id=${encodeURIComponent(currentShelfId)}`;
    });

    btnStockOut.addEventListener('click', () => {
        if (!currentShelfId) return;
        window.location.href = `{{ route('admin.inventory.stockout.create') }}?shelf_id=${encodeURIComponent(currentShelfId)}`;
    });

    btnAdjust.addEventListener('click', () => {
        if (!currentShelfId) return;
        window.location.href = `{{ route('admin.inventory.adjust.create') }}?shelf_id=${encodeURIComponent(currentShelfId)}`;
    });

    receiptPrintBtn.addEventListener('click', () => {
        window.print();
    });

    closeBtn.addEventListener('click', closeModal);
    okBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    receiptModalClose.addEventListener('click', closeReceiptModal);
    receiptModalOk.addEventListener('click', closeReceiptModal);
    receiptModal.addEventListener('click', (e) => {
        if (e.target === receiptModal) closeReceiptModal();
    });

    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.style.display !== 'none') closeModal();
        if (e.key === 'Escape' && receiptModal.style.display !== 'none') closeReceiptModal();
    });
})();
</script>

@endsection