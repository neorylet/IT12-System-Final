@extends('layouts.app_a')
@section('title', 'Pending Inventory Approvals')

@section('content')
<div class="header-section">
    <h1>Pending Inventory Approvals</h1>
    <p>Review and approve staff-submitted inventory stock-in requests.</p>
</div>

@if(session('success'))
    <div class="success-box">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="form-page-wrap" style="padding-top:0;">
        <div class="form-alert form-alert-danger">
            <div class="form-alert-title">Please fix the errors:</div>
            <ul class="form-error-list">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@php
    $pendingCount = $pendingTransactions->count();
    $pendingQty = $pendingTransactions->sum(function ($trx) {
        return $trx->items->sum('quantity');
    });
@endphp

<div class="inventory-cards-grid" style="margin-top:12px;">
    <div class="stat-card">
        <div class="stat-label">Pending Requests</div>
        <div class="stat-value">{{ $pendingCount }}</div>
        <div class="stat-footer">Transactions waiting for approval</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Pending Units</div>
        <div class="stat-value">{{ $pendingQty }}</div>
        <div class="stat-footer">Total quantity across all requests</div>
    </div>
</div>

<div class="activity-section" style="margin-top:16px;">
    <div class="activity-header">Pending Stock-In Requests</div>

    <div class="scroll-box" style="padding:12px;">
        <div style="display:flex; flex-direction:column; gap:12px;">
            @forelse($pendingTransactions as $trx)
                @php
                    $itemsPayload = $trx->items->map(function ($item) {
                        return [
                            'product_name' => $item->product?->product_name ?? 'Unknown Product',
                            'category' => $item->product?->category ?? '—',
                            'quantity' => (int) $item->quantity,
                            'unit_cost' => $item->unit_cost,
                            'lot_number' => $item->lot_number,
                            'manufacturing_date' => $item->manufacturing_date,
                            'expiration_date' => $item->expiration_date,
                        ];
                    })->values();
                @endphp

                <div class="shelf-card">
                    <div class="shelf-card-top">
                        <div style="min-width:280px;">
                            <div class="shelf-title">
                                Ref <strong>{{ $trx->reference_no ?? '—' }}</strong>
                                <span class="badge">{{ strtoupper($trx->status) }}</span>
                            </div>

                            <div class="shelf-sub">
                                Shelf {{ $trx->shelf?->shelf_number ?? '—' }}
                                • {{ $trx->renter?->renter_company_name ?? '—' }}
                            </div>

                            <div class="shelf-sub" style="margin-top:4px;">
                                Submitted by: {{ $trx->actionedBy?->name ?? '—' }}
                                • {{ \Carbon\Carbon::parse($trx->transaction_date)->format('Y-m-d') }}
                            </div>

                            @if($trx->remarks)
                                <div class="shelf-sub" style="margin-top:4px;">
                                    Remarks: {{ $trx->remarks }}
                                </div>
                            @endif
                        </div>

                        <div class="shelf-stats">
                            <div class="mini-stat">
                                <div class="mini-label">Items</div>
                                <div class="mini-value">{{ $trx->items->count() }}</div>
                            </div>

                            <div class="mini-stat">
                                <div class="mini-label">Qty</div>
                                <div class="mini-value">{{ $trx->items->sum('quantity') }}</div>
                            </div>

                            <button type="button"
                                    class="btn-action-chip js-open-items"
                                    data-reference="{{ $trx->reference_no ?? '—' }}"
                                    data-shelf="{{ $trx->shelf?->shelf_number ?? '—' }}"
                                    data-renter="{{ $trx->renter?->renter_company_name ?? '—' }}"
                                    data-submitted-by="{{ $trx->actionedBy?->name ?? '—' }}"
                                    data-remarks="{{ $trx->remarks ?? '' }}"
                                    data-items='@json($itemsPayload)'>
                                View Items
                            </button>

                            <form method="POST" action="{{ route('admin.inventory.approve', $trx->transaction_id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-primary">Approve</button>
                            </form>

                            <button type="button"
                                    class="btn-outline js-open-reject"
                                    data-transaction-id="{{ $trx->transaction_id }}">
                                Reject
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">No pending inventory requests found.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- VIEW ITEMS MODAL --}}
<div class="modal-backdrop" id="itemsModal" style="display:none;">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="itemsModalTitle">
        <div class="modal-head">
            <div>
                <div class="modal-title" id="itemsModalTitle">Pending Request Items</div>
                <div class="modal-sub" id="itemsModalSub">—</div>
            </div>
            <button class="modal-close" type="button" id="itemsModalClose">✕</button>
        </div>

        <div class="modal-body">
            <div id="itemsModalMeta" style="margin-bottom:12px; font-size:14px; opacity:.8;"></div>

            <div class="activity-table-scrollable" style="border:1px solid #efe5da; border-radius:12px;">
                <table class="activity-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th style="text-align:right;">Qty</th>
                            <th style="text-align:right;">Unit Cost</th>
                            <th>Lot #</th>
                            <th>Mfg</th>
                            <th>Expiry</th>
                        </tr>
                    </thead>
                    <tbody id="itemsModalTbody">
                        <tr><td colspan="7" class="empty-state">No items.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-foot">
            <button class="btn-outline" type="button" id="itemsModalOk">Close</button>
        </div>
    </div>
