@extends('layouts.app_s')
@section('title', 'Stock In Request')

@section('content')
<div class="header-section">
    <h1>Stock In Request</h1>
    <p>Submit stock-in items for admin approval.</p>
</div>

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

@if(!empty($selectedShelf))
  <div class="form-page-wrap" style="padding-top:0;">
    <div class="success-box form-inline-note">
      <strong>Stock In Request for:</strong>
      Shelf {{ $selectedShelf->shelf_number }} • {{ $selectedShelf->renter?->renter_company_name ?? 'Unassigned' }}
    </div>
  </div>
@endif

<div class="form-page-wrap">
  <div class="form-shell form-shell-wide">
    <div class="form-card">
      <div class="form-card-header">
        <h2 class="form-card-title">Stock In Request Form</h2>
        <p class="form-card-subtitle">Add one or more items under a single stock-in request.</p>
      </div>

      <form method="POST" action="{{ route('staff.inventory.stockin.store') }}" class="transaction-form">
        @csrf

        <div class="transaction-top-grid transaction-top-grid-3">
          <div class="form-group form-group-full">
            <label class="form-label">Shelf</label>

            @if(!empty($selectedShelf))
              <input type="hidden" name="shelf_id" value="{{ $selectedShelf->shelf_id }}">

              <div class="form-input form-input-readonly">
                {{ $selectedShelf->shelf_number }} — {{ $selectedShelf->renter?->renter_company_name ?? 'Unassigned' }}
              </div>

              <div class="form-help-text">
                This request is locked to the selected shelf.
              </div>
            @else
              <select name="shelf_id" class="form-input form-select" required>
                <option value="">— Select shelf —</option>
                @foreach($shelves as $s)
                  <option value="{{ $s->shelf_id }}"
                    {{ (string)old('shelf_id', $selectedShelfId ?? '') === (string)$s->shelf_id ? 'selected' : '' }}>
                    {{ $s->shelf_number }} — {{ $s->renter?->renter_company_name ?? 'Unassigned' }}
                  </option>
                @endforeach
              </select>

              <div class="form-help-text">
                Select the shelf where this stock-in request will be submitted.
              </div>
            @endif
          </div>

          <div class="form-group">
            <label class="form-label">Reference No (optional)</label>
            <input
              name="reference_no"
              class="form-input"
              value="{{ old('reference_no') }}"
              placeholder="e.g. DR-00012"
            >
          </div>

          <div class="form-group">
            <label class="form-label">Transaction Date</label>
            <input
              type="date"
              name="transaction_date"
              class="form-input"
              value="{{ old('transaction_date', now()->toDateString()) }}"
              required
            >
          </div>

          <div class="form-group">
            <label class="form-label">Remarks (optional)</label>
            <input
              name="remarks"
              class="form-input"
              value="{{ old('remarks') }}"
              placeholder="Notes..."
            >
          </div>
        </div>

        @if(!empty($selectedShelf) && $products->isEmpty())
          <div class="form-alert form-alert-danger" style="margin-top:16px;">
            No approved products are assigned to this shelf.
          </div>
        @endif

        <div class="transaction-items-section">
          <div class="transaction-items-header">
            <div>
              <div class="transaction-items-title">Items</div>
              <div class="transaction-items-subtitle">These items will be submitted for admin approval.</div>
            </div>

            <button
              type="button"
              class="btn-action-chip"
              id="btnAddRow"
              {{ $products->isEmpty() ? 'disabled' : '' }}
            >
              + Add Item
            </button>
          </div>

          <div class="table-card-wrap">
            <div class="activity-table-scrollable">
              <table class="activity-table" id="itemsTable">
                <thead>
                  <tr>
                    <th style="width:4%; text-align:center;">#</th>
                    <th style="width:24%;">Product</th>
                    <th style="width:12%;">Lot # (opt)</th>
                    <th style="width:12%;">Mfg (opt)</th>
                    <th style="width:12%;">Expiry (opt)</th>
                    <th style="width:14%; text-align:right;">Qty</th>
                    <th style="width:14%; text-align:right;">Unit Cost</th>
                    <th style="width:8%; text-align:right;">Remove</th>
                  </tr>
                </thead>

                <tbody id="itemsTbody">
                  <tr>
                    <td class="rowNo" style="text-align:center;">1</td>

                    <td>
                      <select name="items[0][product_id]" class="form-input form-select" required>
                        <option value="">— Select product —</option>
                        @foreach($products as $p)
                          <option value="{{ $p->product_id }}"
                            {{ (string)old('items.0.product_id') === (string)$p->product_id ? 'selected' : '' }}>
                            {{ $p->product_name }} ({{ $p->category }})
                          </option>
                        @endforeach
                      </select>
                    </td>

                    <td>
                      <input
                        name="items[0][lot_number]"
                        class="form-input"
                        placeholder="LOT-001"
                        value="{{ old('items.0.lot_number') }}"
                      >
                    </td>

                    <td>
                      <input
                        type="date"
                        name="items[0][manufacturing_date]"
                        class="form-input"
                        value="{{ old('items.0.manufacturing_date') }}"
                      >
                    </td>

                    <td>
                      <input
                        type="date"
                        name="items[0][expiration_date]"
                        class="form-input"
                        value="{{ old('items.0.expiration_date') }}"
                      >
                    </td>

                    <td>
                      <input
                        type="number"
                        min="1"
                        name="items[0][quantity]"
                        class="form-input input-align-right"
                        value="{{ old('items.0.quantity') }}"
                        required
                      >
                    </td>

                    <td>
                      <input
                        type="number"
                        step="0.01"
                        min="0"
                        name="items[0][unit_cost]"
                        class="form-input input-align-right"
                        value="{{ old('items.0.unit_cost') }}"
                      >
                    </td>

                    <td style="text-align:right;">
                      <button type="button" class="btn-row-remove btnRemoveRow">✕</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="form-actions form-actions-right">
            <a href="{{ route('staff.inventory.index') }}" class="btn-outline">Cancel</a>
            <button
              type="submit"
              class="btn-primary"
              {{ $products->isEmpty() ? 'disabled' : '' }}
            >
              Submit Request
            </button>
          </div>

          <div class="transaction-footnote">
            All items will stay pending until reviewed by admin.
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.form-input-readonly {
    display: flex;
    align-items: center;
    min-height: 44px;
    padding: 10px 12px;
    background: #f8f6f2;
    border: 1px solid #e5dccf;
    border-radius: 10px;
    color: #5c3b1e;
}
</style>

