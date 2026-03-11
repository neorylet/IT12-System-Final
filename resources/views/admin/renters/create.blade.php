@extends('layouts.app_a')
@section('title', 'Add Renter')

@section('content')
<div class="header-section">
    <h1>Add Renter</h1>
    <p>Create a new lessee record.</p>
</div>

<div class="form-page-wrap">
    <div class="form-shell">
        <form method="POST" action="{{ route('admin.renters.store') }}">
            @csrf
            @include('admin.renters._form')
        </form>
    </div>
</div>
@endsection