@extends('layouts.app_s') {{-- or layouts.app_a if you’re using the shared layout --}}
@section('title', 'Inventory')

@section('content')
<div class="header-section">
    <h1>Inventory</h1>
    <p>Overview of products, shelf stock, and recent activity. (Staff view)</p>
</div>

@if(session('success'))
    <div class="success-box">{{ session('success') }}</div>
@endif

<div class="toolbar">
    <form method="GET" action="{{ route('staff.inventory.index') }}" class="search-form">
        <input class="input-field" name="q" value="{{ request('q') ?? '' }}" placeholder="Search shelf, renter, product...">
        <button class="btn-outline" type="submit">Search</button>
    </form>

    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <span class="badge">STAFF VIEW</span>
    </div>
</div>

{{-- KPI (static placeholders) --}}
<div class="cards-grid" style="margin-top:12px;">
    <div class="stat-card">
        <div class="stat-label">Total Products</div>
        <div class="stat-value">—</div>
        <div class="stat-footer">Placeholder (connect later)</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Stock</div>
        <div class="stat-value">—</div>
        <div class="stat-footer">Placeholder (connect later)</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Low Stock Alerts</div>
        <div class="stat-value">—</div>
        <div class="stat-footer">Placeholder (connect later)</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Expiring Soon</div>
        <div class="stat-value">—</div>
        <div class="stat-footer">Placeholder (connect later)</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Pending Approvals</div>
        <div class="stat-value">—</div>
        <div class="stat-footer">Placeholder (connect later)</div>
    </div>
</div>

{{-- Shelves (static cards, scroll-box) --}}
<div class="activity-section" style="margin-top:16px;">
    <div class="activity-header">Shelves</div>

    <div class="scroll-box" style="padding:12px;">
        <div style="display:flex; flex-direction:column; gap:12px;">

            {{-- Card 1 --}}
            <div class="shelf-card">
                <div class="shelf-card-top">
                    <div style="min-width:240px;">
                        <div class="shelf-title">
                            Shelf <strong>A-01</strong>
                            <span class="badge badge-occupied">OCCUPIED</span>
                        </div>
                        <div class="shelf-sub">Sample Renter Co.</div>
                    </div>

                    <div class="shelf-stats">
                        <div class="mini-stat">
                            <div class="mini-label">Products</div>
                            <div class="mini-value">12</div>
                        </div>

                        <div class="mini-stat">
                            <div class="mini-label">Qty</div>
                            <div class="mini-value">240</div>
                        </div>

                        <div class="mini-stat">
                            <div class="mini-label">Low</div>
                            <div class="mini-value">3</div>
                        </div>

                        <button type="button"
                                class="btn-mini-outline js-open-items"
                                data-shelf="A-01"
                                data-renter="Sample Renter Co."
                                data-items='[
                                  {"name":"Lavender Soap","category":"Bath","price":79,"on_hand":44,"reorder":20,"status":"Active"},
                                  {"name":"Scented Candle","category":"Home","price":199,"on_hand":12,"reorder":15,"status":"Active"},
                                  {"name":"Mini Perfume","category":"Beauty","price":149,"on_hand":7,"reorder":10,"status":"Active"}
                                ]'>
                            Manage items
                        </button>
                    </div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="shelf-card">
                <div class="shelf-card-top">
                    <div style="min-width:240px;">
                        <div class="shelf-title">
                            Shelf <strong>B-03</strong>
                            <span class="badge badge-available">AVAILABLE</span>
                        </div>
                        <div class="shelf-sub">— Unassigned —</div>
                    </div>

                    <div class="shelf-stats">
                        <div class="mini-stat">
                            <div class="mini-label">Products</div>
                            <div class="mini-value">0</div>
                        </div>

                        <div class="mini-stat">
                            <div class="mini-label">Qty</div>
                            <div class="mini-value">0</div>
                        </div>

                        <div class="mini-stat">
                            <div class="mini-label">Low</div>
                            <div class="mini-value">0</div>
                        </div>

                        <button type="button"
                                class="btn-mini-outline js-open-items"
                                data-shelf="B-03"
                                data-renter="— Unassigned —"
                                data-items='[]'>
                            Manage items
                        </button>
                    </div>
                </div>
            </div>

            {{-- Add more sample shelf cards if you want --}}

        </div>
    </div>
</div>

{{-- Recent transactions (static table + scrollbar) --}}
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
                <tr>
                    <td>2026-03-02</td>
                    <td>TXN-0001</td>
                    <td style="text-align:center;"><span class="badge">Stock In</span></td>
                    <td>A-01</td>
                    <td>Sample Renter Co.</td>
                    <td>Staff User</td>
                    <td>Initial restock</td>
                </tr>

                <tr>
                    <td colspan="7" class="empty-state">Front-end only (connect data later).</td>
                </tr>
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

    {{-- Staff: no stock in/out/adjust routes for now --}}
    <div style="display:flex; gap:10px; flex-wrap:wrap; padding: 0 18px 10px;">
      <span class="badge">View-only for now</span>
    </div>

    <div class="modal-body">
      <div class="activity-table-scrollable" style="border:1px solid #efe5da; border-radius:12px; max-height:420px;">
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

  closeBtn.addEventListener('click', closeModal);
  okBtn.addEventListener('click', closeModal);
  modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.style.display !== 'none') closeModal();
  });
})();
</script>
@endsection