<script>
(function () {
  const tbody = document.getElementById('itemsTbody');
  const btnAdd = document.getElementById('btnAddRow');

  if (!tbody || !btnAdd) return;

  const productOptionsHtml = `{!! collect($products)->map(function($p){
      $label = e($p->product_name).' ('.e($p->category).')';
      return '<option value="'.$p->product_id.'">'.$label.'</option>';
    })->implode('') !!}`;

  function rowHtml(index){
    return `
      <tr>
        <td class="rowNo" style="text-align:center;">${index + 1}</td>

        <td>
          <select name="items[${index}][product_id]" class="form-input form-select" required>
            <option value="">— Select product —</option>
            ${productOptionsHtml}
          </select>
        </td>

        <td><input name="items[${index}][lot_number]" class="form-input" placeholder="LOT-001"></td>
        <td><input type="date" name="items[${index}][manufacturing_date]" class="form-input"></td>
        <td><input type="date" name="items[${index}][expiration_date]" class="form-input"></td>

        <td><input type="number" min="1" name="items[${index}][quantity]" class="form-input input-align-right" required></td>
        <td><input type="number" step="0.01" min="0" name="items[${index}][unit_cost]" class="form-input input-align-right"></td>

        <td style="text-align:right;">
          <button type="button" class="btn-row-remove btnRemoveRow">✕</button>
        </td>
      </tr>
    `;
  }

  function reindex(){
    const rows = Array.from(tbody.querySelectorAll('tr'));

    rows.forEach((tr, i) => {
      const rn = tr.querySelector('.rowNo');
      if (rn) rn.textContent = String(i + 1);

      tr.querySelectorAll('input, select').forEach(el => {
        const name = el.getAttribute('name');
        if (!name) return;
        el.setAttribute('name', name.replace(/items\[\d+\]/, `items[${i}]`));
      });
    });
  }

  btnAdd.addEventListener('click', () => {
    if (!productOptionsHtml.trim()) return;
    const nextIndex = tbody.querySelectorAll('tr').length;
    tbody.insertAdjacentHTML('beforeend', rowHtml(nextIndex));
    reindex();
  });

  tbody.addEventListener('click', (e) => {
    const btn = e.target.closest('.btnRemoveRow');
    if (!btn) return;

    const rows = tbody.querySelectorAll('tr');
    if (rows.length <= 1) {
      alert('At least one item is required.');
      return;
    }

    btn.closest('tr').remove();
    reindex();
  });
})();
</script>
@endsection