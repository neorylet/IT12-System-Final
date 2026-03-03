@extends('layouts.app_a')
@section('title', 'Stock In')

@section('content')
<div class="header-section">
    <h1>Stock In</h1>
    <p>Add batches / quantities to inventory for a specific shelf.</p>
</div>

@if ($errors->any())
  <div class="success-box" style="border-color:#f3c4c4; background:#fff7f7;">
    <strong style="color:#9b2c2c;">Please fix the errors:</strong>
    <ul style="margin:8px 0 0 18px;">
      @foreach($errors->all() as $e)
        <li style="color:#9b2c2c;">{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

@if(!empty($selectedShelf))
  <div class="success-box" style="margin-top:12px;">
    <strong>Stock In for:</strong>
    Shelf {{ $selectedShelf->shelf_number }} • {{ $selectedShelf->renter?->renter_company_name ?? 'Unassigned' }}
  </div>
@endif

<div class="activity-section" style="margin-top:16px;">
  <div class="activity-header">Stock In Form</div>

  <form method="POST" action="{{ route('admin.inventory.stockin.store') }}" style="padding:12px;">
    @csrf

    <div class="form-grid" style="display:grid; grid-template-columns: 1.2fr 1fr 1fr; gap:12px;">
      <div style="grid-column: 1 / -1;">
        <label style="display:block; font-size:12px; color:#7b6151; margin-bottom:6px;">Shelf</label>
        <select name="shelf_id" class="input-field" style="width:100%;" required>
          <option value="">— Select shelf —</option>
          @foreach($shelves as $s)
            <option value="{{ $s->shelf_id }}"
              {{ (string)old('shelf_id', $selectedShelfId ?? '') === (string)$s->shelf_id ? 'selected' : '' }}>
              {{ $s->shelf_number }} — {{ $s->renter?->renter_company_name ?? 'Unassigned' }}
            </option>
          @endforeach
        </select>
        <div style="font-size:12px; color:#9a8575; margin-top:6px;">
          Tip: Click “Stock In” from Inventory → it auto-selects the shelf.
        </div>
      </div>

      <div>
        <label style="display:block; font-size:12px; color:#7b6151; margin-bottom:6px;">Reference No (optional)</label>
        <input name="reference_no" class="input-field" style="width:100%;"
               value="{{ old('reference_no') }}" placeholder="e.g. DR-00012">
      </div>

      <div>
        <label style="display:block; font-size:12px; color:#7b6151; margin-bottom:6px;">Transaction Date</label>
        <input type="date" name="transaction_date" class="input-field" style="width:100%;"
               value="{{ old('transaction_date', now()->toDateString()) }}" required>
      </div>

      <div>
        <label style="display:block; font-size:12px; color:#7b6151; margin-bottom:6px;">Remarks (optional)</label>
        <input name="remarks" class="input-field" style="width:100%;"
               value="{{ old('remarks') }}" placeholder="Notes...">
      </div>
    </div>

    <div style="margin-top:14px; border-top:1px solid #efe5da; padding-top:14px;">
      <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap;">
        <div>
          <div style="font-weight:600; color:#5d3a00;">Items</div>
          <div style="font-size:12px; color:#9a8575;">Add multiple items — all saved under ONE Stock In reference.</div>
        </div>
        <button type="button" class="btn-mini-outline" id="btnAddRow">+ Add Item</button>
      </div>

      <div class="activity-table-scrollable" style="margin-top:10px; border:1px solid #efe5da; border-radius:12px;">
        <table class="activity-table" id="itemsTable">
          <thead>
            <tr>
              <th style="width:4%; text-align:center;">#</th>
              <th style="width:26%;">Product</th>
              <th style="width:12%;">Lot # (opt)</th>
              <th style="width:12%;">Mfg (opt)</th>
              <th style="width:12%;">Expiry (opt)</th>
              <th style="width:10%; text-align:right;">Qty</th>
              <th style="width:12%; text-align:right;">Unit Cost</th>
              <th style="width:8%; text-align:right;">Remove</th>
            </tr>
          </thead>

          <tbody id="itemsTbody">
            {{-- default row --}}
            <tr>
              <td class="rowNo" style="text-align:center;">1</td>

              <td>
                <select name="items[0][product_id]" class="input-field" style="width:100%;" required>
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
                <input name="items[0][lot_number]"
                       class="input-field"
                       style="width:100%;"
                       placeholder="LOT-001"
                       value="{{ old('items.0.lot_number') }}">
              </td>

              <td>
                <input type="date"
                       name="items[0][manufacturing_date]"
                       class="input-field"
                       style="width:100%;"
                       value="{{ old('items.0.manufacturing_date') }}">
              </td>

              <td>
                <input type="date"
                       name="items[0][expiration_date]"
                       class="input-field"
                       style="width:100%;"
                       value="{{ old('items.0.expiration_date') }}">
              </td>

              <td>
                <input type="number"
                       min="1"
                       name="items[0][quantity]"
                       class="input-field"
                       style="width:100%; text-align:right;"
                       value="{{ old('items.0.quantity') }}"
                       required>
              </td>

              <td>
                <input type="number"
                       step="0.01"
                       min="0"
                       name="items[0][unit_cost]"
                       class="input-field"
                       style="width:100%; text-align:right;"
                       value="{{ old('items.0.unit_cost') }}">
              </td>

              <td style="text-align:right;">
                <button type="button" class="btn-mini-outline btnRemoveRow">✕</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div style="margin-top:12px; display:flex; gap:10px; justify-content:flex-end; flex-wrap:wrap;">
        <a href="{{ route('admin.inventory.index') }}" class="btn-outline" style="text-decoration:none;">Cancel</a>
        <button type="submit" class="btn-primary">Save Stock In</button>
      </div>

      <div style="margin-top:10px; font-size:12px; color:#9a8575;">
        Example: Add 5 rows → click “Save Stock In” once → all 5 items share the same transaction reference.
      </div>
    </div>
  </form>
</div>

<script>
(function () {
  const tbody = document.getElementById('itemsTbody');
  const btnAdd = document.getElementById('btnAddRow');

  const productOptionsHtml = `{!! collect($products)->map(function($p){
      $label = e($p->product_name).' ('.e($p->category).')';
      return '<option value="'.$p->product_id.'">'.$label.'</option>';
    })->implode('') !!}`;

  function rowHtml(index){
    return `
      <tr>
        <td class="rowNo" style="text-align:center;">${index + 1}</td>

        <td>
          <select name="items[${index}][product_id]" class="input-field" style="width:100%;" required>
            <option value="">— Select product —</option>
            ${productOptionsHtml}
          </select>
        </td>

        <td><input name="items[${index}][lot_number]" class="input-field" style="width:100%;" placeholder="LOT-001"></td>
        <td><input type="date" name="items[${index}][manufacturing_date]" class="input-field" style="width:100%;"></td>
        <td><input type="date" name="items[${index}][expiration_date]" class="input-field" style="width:100%;"></td>

        <td><input type="number" min="1" name="items[${index}][quantity]" class="input-field" style="width:100%; text-align:right;" required></td>
        <td><input type="number" step="0.01" min="0" name="items[${index}][unit_cost]" class="input-field" style="width:100%; text-align:right;"></td>

        <td style="text-align:right;">
          <button type="button" class="btn-mini-outline btnRemoveRow">✕</button>
        </td>
      </tr>
    `;
  }

  function reindex(){
    const rows = Array.from(tbody.querySelectorAll('tr'));

    rows.forEach((tr, i) => {
      // update row number
      const rn = tr.querySelector('.rowNo');
      if (rn) rn.textContent = String(i + 1);

      // update all input/select names
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