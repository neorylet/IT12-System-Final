@extends('layouts.auth')

@section('content')

<!-- TITLE HERE (YES, THIS IS FINE) -->
<div class="auth-title">
    <h2>Login</h2>
    <p>Enter your credentials to access the system</p>
</div>

<form method="POST" action="{{ route('login') }}" class="auth-form">
    @csrf

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <div class="form-row">
        <label>
            <input type="checkbox" name="remember"> Remember
        </label>

        <a href="{{ route('password.request') }}">Forgot?</a>
    </div>

    <button type="submit" class="auth-button">Login</button>

    <div style="text-align:center; margin-top:16px;">
        <span>Don’t have an account?</span>
        <a href="{{ route('register') }}">Create one</a>
    </div>

</form>

@endsection