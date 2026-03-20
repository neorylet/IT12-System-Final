<x-guest-layout>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e8ddd0;
            font-family: 'Georgia', 'Times New Roman', serif;
        }

        .card {
            background: #f5f2ee;
            border-radius: 20px;
            padding: 48px 44px 44px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 4px 32px rgba(0,0,0,0.08);
        }

        .card-title {
            font-size: 2.4rem;
            font-weight: 250;
            color: #1a1a1a;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
            font-family: 'Georgia', serif;
        }

        .card-subtitle {
            font-size: 0.875rem;
            color: #888;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            margin-bottom: 32px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #444;
            margin-bottom: 10px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .form-input {
            width: 100%;
            padding: 16px 18px;
            border: 1.5px solid #ddd;
            border-radius: 10px;
            background: #f5f2ee;
            font-size: 1rem;
            color: #1a1a1a;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .form-input::placeholder {
            color: #aaa;
        }

        .form-input:focus {
            border-color: #3b5bdb;
            box-shadow: 0 0 0 3px rgba(59, 91, 219, 0.12);
        }

        .form-input.is-invalid {
            border-color: #d9534f;
        }

        .form-error {
            color: #d9534f;
            font-size: 0.8rem;
            margin-top: 6px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .btn-primary {
            display: block;
            width: 100%;
            padding: 17px;
            background: #3b5bdb;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            letter-spacing: 0.01em;
            transition: background 0.2s, transform 0.1s;
            margin-top: 8px;
        }

        .btn-primary:hover {
            background: #3451c7;
        }

        .btn-primary:active {
            transform: scale(0.99);
        }

        .back-link {
            text-align: center;
            margin-top: 24px;
            font-size: 0.875rem;
            color: #888;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .back-link a {
            color: #3b5bdb;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="card">
        <h4 class="card-title">Reset Password</h4>
        <p class="card-subtitle">Enter your email and a new password below.</p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            {{-- Password Reset Token --}}
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{-- Email Address --}}
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    placeholder="you@example.com"
                    required
                    autofocus
                    autocomplete="username"
                    class="form-input {{ $errors->get('email') ? 'is-invalid' : '' }}"
                />
                @foreach ($errors->get('email') as $message)
                    <p class="form-error">{{ $message }}</p>
                @endforeach
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label class="form-label" for="password">New Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Create a new password"
                    required
                    autocomplete="new-password"
                    class="form-input {{ $errors->get('password') ? 'is-invalid' : '' }}"
                />
                @foreach ($errors->get('password') as $message)
                    <p class="form-error">{{ $message }}</p>
                @endforeach
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    placeholder="Repeat your new password"
                    required
                    autocomplete="new-password"
                    class="form-input {{ $errors->get('password_confirmation') ? 'is-invalid' : '' }}"
                />
                @foreach ($errors->get('password_confirmation') as $message)
                    <p class="form-error">{{ $message }}</p>
                @endforeach
            </div>

            <button type="submit" class="btn-primary">
                Reset Password
            </button>
        </form>

        <p class="back-link">
            Remember your password? <a href="{{ route('login') }}">Log in</a>
        </p>
    </div>
</x-guest-layout>