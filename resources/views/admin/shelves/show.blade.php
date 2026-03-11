@extends('layouts.app_a')
@section('title', 'Shelf Details')

@section('content')
<div class="header-section">
    <h1>Shelf {{ $shelf->shelf_number }}</h1>
    <p>{{ $shelf->renter?->renter_company_name ?? 'Unassigned' }}</p>
</div>

<div class="detail-page-wrap">
    <div class="detail-shell">
        <div class="detail-card">
            <div class="detail-card-header">
                <h2 class="detail-card-title">Shelf Overview</h2>
                <p class="detail-card-subtitle">Shelf assignment, status, and contract details.</p>
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Shelf Number</div>
                    <div class="detail-value">{{ $shelf->shelf_number }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        <span class="badge {{ strtolower($shelf->shelf_status) === 'available' ? 'badge-available' : 'badge-occupied' }}">
                            {{ strtoupper($shelf->shelf_status) }}
                        </span>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Monthly Rent</div>
                    <div class="detail-value">₱{{ number_format($shelf->monthly_rent, 2) }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Assigned Renter</div>
                    <div class="detail-value">{{ $shelf->renter?->renter_company_name ?? '—' }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Contract Start</div>
                    <div class="detail-value">{{ $shelf->start_date ?? '—' }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Contract End</div>
                    <div class="detail-value">{{ $shelf->end_date ?? '—' }}</div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.shelves.edit', $shelf) }}" class="btn-primary">
                Edit Shelf
            </a>

            <a href="{{ route('admin.shelves.index') }}" class="btn-text-link">
                Back to List
            </a>
        </div>
    </div>
</div>
@endsection