</div>

{{-- REJECT MODAL --}}
<div class="modal-backdrop" id="rejectModal" style="display:none;">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="rejectModalTitle">
        <div class="modal-head">
            <div>
                <div class="modal-title" id="rejectModalTitle">Reject Request</div>
                <div class="modal-sub">Add a reason for rejection</div>
            </div>
            <button class="modal-close" type="button" id="rejectModalClose">✕</button>
        </div>

        <form method="POST" id="rejectForm">
            @csrf
            @method('PATCH')

            <div class="modal-body">
                <div class="form-group form-group-full">
                    <label class="form-label">Review Remarks</label>
                    <textarea name="review_remarks"
                              class="form-input"
                              rows="4"
                              placeholder="Reason for rejection..."
                              style="resize:vertical;"
                              required></textarea>
                </div>
            </div>

            <div class="modal-foot">
                <button type="button" class="btn-outline" id="rejectModalCancel">Cancel</button>
                <button type="submit" class="btn-primary">Confirm Reject</button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    const itemsModal = document.getElementById('itemsModal');
    const itemsModalClose = document.getElementById('itemsModalClose');
    const itemsModalOk = document.getElementById('itemsModalOk');
    const itemsModalSub = document.getElementById('itemsModalSub');
    const itemsModalMeta = document.getElementById('itemsModalMeta');
    const itemsModalTbody = document.getElementById('itemsModalTbody');

    const rejectModal = document.getElementById('rejectModal');
    const rejectModalClose = document.getElementById('rejectModalClose');
    const rejectModalCancel = document.getElementById('rejectModalCancel');
    const rejectForm = document.getElementById('rejectForm');

    function openModal(modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    function escapeHtml(str){
        return String(str ?? '')
            .replaceAll('&','&amp;')
            .replaceAll('<','&lt;')
            .replaceAll('>','&gt;')
            .replaceAll('"','&quot;')
            .replaceAll("'","&#039;");
    }

    function peso(n){
        const val = Number(n || 0);
        if (!val) return '—';
        try { return new Intl.NumberFormat('en-PH', { style:'currency', currency:'PHP' }).format(val); }
        catch(e){ return '₱' + val.toFixed(2); }
    }

    document.querySelectorAll('.js-open-items').forEach(btn => {
        btn.addEventListener('click', () => {
            const reference = btn.getAttribute('data-reference');
            const shelf = btn.getAttribute('data-shelf');
            const renter = btn.getAttribute('data-renter');
            const submittedBy = btn.getAttribute('data-submitted-by');
            const remarks = btn.getAttribute('data-remarks');
            const items = JSON.parse(btn.getAttribute('data-items') || '[]');

            itemsModalSub.textContent = `Ref ${reference} • Shelf ${shelf} • ${renter}`;
            itemsModalMeta.innerHTML = `
                <strong>Submitted by:</strong> ${escapeHtml(submittedBy)}
                ${remarks ? `<br><strong>Remarks:</strong> ${escapeHtml(remarks)}` : ''}
            `;

            if (!items.length) {
                itemsModalTbody.innerHTML = `<tr><td colspan="7" class="empty-state">No items.</td></tr>`;
            } else {
                itemsModalTbody.innerHTML = items.map(i => `
                    <tr>
                        <td><strong>${escapeHtml(i.product_name)}</strong></td>
                        <td>${escapeHtml(i.category)}</td>
                        <td style="text-align:right;">${Number(i.quantity || 0)}</td>
                        <td style="text-align:right;">${peso(i.unit_cost)}</td>
                        <td>${escapeHtml(i.lot_number || '—')}</td>
                        <td>${escapeHtml(i.manufacturing_date || '—')}</td>
                        <td>${escapeHtml(i.expiration_date || '—')}</td>
                    </tr>
                `).join('');
            }

            openModal(itemsModal);
        });
    });

    document.querySelectorAll('.js-open-reject').forEach(btn => {
        btn.addEventListener('click', () => {
            const transactionId = btn.getAttribute('data-transaction-id');
            rejectForm.action = `{{ url('admin/inventory') }}/${transactionId}/reject`;
            openModal(rejectModal);
        });
    });

    itemsModalClose.addEventListener('click', () => closeModal(itemsModal));
    itemsModalOk.addEventListener('click', () => closeModal(itemsModal));

    rejectModalClose.addEventListener('click', () => closeModal(rejectModal));
    rejectModalCancel.addEventListener('click', () => closeModal(rejectModal));

    itemsModal.addEventListener('click', (e) => {
        if (e.target === itemsModal) closeModal(itemsModal);
    });

    rejectModal.addEventListener('click', (e) => {
        if (e.target === rejectModal) closeModal(rejectModal);
    });

    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (itemsModal.style.display !== 'none') closeModal(itemsModal);
            if (rejectModal.style.display !== 'none') closeModal(rejectModal);
        }
    });
})();
</script>
@endsection