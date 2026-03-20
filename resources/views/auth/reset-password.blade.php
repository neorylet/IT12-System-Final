@extends('layouts.auth')

@section('content')

<div class="auth-title">
    <h2>Reset Password</h2>
    <p>Set your new password</p>
</div>

<form method="POST" action="{{ route('password.store') }}" class="auth-form">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $request->email) }}" required>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required>
    </div>

    <button type="submit" class="auth-button">
        Reset Password
    </button>
</form>

@endsection