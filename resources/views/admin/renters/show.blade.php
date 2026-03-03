@extends('layouts.app_a')
@section('title', 'Renter Details')

@section('content')
<div class="header-section">
    <h1>Renter Details</h1>
    <p>{{ $renter->renter_company_name }}</p>
</div>

<div class="activity-section">
    <table class="activity-table" style="min-width:auto;">
        <tbody>
            <tr><th style="width:180px;">Name</th><td>{{ $renter->renter_first_name }} {{ $renter->renter_last_name }}</td></tr>
            <tr><th>Company</th><td>{{ $renter->renter_company_name }}</td></tr>
            <tr><th>Contact Person</th><td>{{ $renter->contact_person }}</td></tr>
            <tr><th>Contact Number</th><td>{{ $renter->contact_number }}</td></tr>
            <tr><th>Email</th><td>{{ $renter->email }}</td></tr>
            <tr><th>Contract</th><td>{{ $renter->contract_start }} → {{ $renter->contract_end }}</td></tr>
            <tr><th>Status</th><td><span class="badge">{{ strtoupper($renter->status) }}</span></td></tr>
        </tbody>
    </table>

    <div style="display:flex; gap:10px; margin-top:16px;">
        <a class="logout-btn" style="text-decoration:none;" href="{{ route('admin.renters.edit', $renter) }}">Edit</a>
        <a href="{{ route('admin.renters.index') }}" style="align-self:center; text-decoration:none; color:#7c6a5d;">Back</a>
    </div>
</div>
@endsection