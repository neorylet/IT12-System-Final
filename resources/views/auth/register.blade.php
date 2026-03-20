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
            --shadow-lg: 0 12px 40px rgba(0,0,0,0.10), 0 2px 8px rgba(0,0,0,0.06);
            --radius: 10px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #f5e9d6;
            min-height: 100vh;
            overflow-y: auto;
        }

        .register-wrapper {
            min-height: calc(100vh - 4rem);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .container-register {
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

        .card-register {
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

        .input-register {
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

        .input-register:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(45, 91, 227, 0.12);
        }

        .input-register.is-invalid {
            border-color: #f87171;
        }

        .invalid-feedback {
            font-size: 0.8rem;
            color: #dc2626;
            margin-top: 0.35rem;
        }

        .btn-primary-register {
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

        .btn-primary-register:hover {
            background: var(--accent-hover);
            box-shadow: 0 4px 16px rgba(45, 91, 227, 0.3);
        }

        .btn-primary-register:active {
            transform: scale(0.99);
        }

        .scrolling-text {
            overflow: hidden;
            white-space: nowrap;
            margin-top: 1rem;
            font-size: 0.8rem;
            color: var(--muted);
        }

        .scrolling-text span {
            display: inline-block;
            padding-left: 100%;
            animation: scroll-left 15s linear infinite;
        }

        @keyframes scroll-left {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }

        .btn-secondary-register {
            margin-top: 0.75rem;
            width: 100%;
            padding: 0.75rem 1rem;
            background: transparent;
            color: var(--accent);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            cursor: pointer;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
        }

        .btn-secondary-register:hover {
            background: #e4e0d9;
            border-color: var(--accent);
        }

        .login-row {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--muted);
        }

        .login-row a {
            color: var(--accent);
            font-weight: 500;
            text-decoration: none;
        }

        .login-row a:hover { text-decoration: underline; }
    </style>

    <div class="register-wrapper">
        <div class="container-register">
            <div class="brand">
                <img src="{{ asset('build/images/whatever-logo.png') }}" alt="Application logo" class="brand-logo">
            </div>

            <div class="card-register">
                <div class="card-header">
                    <h1 class="card-title">Create account</h1>
                    <p class="card-subtitle">Fill in your details to get started.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                            autofocus
                            class="input-register {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            placeholder="Your full name"
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            class="input-register {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            placeholder="you@example.com"
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            class="input-register {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="Create a password"
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            class="input-register"
                            placeholder="Repeat your password"
                        >
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary-register">
                        Register
                    </button>

                    <div class="scrolling-text">
                        <span>Welcome · Make sure your information is correct before registering · You can always update profile details later.</span>
                    </div>
                </form>
                <div class="login-row">
                    Already have an account?
                    <a href="{{ route('login') }}">Log in</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
