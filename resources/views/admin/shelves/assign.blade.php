@extends('layouts.app_a')
@section('title', 'Assign Renter')

@section('content')
<div class="header-section">
    <h1>Assign Renter</h1>
    <p>Shelf {{ $shelf->shelf_number }} will use the renter’s contract dates automatically.</p>
</div>

<div style="display:flex; justify-content:center;">
    <div class="activity-section form-card" style="max-width:760px; width:100%;">
        <form method="POST" action="{{ route('admin.shelves.assign.store', $shelf) }}">
            @csrf

            <div style="margin-bottom:14px;">
                <label>Renter (Company)</label>
                <select name="renter_id" class="input-field">
                    <option value="">— Select —</option>
                    @foreach($renters as $r)
                        <option value="{{ $r->renter_id }}" {{ old('renter_id') == $r->renter_id ? 'selected' : '' }}>
                            {{ $r->renter_company_name }} ({{ $r->contract_start }} → {{ $r->contract_end }})
                        </option>
                    @endforeach
                </select>
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
                <button type="submit" class="btn-primary" style="border:none;">
                    Assign
                </button>
                <a href="{{ route('admin.shelves.index') }}" style="align-self:center; text-decoration:none; color:#7c6a5d;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection