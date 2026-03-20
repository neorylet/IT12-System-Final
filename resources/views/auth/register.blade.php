@extends('layouts.auth')

@section('content')

<div class="auth-title">
    <h2>Create Account</h2>
    <p>Fill in the details below to register a new account</p>
</div>

<form method="POST" action="{{ route('register') }}" class="auth-form">
    @csrf

    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required autofocus>
        @error('name')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
        @error('password')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required>
        @error('password_confirmation')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="auth-button">Register</button>

    <div style="text-align:center; margin-top:16px;">
        <span>Already have an account?</span>
        <a href="{{ route('login') }}">Login</a>
    </div>
</form>

@endsection