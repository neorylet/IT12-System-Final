@php $isEdit = isset($shelf); @endphp

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:18px;">

    <div>
        <label>Shelf Number</label>
        <input name="shelf_number"
               value="{{ old('shelf_number', $shelf->shelf_number ?? '') }}"
               style="width:100%; padding:10px 12px; border:1px solid #efe5da; border-radius:10px;">
    </div>

    <div>
        <label>Monthly Rent</label>
        <input type="number" step="0.01" name="monthly_rent"
               value="{{ old('monthly_rent', $shelf->monthly_rent ?? '') }}"
               style="width:100%; padding:10px 12px; border:1px solid #efe5da; border-radius:10px;">
    </div>

    <div style="grid-column:1 / -1;">
        <label>Assign Renter (Company)</label>
        <select name="renter_id" style="width:100%; padding:10px 12px; border:1px solid #efe5da; border-radius:10px;">
            <option value="">— Unassigned —</option>
            @foreach($renters as $r)
                <option value="{{ $r->renter_id }}"
                    {{ (string)old('renter_id', $shelf->renter_id ?? '') === (string)$r->renter_id ? 'selected' : '' }}>
                    {{ $r->renter_company_name }}
                </option>
            @endforeach
        </select>
        <div style="font-size:12px; color:#9a8575; margin-top:6px;">
            If a renter is selected, status will automatically be set to <strong>Occupied</strong>.
        </div>
    </div>

    <div>
        <label>Contract Start</label>
        <input type="date" name="start_date"
               value="{{ old('start_date', $shelf->start_date ?? '') }}"
               style="width:100%; padding:10px 12px; border:1px solid #efe5da; border-radius:10px;">
    </div>

    <div>
        <label>Contract End</label>
        <input type="date" name="end_date"
               value="{{ old('end_date', $shelf->end_date ?? '') }}"
               style="width:100%; padding:10px 12px; border:1px solid #efe5da; border-radius:10px;">
    </div>

    {{-- we keep shelf_status hidden because we auto-set it --}}
    <input type="hidden" name="shelf_status" value="{{ old('shelf_status', $shelf->shelf_status ?? 'Available') }}">
</div>

@if($errors->any())
    <div style="margin-top:12px; padding:10px 12px; background:#fff; border:1px solid #f0d6d6; border-radius:10px; color:#8a2f2f;">
        <ul style="margin:0; padding-left:18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="display:flex; gap:10px; margin-top:16px;">
    <button type="submit" class="btn-primary" style="background:#d6a77a; color:#fff; border:none;">
        {{ $isEdit ? 'Update Shelf' : 'Create Shelf' }}
    </button>
    <a href="{{ route('admin.shelves.index') }}" style="align-self:center; text-decoration:none; color:#7c6a5d;">
        Cancel
    </a>
</div>