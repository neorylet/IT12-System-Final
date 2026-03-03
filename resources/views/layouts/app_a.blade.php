<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin')</title>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="margin:0;">
    <div class="app-layout">

        {{-- Dynamic Sidebar --}}
        @if(auth()->check() && auth()->user()->role === 'staff')
            @include('sidebar.s_sidebar')
        @else
            @include('sidebar.a_sidebar')
        @endif

        <main class="app-content">
            @yield('content')
        </main>
    </div>

    <!-- Initialize Lucide AFTER DOM loads -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            lucide.createIcons();
        });
    </script>
</body>
</html>