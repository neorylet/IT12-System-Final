@extends('layouts.app_s')
@section('title', 'Stock Out Request')

@section('content')
<div class="header-section">
  <h1>Stock Out Request</h1>
  <p>Submit stock-out items for admin approval.</p>
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
      <strong>Stock Out Request for:</strong>
      Shelf {{ $selectedShelf->shelf_number }} • {{ $selectedShelf->renter?->renter_company_name ?? 'Unassigned' }}
    </div>
  </div>
@endif

<div class="form-page-wrap">
  <div class="form-shell form-shell-wide">
    <div class="form-card">
      <div class="form-card-header">
        <h2 class="form-card-title">Stock Out Request Form</h2>
        <p class="form-card-subtitle">Remove one or more product quantities under a single stock-out request.</p>
      </div>

      <form method="POST" action="{{ route('staff.inventory.stockout.store') }}" class="transaction-form">
        @csrf

        <div class="transaction-top-grid">
          <div class="form-group form-group-full">
            <label class="form-label">Shelf</label>
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
              Tip: Click “Stock Out” from Inventory and the shelf will be selected automatically.
            </div>
          </div>

          <div class="form-group form-group-full">
            <label class="form-label">Remarks (optional)</label>
            <input
              name="remarks"
              class="form-input"
              value="{{ old('remarks') }}"
              placeholder="Notes..."
            >
          </div>
        </div>

        <div class="transaction-items-section">
          <div class="transaction-items-header">
            <div>
              <div class="transaction-items-title">Items</div>
              <div class="transaction-items-subtitle">These items will be submitted for admin approval.</div>
            </div>

            <button type="button" class="btn-action-chip" id="btnAddRow">+ Add Item</button>
          </div>

          <div class="table-card-wrap">
            <div class="activity-table-scrollable">
              <table class="activity-table">
                <thead>
                  <tr>
                    <th style="width:4%; text-align:center;">#</th>
                    <th style="width:60%;">Product (On-hand)</th>
                    <th style="width:18%; text-align:right;">Qty</th>
                    <th style="width:18%; text-align:right;">Remove</th>
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
                            {{ $p->product_name }} ({{ $p->category }}) — On hand: {{ $p->inventory?->quantity_on_hand ?? 0 }}
                          </option>
                        @endforeach
                      </select>
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
            <button type="submit" class="btn-primary">Submit Request</button>
          </div>

          <div class="transaction-footnote">
            All items will stay pending until reviewed by admin.
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
(function () {
  const tbody = document.getElementById('itemsTbody');
  const btnAdd = document.getElementById('btnAddRow');

  const productOptionsHtml = `{!! collect($products)->map(function($p){
    $label = e($p->product_name).' ('.e($p->category).') — On hand: '.((int)optional($p->inventory)->quantity_on_hand);
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
        <td>
          <input type="number" min="1" name="items[${index}][quantity]" class="form-input input-align-right" required>
        </td>
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