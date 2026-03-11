@extends('layouts.app_a')
@section('title', 'Assign Renter')

@section('content')
<div class="header-section">
    <h1>Assign Renter</h1>
    <p>Shelf {{ $shelf->shelf_number }} will use the renter’s contract dates automatically.</p>
</div>

<div class="form-page-wrap">
    <div class="form-shell">
        <form method="POST" action="{{ route('admin.shelves.assign.store', $shelf) }}">
            @csrf

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
                    <h2 class="form-card-title">Renter Assignment</h2>
                    <p class="form-card-subtitle">Select a renter to occupy this shelf.</p>
                </div>

                <div class="form-grid">
                    <div class="form-group form-group-full">
                        <label class="form-label">Renter (Company)</label>
                        <select name="renter_id" class="form-input form-select">
                            <option value="">— Select —</option>
                            @foreach($renters as $r)
                                <option value="{{ $r->renter_id }}" {{ old('renter_id') == $r->renter_id ? 'selected' : '' }}>
                                    {{ $r->renter_company_name }} ({{ $r->contract_start }} → {{ $r->contract_end }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    Assign
                </button>

                <a href="{{ route('admin.shelves.index') }}" class="btn-text-link">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection