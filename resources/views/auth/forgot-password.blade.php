@extends('layouts.auth')

@section('content')

<div class="auth-title">
    <h2>Forgot Password</h2>
    <p>Enter your email to receive a reset link</p>
</div>

@if (session('status'))
    <div style="font-size:13px; color:green; margin-bottom:10px;">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="auth-form">
    @csrf

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="auth-button">
        Send Reset Link
    </button>

    <div style="text-align:center; margin-top:16px;">
        <a href="{{ route('login') }}">Back to login</a>
    </div>
</form>

@endsection