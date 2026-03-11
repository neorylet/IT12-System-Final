@extends('layouts.app_s')
@section('title', 'Inventory')

@section('content')
<div class="header-section">
    <h1>Inventory</h1>
    <p>View shelf items and submit inventory requests for admin approval.</p>
</div>

@if(session('success'))
    <div class="success-box">{{ session('success') }}</div>
@endif

<div class="activity-section" style="margin-top:16px;">
    <div class="activity-header">Shelves</div>

    <div class="scroll-box" style="padding:12px;">
        <div style="display:flex; flex-direction:column; gap:12px;">
            @forelse($shelves as $shelf)
                @php
                    $products = $shelf->products ?? collect();

                    $uniqueProducts = $products->count();
                    $shelfQty = $products->sum(fn($p) => $p->inventory?->quantity_on_hand ?? 0);

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

<div class="modal-backdrop" id="itemsModal" style="display:none;">
  <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="itemsModalTitle">
    <div class="modal-head">
      <div>
        <div class="modal-title" id="itemsModalTitle">Manage Items</div>
        <div class="modal-sub" id="itemsModalSub">—</div>
      </div>
      <button class="modal-close" type="button" id="itemsModalClose">✕</button>
    </div>

    <div class="modal-action-row">
      <button class="btn-action-chip" type="button" id="btnStockIn">Stock In</button>
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

  let currentShelfId = null;

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

      const shelfNo = btn.getAttribute('data-shelf');
      const renter  = btn.getAttribute('data-renter');
      const items = JSON.parse(btn.getAttribute('data-items') || '[]');

      sub.textContent = `Shelf ${shelfNo} • ${renter}`;

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
    window.location.href = `{{ route('staff.inventory.stockin.create') }}?shelf_id=${encodeURIComponent(currentShelfId)}`;
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