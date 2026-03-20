<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth | Inventory System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: #f4efe8;
            color: #4e3422;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* LEFT SIDE */
        .auth-left {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .auth-brand {
            max-width: 320px;
        }

        .auth-brand h1 {
            font-size: 32px;
            margin: 0;
            color: #5c3b1e;
        }

        .auth-brand p {
            margin-top: 10px;
            font-size: 15px;
            color: #8b6b52;
            line-height: 1.5;
        }

        /* RIGHT SIDE */
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .auth-card {
            width: 100%;
            max-width: 380px;
            background: #ffffff;
            border: 1px solid #eadfce;
            border-radius: 18px;
            padding: 32px 28px;
            box-shadow: 0 18px 40px rgba(80, 50, 20, 0.08);
        }

        /* FORM */
        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #5c3b1e;
        }

        .form-group input {
            height: 44px;
            padding: 0 14px;
            border: 1px solid #d8c7b3;
            border-radius: 12px;
            font-size: 14px;
        }

        .form-group input:focus {
            border-color: #c08b5c;
            box-shadow: 0 0 0 3px rgba(192,139,92,0.16);
            outline: none;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }

        .auth-button {
            height: 46px;
            border: none;
            border-radius: 12px;
            background: #c08b5c;
            color: white;
            font-weight: 700;
            cursor: pointer;
        }

        .auth-button:hover {
            background: #a97447;
        }

        /* MOBILE */
        @media (max-width: 768px) {
            .auth-wrapper {
                flex-direction: column;
            }

            .auth-left {
                padding: 20px;
                text-align: center;
            }
        }

        .auth-title {
    margin-bottom: 20px;
}

.auth-title h2 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #5c3b1e;
}

.auth-title p {
    margin-top: 6px;
    font-size: 13px;
    color: #8b6b52;
}
    </style>
</head>
<body>

<div class="auth-wrapper">

    <!-- LEFT SIDE -->
    <div class="auth-left">
        <div class="auth-brand">
            <h1>Whatever Concept</h1>
            <h1>Store</h1>

            <p>
                Manage your products, stock levels, and transactions efficiently with a clean and secure system.
            </p>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="auth-right">
        <div class="auth-card">
            @yield('content')
        </div>
    </div>

</div>

</body>
</html>