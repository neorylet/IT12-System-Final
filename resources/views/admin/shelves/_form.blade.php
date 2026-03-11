@php
    $isEdit = isset($shelf);
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
        <h2 class="form-card-title">Shelf Information</h2>
        <p class="form-card-subtitle">Enter the shelf details and optional renter assignment.</p>
    </div>

    <div class="form-grid">
        <div class="form-group">
            <label class="form-label">Shelf Number</label>
            <input
                type="text"
                name="shelf_number"
                class="form-input"
                value="{{ old('shelf_number', $shelf->shelf_number ?? '') }}"
            >
        </div>

        <div class="form-group">
            <label class="form-label">Monthly Rent</label>
            <input
                type="number"
                step="0.01"
                name="monthly_rent"
                class="form-input"
                value="{{ old('monthly_rent', $shelf->monthly_rent ?? '') }}"
            >
        </div>

        <div class="form-group form-group-full">
            <label class="form-label">Assign Renter (Company)</label>
            <select name="renter_id" class="form-input form-select">
                <option value="">— Unassigned —</option>
                @foreach($renters as $r)
                    <option value="{{ $r->renter_id }}"
                        {{ (string) old('renter_id', $shelf->renter_id ?? '') === (string) $r->renter_id ? 'selected' : '' }}>
                        {{ $r->renter_company_name }}
                    </option>
                @endforeach
            </select>
            <div class="form-help-text">
                If a renter is selected, status will automatically be set to <strong>Occupied</strong>.
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Contract Start</label>
            <input
                type="date"
                name="start_date"
                class="form-input"
                value="{{ old('start_date', $shelf->start_date ?? '') }}"
            >
        </div>

        <div class="form-group">
            <label class="form-label">Contract End</label>
            <input
                type="date"
                name="end_date"
                class="form-input"
                value="{{ old('end_date', $shelf->end_date ?? '') }}"
            >
        </div>

        <input
            type="hidden"
            name="shelf_status"
            value="{{ old('shelf_status', $shelf->shelf_status ?? 'Available') }}"
        >
    </div>
</div>

<div class="form-actions">
    <button type="submit" class="btn-primary">
        {{ $isEdit ? 'Update Shelf' : 'Create Shelf' }}
    </button>

    <a href="{{ route('admin.shelves.index') }}" class="btn-text-link">
        Cancel
    </a>
</div>