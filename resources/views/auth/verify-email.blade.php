@extends('layouts.auth')

@section('content')

<div class="auth-title">
    <h2>Verify Email</h2>
    <p>Please check your email for verification link</p>
</div>

@if (session('status') == 'verification-link-sent')
    <div style="font-size:13px; color:green; margin-bottom:10px;">
        A new verification link has been sent.
    </div>
@endif

<form method="POST" action="{{ route('verification.send') }}" class="auth-form">
    @csrf

    <button type="submit" class="auth-button">
        Resend Verification Email
    </button>
</form>

<div style="text-align:center; margin-top:16px;">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" style="background:none; border:none; color:#8b5e3c; cursor:pointer;">
            Log out
        </button>
    </form>
</div>

@endsection