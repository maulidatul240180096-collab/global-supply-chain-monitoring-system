<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <title>TradeIntel Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
       @vite(['resources/css/app.css', 'resources/js/app.js'])
    
       @if(request()->is('login'))

<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endif

@if(request()->is('register'))
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endif

    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
           <div class="mb-4 text-center">
    <a href="/" style="text-decoration:none;">
        <i class="bi bi-globe-americas"
           style="
           font-size:70px;
           color:#2563eb;
           ">
        </i>
    </a>
</div>
           <div class="auth-card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
