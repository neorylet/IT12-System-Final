@extends('layouts.app_a')
@section('title', 'Shelf Details')

@section('content')
<div class="header-section">
    <h1>Shelf {{ $shelf->shelf_number }}</h1>
    <p>{{ $shelf->renter?->renter_company_name ?? 'Unassigned' }}</p>
</div>

<div class="activity-section">
    <table class="activity-table" style="min-width:auto;">
        <tbody>
            <tr><th style="width:180px;">Shelf Number</th><td>{{ $shelf->shelf_number }}</td></tr>
            <tr><th>Status</th><td><span class="badge">{{ strtoupper($shelf->shelf_status) }}</span></td></tr>
            <tr><th>Monthly Rent</th><td>₱{{ number_format($shelf->monthly_rent, 2) }}</td></tr>
            <tr><th>Assigned Renter</th><td>{{ $shelf->renter?->renter_company_name ?? '—' }}</td></tr>
            <tr><th>Contract Dates</th><td>{{ $shelf->start_date }} → {{ $shelf->end_date ?? '—' }}</td></tr>
        </tbody>
    </table>

    <div style="display:flex; gap:10px; margin-top:16px;">
        <a class="logout-btn" style="text-decoration:none;" href="{{ route('admin.shelves.edit', $shelf) }}">Edit</a>
        <a href="{{ route('admin.shelves.index') }}" style="align-self:center; text-decoration:none; color:#7c6a5d;">Back</a>
    </div>
</div>
@endsection