@php
  $isEdit = isset($renter);
@endphp

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
    <div>
        <label>First Name</label>
        <input name="renter_first_name" value="{{ old('renter_first_name', $renter->renter_first_name ?? '') }}"
               style="width:100%; padding:10px 12px; border:1px solid #efe5da; border-radius:10px;">
    </div>

    <div>
        <label>Last Name</label>
        <input name="renter_last_name" value="{{ old('renter_last_name', $renter->renter_last_name ?? '') }}"
               style="width:100%; padding:10px 12px; border:1px solid #efe5da; border-radius:10px;">
    </div>

    <div style="grid-column:1 / -1;">
        <label>Company Name</label>
        <input name="renter_company_name" value="{{ old('renter_company_name', $renter->renter_company_name ?? '') }}"
               style="width:100%; padding:10px 12px; border:1px solid #efe5da; border-radius:10px;">
    </div>

    <div>
        <label>Contact Person</label>
        <input name="contact_person" value="{{ old('contact_person', $renter->contact_person ?? '') }}"
               style="width:100%; padding:10px 12px; border:1px solid #efe5da; border-radius:10px;">
    </div>

    <div>
        <label>Contact Number</label>
        <input name="contact_number" value="{{ old('contact_number', $renter->contact_number ?? '') }}"
               style="width:100%; padding:10px 12px; border:1px solid #efe5da; border-radius:10px;">
    </div>

    <div style="grid-column:1 / -1;">
        <label>Email</label>
        <input name="email" value="{{ old('email', $renter->email ?? '') }}"
               style="width:100%; padding:10px 12px; border:1px solid #efe5da; border-radius:10px;">
    </div>

    <div>
        <label>Contract Start</label>
        <input type="date" name="contract_start" value="{{ old('contract_start', $renter->contract_start ?? '') }}"
               style="width:100%; padding:10px 12px; border:1px solid #efe5da; border-radius:10px;">
    </div>

    <div>
        <label>Contract End</label>
        <input type="date" name="contract_end" value="{{ old('contract_end', $renter->contract_end ?? '') }}"
               style="width:100%; padding:10px 12px; border:1px solid #efe5da; border-radius:10px;">
    </div>

    <div>
        <label>Status</label>
        <select name="status" style="width:100%; padding:10px 12px; border:1px solid #efe5da; border-radius:10px;">
            @php $val = old('status', $renter->status ?? 'active'); @endphp
            <option value="active" {{ $val === 'active' ? 'selected' : '' }}>active</option>
            <option value="inactive" {{ $val === 'inactive' ? 'selected' : '' }}>inactive</option>
        </select>
    </div>
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
        {{ $isEdit ? 'Update Renter' : 'Create Renter' }}
    </button>
    <a href="{{ route('admin.renters.index') }}" style="align-self:center; text-decoration:none; color:#7c6a5d;">
        Cancel
    </a>
</div>