@php
    $isEdit = isset($renter);
@endphp

@if($errors->any())
    <div class="form-alert form-alert-danger">
        <div class="form-alert-title">Please review the following:</div>
        <ul class="form-error-list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-card">
    <div class="form-card-header">
        <h2 class="form-card-title">Renter Information</h2>
        <p class="form-card-subtitle">Enter the renter's profile and contract details.</p>
    </div>

    <div class="form-grid">
        <div class="form-group">
            <label class="form-label">First Name</label>
            <input
                type="text"
                name="renter_first_name"
                class="form-input"
                value="{{ old('renter_first_name', $renter->renter_first_name ?? '') }}"
            >
        </div>

        <div class="form-group">
            <label class="form-label">Last Name</label>
            <input
                type="text"
                name="renter_last_name"
                class="form-input"
                value="{{ old('renter_last_name', $renter->renter_last_name ?? '') }}"
            >
        </div>

        <div class="form-group form-group-full">
            <label class="form-label">Company Name</label>
            <input
                type="text"
                name="renter_company_name"
                class="form-input"
                value="{{ old('renter_company_name', $renter->renter_company_name ?? '') }}"
            >
        </div>

        <div class="form-group">
            <label class="form-label">Contact Person</label>
            <input
                type="text"
                name="contact_person"
                class="form-input"
                value="{{ old('contact_person', $renter->contact_person ?? '') }}"
            >
        </div>

        <div class="form-group">
            <label class="form-label">Contact Number</label>
            <input
                type="text"
                name="contact_number"
                class="form-input"
                value="{{ old('contact_number', $renter->contact_number ?? '') }}"
            >
        </div>

        <div class="form-group form-group-full">
            <label class="form-label">Email</label>
            <input
                type="email"
                name="email"
                class="form-input"
                value="{{ old('email', $renter->email ?? '') }}"
            >
        </div>

        <div class="form-group">
            <label class="form-label">Contract Start</label>
            <input
                type="date"
                name="contract_start"
                class="form-input"
                value="{{ old('contract_start', $renter->contract_start ?? '') }}"
            >
        </div>

        <div class="form-group">
            <label class="form-label">Contract End</label>
            <input
                type="date"
                name="contract_end"
                class="form-input"
                value="{{ old('contract_end', $renter->contract_end ?? '') }}"
            >
        </div>

        <div class="form-group">
            <label class="form-label">Status</label>
            @php $val = old('status', $renter->status ?? 'active'); @endphp
            <select name="status" class="form-input form-select">
                <option value="active" {{ $val === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $val === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="form-actions">
    <button type="submit" class="btn-primary">
        {{ $isEdit ? 'Update Renter' : 'Create Renter' }}
    </button>

    <a href="{{ route('admin.renters.index') }}" class="btn-text-link">
        Cancel
    </a>
</div>