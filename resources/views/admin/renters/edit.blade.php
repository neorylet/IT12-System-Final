@extends('layouts.app_a')
@section('title', 'Edit Renter')

@section('content')
<div class="header-section">
    <h1>Edit Renter</h1>
    <p>Update renter details and contract.</p>
</div>

<div class="form-page-wrap">
    <div class="form-shell">
        <form method="POST" action="{{ route('admin.renters.update', $renter) }}">
            @csrf
            @method('PUT')
            @include('admin.renters._form', ['renter' => $renter])
        </form>
    </div>
</div>
@endsection