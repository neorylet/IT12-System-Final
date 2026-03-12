<x-guest-layout> 
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Fraunces:ital,wght@0,300;0,400;1,300&display=swap');

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #f0ede8;
            --surface: #faf9f7;
            --border: #ddd9d2;
            --text: #1a1814;
            --muted: #8a8278;
            --accent: #2d5be3;
            --accent-hover: #1e45c7;
            --shadow: 0 2px 8px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-lg: 0 12px 40px rgba(0,0,0,0.10), 0 2px 8px rgba(0,0,0,0.06);
            --radius: 10px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #f5e9d6;
            min-height: 100vh;
            overflow-y: auto;
        }

        .login-wrapper {
            min-height: calc(100vh - 4rem);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .container-login {
            width: 100%;
            max-width: 420px;
        }

        .brand {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-logo {
            height: 120px;
            width: auto;
            object-fit: contain;
        }

        .card-login {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            animation: fadeUp 0.4s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card-header {
            margin-bottom: 2rem;
        }

        .card-title {
            font-family: 'Fraunces', serif;
            font-size: 1.75rem;
            font-weight: 300;
            color: var(--text);
            letter-spacing: -0.03em;
            line-height: 1.2;
        }

        .card-subtitle {
            margin-top: 0.4rem;
            font-size: 0.875rem;
            color: var(--muted);
            font-weight: 400;
        }

        .alert {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            border-radius: var(--radius);
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text);
            letter-spacing: 0.03em;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .input-wrap {
            position: relative;
        }

        .input-login {
            width: 100%;
            padding: 0.75rem 1rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9375rem;
            color: var(--text);
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            appearance: none;
        }

        .input-login:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(45, 91, 227, 0.12);
        }

        .input-login.is-invalid {
            border-color: #f87171;
        }

        .invalid-feedback {
            font-size: 0.8rem;
            color: #dc2626;
            margin-top: 0.35rem;
        }

        .toggle-pw {
            position: absolute;
            right: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            padding: 0;
            line-height: 0;
            transition: color 0.15s;
        }

        .toggle-pw:hover { color: var(--text); }

        .form-footer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
            margin-top: 0.25rem;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--muted);
            cursor: pointer;
            text-transform: none;
            letter-spacing: 0;
            font-weight: 400;
        }

        .checkbox-input {
            width: 16px;
            height: 16px;
            border: 1.5px solid var(--border);
            border-radius: 4px;
            appearance: none;
            background: #fff;
            cursor: pointer;
            transition: background 0.15s, border-color 0.15s;
            flex-shrink: 0;
            position: relative;
        }

        .checkbox-input:checked {
            background: var(--accent);
            border-color: var(--accent);
        }

        .checkbox-input:checked::after {
            content: '';
            position: absolute;
            left: 3px; top: 1px;
            width: 8px; height: 5px;
            border-left: 2px solid #fff;
            border-bottom: 2px solid #fff;
            transform: rotate(-45deg);
        }

        .forgot-link {
            font-size: 0.875rem;
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.15s;
        }

        .forgot-link:hover { opacity: 0.75; }

        .btn-primary-login {
            width: 100%;
            padding: 0.825rem 1rem;
            background: var(--accent);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9375rem;
            font-weight: 500;
            border: none;
            border-radius: var(--radius);
            cursor: pointer;
            transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
            letter-spacing: 0.01em;
            box-shadow: 0 2px 8px rgba(45, 91, 227, 0.25);
        }

        .btn-primary-login:hover {
            background: var(--accent-hover);
            box-shadow: 0 4px 16px rgba(45, 91, 227, 0.3);
        }

        .btn-primary-login:active {
            transform: scale(0.99);
        }

        .register-row {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--muted);
        }

        .register-row a {
            color: var(--accent);
            font-weight: 500;
            text-decoration: none;
        }

        .register-row a:hover { text-decoration: underline; }
    </style>

    <div class="login-wrapper">
        <div class="container-login">
            <div class="brand">
                <img src="{{ asset('build/images/whatever-logo.png') }}" alt="Application logo" class="brand-logo">
            </div>

            <div class="card-login">
                <div class="card-header">
                    <h1 class="card-title">Welcome </h1>
                    <p class="card-subtitle">Sign in your account to continue.</p>
                </div>

                @if (session('status'))
                    <div class="alert">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-wrap">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                autofocus
                                class="input-login {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                placeholder="you@example.com"
                            >
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                autocomplete="current-password"
                                class="input-login {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                placeholder="••••••••"
                            >
                            <button type="button" class="toggle-pw" onclick="togglePassword()" aria-label="Toggle password visibility">
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-footer-row">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" id="remember" class="checkbox-input" {{ old('remember') ? 'checked' : '' }}>
                            Remember Me
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-primary-login">Log In</button>
                </form>

                @if (Route::has('register'))
                    <div class="register-row">
                        Don't have an account? <a href="{{ route('register') }}">Sign up</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }
    </script>
</x-guest-layout>
