@extends('layouts.auth')

@section('content')

<div class="auth-title">
    <h2>Confirm Password</h2>
    <p>Please confirm your password to continue</p>
</div>

<form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
    @csrf

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
        @error('password')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="auth-button">Confirm</button>
</form>

@endsection