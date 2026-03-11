@extends('layouts.app_a')
@section('title', 'Renter Details')

@section('content')
<div class="header-section">
    <h1>Renter Details</h1>
    <p>{{ $renter->renter_company_name }}</p>
</div>

<div class="detail-page-wrap">
    <div class="detail-shell">
        <div class="detail-card">
            <div class="detail-card-header">
                <h2 class="detail-card-title">Profile Overview</h2>
                <p class="detail-card-subtitle">Complete renter and contract information.</p>
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Name</div>
                    <div class="detail-value">
                        {{ $renter->renter_first_name }} {{ $renter->renter_last_name }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Company</div>
                    <div class="detail-value">{{ $renter->renter_company_name }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Contact Person</div>
                    <div class="detail-value">{{ $renter->contact_person ?: '—' }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Contact Number</div>
                    <div class="detail-value">{{ $renter->contact_number ?: '—' }}</div>
                </div>

                <div class="detail-item detail-item-full">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">{{ $renter->email ?: '—' }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Contract Start</div>
                    <div class="detail-value">{{ $renter->contract_start ?: '—' }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Contract End</div>
                    <div class="detail-value">{{ $renter->contract_end ?: '—' }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        <span class="badge {{ strtolower($renter->status) === 'active' ? 'badge-available' : 'badge-occupied' }}">
                            {{ strtoupper($renter->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.renters.edit', $renter) }}" class="btn-primary">
                Edit Renter
            </a>

            <a href="{{ route('admin.renters.index') }}" class="btn-text-link">
                Back to List
            </a>
        </div>
    </div>
</div>
@endsection