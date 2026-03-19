@extends('layouts.app_a')
@section('title', 'Stock In')

@section('content')
<div class="header-section">
    <h1>Stock In</h1>
    <p>Add batches and quantities to inventory for a specific shelf.</p>
</div>

@if ($errors->any())
    <div class="form-page-wrap form-page-wrap-tight">
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
    <div class="form-page-wrap form-page-wrap-tight">
        <div class="success-box form-inline-note">
            <strong>Stock In for:</strong>
            Shelf {{ $selectedShelf->shelf_number }} • {{ $selectedShelf->renter?->renter_company_name ?? 'Unassigned' }}
        </div>
    </div>
@endif

<div class="form-page-wrap">
    <div class="form-shell form-shell-wide">
        <div class="form-card stockin-card">
            <div class="form-card-header">
                <h2 class="form-card-title">Transaction Details</h2>
                <p class="form-card-subtitle">
                    Set the transaction information below. All item rows will be saved under one stock-in record.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.inventory.stockin.store') }}" class="transaction-form">
                @csrf

                <div class="transaction-top-grid">
                    <div class="form-group form-group-full">
                        <label class="form-label">Shelf</label>
                        <select name="shelf_id" class="form-input form-select" required>
                            <option value="">— Select shelf —</option>
                            @foreach($shelves as $s)
                                <option
                                    value="{{ $s->shelf_id }}"
                                    {{ (string) old('shelf_id', $selectedShelfId ?? '') === (string) $s->shelf_id ? 'selected' : '' }}
                                >
                                    {{ $s->shelf_number }} — {{ $s->renter?->renter_company_name ?? 'Unassigned' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-help-text">
                            Tip: If you clicked “Stock In” from Inventory, the shelf may already be preselected.
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Reference No <span class="form-label-note">(optional)</span></label>
                        <input
                            type="text"
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

                    <div class="form-group form-group-full">
                        <label class="form-label">Remarks <span class="form-label-note">(optional)</span></label>
                        <input
                            type="text"
                            name="remarks"
                            class="form-input"
                            value="{{ old('remarks') }}"
                            placeholder="Notes or delivery remarks..."
                        >
                    </div>
                </div>

                <div class="transaction-items-section">
                    <div class="transaction-items-header">
                        <div>
                            <h3 class="transaction-items-title">Items</h3>
                            <p class="transaction-items-subtitle">
                                Add multiple products below. Everything will be saved under one stock-in reference.
                            </p>
                        </div>

                        <button type="button" class="btn-outline btn-add-item" id="btnAddRow">
                            + Add Item
                        </button>
                    </div>

                    <div class="table-card-wrap">
                        <div class="activity-table-scrollable">
                            <table class="activity-table stockin-items-table" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th class="col-row text-center">#</th>
                                        <th class="col-product">Product</th>
                                        <th class="col-lot">Lot #</th>
                                        <th class="col-date">Mfg</th>
                                        <th class="col-date">Expiry</th>
                                        <th class="col-qty text-right">Qty</th>
                                        <th class="col-cost text-right">Unit Cost</th>
                                        <th class="col-remove text-right">Remove</th>
                                    </tr>
                                </thead>

                                <tbody id="itemsTbody">
                                    <tr>
                                        <td class="rowNo text-center">1</td>

                                        <td>
                                            <select name="items[0][product_id]" class="form-input form-select" required>
                                                <option value="">— Select product —</option>
                                                @foreach($products as $p)
                                                    <option
                                                        value="{{ $p->product_id }}"
                                                        {{ (string) old('items.0.product_id') === (string) $p->product_id ? 'selected' : '' }}
                                                    >
                                                        {{ $p->product_name }} ({{ $p->category }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <input
                                                type="text"
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
                                                placeholder="0.00"
                                            >
                                        </td>

                                        <td class="text-right">
                                            <button type="button" class="btn-row-remove btnRemoveRow" aria-label="Remove row">✕</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="transaction-footnote">
                        Example: Add 5 rows, then click <strong>Save Stock In</strong> once. All items will belong to the same transaction.
                    </div>

                    <div class="form-actions form-actions-right">
                        <a href="{{ route('admin.inventory.index') }}" class="btn-outline">Cancel</a>
                        <button type="submit" class="btn-primary">Save Stock In</button>
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
        $label = e($p->product_name) . ' (' . e($p->category) . ')';
        return '<option value="' . $p->product_id . '">' . $label . '</option>';
    })->implode('') !!}`;

    function rowHtml(index) {
        return `
            <tr>
                <td class="rowNo text-center">${index + 1}</td>

                <td>
                    <select name="items[${index}][product_id]" class="form-input form-select" required>
                        <option value="">— Select product —</option>
                        ${productOptionsHtml}
                    </select>
                </td>

                <td>
                    <input
                        type="text"
                        name="items[${index}][lot_number]"
                        class="form-input"
                        placeholder="LOT-001"
                    >
                </td>

                <td>
                    <input
                        type="date"
                        name="items[${index}][manufacturing_date]"
                        class="form-input"
                    >
                </td>

                <td>
                    <input
                        type="date"
                        name="items[${index}][expiration_date]"
                        class="form-input"
                    >
                </td>

                <td>
                    <input
                        type="number"
                        min="1"
                        name="items[${index}][quantity]"
                        class="form-input input-align-right"
                        required
                    >
                </td>

                <td>
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        name="items[${index}][unit_cost]"
                        class="form-input input-align-right"
                        placeholder="0.00"
                    >
                </td>

                <td class="text-right">
                    <button type="button" class="btn-row-remove btnRemoveRow" aria-label="Remove row">✕</button>
                </td>
            </tr>
        `;
    }

    function reindex() {
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