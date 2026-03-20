
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600;700;800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[linear-gradient(135deg,#f8f5f1_0%,#efe6dc_100%)] text-gray-900">
        <div class="min-h-screen flex items-center justify-center px-4 py-8">
            <div class="w-full max-w-md">
                
                <div class="text-center mb-6">
                    <a href="/" class="inline-flex justify-center">
                        <div class="w-20 h-20 rounded-2xl bg-white border border-[#eadfce] shadow-sm flex items-center justify-center">
                            <x-application-logo class="w-10 h-10 fill-current text-[#8b5e3c]" />
                        </div>
                    </a>

                    <h1 class="mt-4 text-3xl font-extrabold text-[#5c3b1e]">
                        Inventory System
                    </h1>
                    <p class="mt-2 text-sm text-[#8b6b52]">
                        Secure access for authorized users
                    </p>
                </div>

                <div class="w-full bg-white border border-[#eadfce] shadow-xl overflow-hidden rounded-2xl px-6 py-6 sm:px-8 sm:py-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>