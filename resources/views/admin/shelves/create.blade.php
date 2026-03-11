@extends('layouts.app_a')
@section('title', 'Add Shelf')

@section('content')
<div class="header-section">
    <h1>Add Shelf</h1>
    <p>Create a shelf and optionally assign it to a renter.</p>
</div>

<div class="form-page-wrap">
    <div class="form-shell">
        <form method="POST" action="{{ route('admin.shelves.store') }}">
            @csrf
            @include('admin.shelves._form')
        </form>
    </div>
</div>
@endsection