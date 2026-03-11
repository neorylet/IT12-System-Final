@extends('layouts.app_a')
@section('title', 'Edit Shelf')

@section('content')
<div class="header-section">
    <h1>Edit Shelf</h1>
    <p>Update shelf assignment and contract dates.</p>
</div>

<div class="form-page-wrap">
    <div class="form-shell">
        <form method="POST" action="{{ route('admin.shelves.update', $shelf) }}">
            @csrf
            @method('PUT')
            @include('admin.shelves._form', ['shelf' => $shelf])
        </form>
    </div>
</div>
@endsection