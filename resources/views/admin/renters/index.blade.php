@extends('layouts.app_a')
@section('title', 'Renters')

@section('content')

<div class="header-section">
    <h1>Renters</h1>
    <p>Manage lessees and contract status.</p>
</div>

@if(session('success'))
    <div class="success-box">
        {{ session('success') }}
    </div>
@endif

<div class="toolbar">
    <form method="GET" action="{{ route('admin.renters.index') }}" class="search-form">
        <input class="input-field"
               name="q"
               value="{{ $q }}"
               placeholder="Search name, company, email...">
        <button type="submit" class="btn-outline">Search</button>
    </form>

    <a href="{{ route('admin.renters.create') }}" class="btn-primary">
        + Add Renter
    </a>
</div>

<div class="activity-section">
    <div class="activity-header">Renter List</div>

    <div class="activity-table-scrollable">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($renters as $renter)
                    <tr>
                        <td>
                            {{ $renter->renter_first_name }}
                            {{ $renter->renter_last_name }}
                        </td>

                        <td>{{ $renter->renter_company_name }}</td>
                        <td>{{ $renter->email }}</td>
                        <td>{{ $renter->contact_number }}</td>

                        <td>
                            <span class="badge">
                                {{ strtoupper($renter->status) }}
                            </span>
                        </td>

                        <td style="text-align:right; white-space:nowrap;">

                            <a href="{{ route('admin.renters.show', $renter) }}"
                               class="btn-mini-outline"
                               title="View">
                                <i data-lucide="eye" width="16" height="16"></i>
                            </a>

                            <a href="{{ route('admin.renters.edit', $renter) }}"
                               class="btn-mini-outline"
                               title="Edit">
                                <i data-lucide="pencil" width="16" height="16"></i>
                            </a>

                            <form action="{{ route('admin.renters.destroy', $renter) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn-danger-mini"
                                        title="Delete"
                                        onclick="return confirm('Delete this renter?')">
                                    <i data-lucide="trash-2" width="16" height="16"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            No renters found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top:12px;">
    {{ $renters->links() }}
</div>

@endsection