@extends('layouts.app_a')
@section('title', 'Stock Out')

@section('content')
<div class="header-section">
  <h1>Stock Out</h1>
  <p>Remove quantities from inventory for a specific shelf.</p>
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
    <strong>Stock Out for:</strong>
    Shelf {{ $selectedShelf->shelf_number }} • {{ $selectedShelf->renter?->renter_company_name ?? 'Unassigned' }}
  </div>
@endif

<div class="activity-section" style="margin-top:16px;">
  <div class="activity-header">Stock Out Form</div>

  <form method="POST" action="{{ route('admin.inventory.stockout.store') }}" style="padding:12px;">
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
          Tip: Click “Stock Out” from Inventory → it auto-selects the shelf.
        </div>
      </div>

      <div style="grid-column: 1 / -1;">
        <label style="display:block; font-size:12px; color:#7b6151; margin-bottom:6px;">Remarks (optional)</label>
        <input name="remarks" class="input-field" style="width:100%;"
               value="{{ old('remarks') }}" placeholder="Notes...">
      </div>
    </div>

    <div style="margin-top:14px; border-top:1px solid #efe5da; padding-top:14px;">
      <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap;">
        <div>
          <div style="font-weight:600; color:#5d3a00;">Items</div>
          <div style="font-size:12px; color:#9a8575;">Multiple rows → saved under ONE Stock Out reference.</div>
        </div>
        <button type="button" class="btn-mini-outline" id="btnAddRow">+ Add Item</button>
      </div>

      <div class="activity-table-scrollable" style="margin-top:10px; border:1px solid #efe5da; border-radius:12px;">
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
                <select name="items[0][product_id]" class="input-field" style="width:100%;" required>
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
                <input type="number" min="1" name="items[0][quantity]" class="input-field"
                       style="width:100%; text-align:right;" value="{{ old('items.0.quantity') }}" required>
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
        <button type="submit" class="btn-primary">Save Stock Out</button>
      </div>
    </div>
  </form>
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
          <select name="items[${index}][product_id]" class="input-field" style="width:100%;" required>
            <option value="">— Select product —</option>
            ${productOptionsHtml}
          </select>
        </td>
        <td><input type="number" min="1" name="items[${index}][quantity]" class="input-field" style="width:100%; text-align:right;" required></td>
        <td style="text-align:right;"><button type="button" class="btn-mini-outline btnRemoveRow">✕</button></td>
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