@extends('layouts.app_a')
@section('title', 'Shelves')

@section('content')

<div class="header-section">
    <h1>Shelves</h1>
    <p>Manage shelf assignments and contracts.</p>
</div>

@if(session('success'))
    <div class="success-box">
        {{ session('success') }}
    </div>
@endif

<div class="toolbar">
    <form method="GET" action="{{ route('admin.shelves.index') }}" class="search-form">
        <input name="q"
               value="{{ $q }}"
               placeholder="Search shelf number or renter company..."
               class="input-field">
        <button type="submit" class="btn-outline">Search</button>
    </form>

    <a href="{{ route('admin.shelves.create') }}" class="btn-primary">
        + Add Shelf
    </a>
</div>

<div class="activity-section">
    <div class="activity-header">Shelf List</div>

    <div class="activity-table-scrollable">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Shelf</th>
                    <th>Status</th>
                    <th>Renter Company</th>
                    <th>Contract</th>
                    <th style="text-align:right;">Monthly Rent</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shelves as $shelf)
                    <tr>
                        <td><strong>{{ $shelf->shelf_number }}</strong></td>

                        <td>
                            <span class="badge {{ $shelf->shelf_status === 'Available' ? 'badge-available' : 'badge-occupied' }}">
                                {{ strtoupper($shelf->shelf_status) }}
                            </span>
                        </td>

                        <td>
                            {{ $shelf->renter?->renter_company_name ?? '— Unassigned —' }}
                        </td>

                        <td>
                            @if($shelf->start_date)
                                {{ $shelf->start_date }}
                                @if($shelf->end_date)
                                    → {{ $shelf->end_date }}
                                @endif
                            @else
                                —
                            @endif
                        </td>

                        <td style="text-align:right;">
                            ₱{{ number_format($shelf->monthly_rent, 2) }}
                        </td>

                        <td style="text-align:right; white-space:nowrap;">

                            @if($shelf->shelf_status === 'Available')
                                <a href="{{ route('admin.shelves.assign', $shelf) }}"
                                   class="btn-mini-outline"
                                   title="Assign">
                                    <i data-lucide="link" width="16" height="16"></i>
                                </a>
                            @endif

                            <a href="{{ route('admin.shelves.edit', $shelf) }}"
                               class="btn-mini-outline"
                               title="Edit">
                                <i data-lucide="pencil" width="16" height="16"></i>
                            </a>

                            <form action="{{ route('admin.shelves.destroy', $shelf) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn-danger-mini"
                                        title="Delete"
                                        onclick="return confirm('Delete this shelf?')">
                                    <i data-lucide="trash-2" width="16" height="16"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            No shelves found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top:16px;">
    {{ $shelves->links() }}
</div>

@endsection