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

    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="{{ route('admin.products.index') }}" class="btn-primary">View Products</a>
    </div>
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

    <div class="stat-card">
        <div class="stat-label">Pending Approvals</div>
        <div class="stat-value">{{ $pendingApprovals }}</div>
        <div class="stat-footer">Waiting review (placeholder)</div>
    </div>
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
                                    class="btn-mini-outline js-open-items"
                                    data-shelf-id="{{ $shelf->shelf_id }}"
                                    data-shelf="{{ $shelf->shelf_number }}"
                                    data-renter="{{ $shelf->renter?->renter_company_name ?? '— Unassigned —' }}"
                                    data-items='@json($itemsPayload)'>
                                Manage items
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
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            No transactions yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL --}}
<div class="modal-backdrop" id="itemsModal" style="display:none;">
  <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="itemsModalTitle">
    <div class="modal-head">
      <div>
        <div class="modal-title" id="itemsModalTitle">Manage Items</div>
        <div class="modal-sub" id="itemsModalSub">—</div>
      </div>
      <button class="modal-close" type="button" id="itemsModalClose">✕</button>
    </div>

    <div style="display:flex; gap:10px; flex-wrap:wrap; padding: 0 18px 10px;">
      <button class="btn-mini-outline" type="button" id="btnStockIn">Stock In</button>
      <button class="btn-mini-outline" type="button" id="btnStockOut">Stock Out</button>
      <button class="btn-mini-outline" type="button" id="btnAdjust">Adjust</button>
    </div>

    <div class="modal-body">
      <div class="activity-table-scrollable" style="border:1px solid #efe5da; border-radius:12px;">
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
            <tr><td colspan="6" class="empty-state">No items.</td></tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal-foot">
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

  const btnStockIn  = document.getElementById('btnStockIn');
  const btnStockOut = document.getElementById('btnStockOut');
  const btnAdjust   = document.getElementById('btnAdjust');

  let currentShelfId = null;
  let currentShelfNo = null;
  let currentRenter  = null;

  function openModal() {
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }
  function closeModal() {
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
    try { return new Intl.NumberFormat('en-PH', { style:'currency', currency:'PHP' }).format(val); }
    catch(e){ return '₱' + val.toFixed(2); }
  }

  document.querySelectorAll('.js-open-items').forEach(btn => {
    btn.addEventListener('click', () => {
      currentShelfId = btn.getAttribute('data-shelf-id');
      currentShelfNo = btn.getAttribute('data-shelf');
      currentRenter  = btn.getAttribute('data-renter');

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

  closeBtn.addEventListener('click', closeModal);
  okBtn.addEventListener('click', closeModal);
  modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.style.display !== 'none') closeModal();
  });
})();
</script>
@endsection