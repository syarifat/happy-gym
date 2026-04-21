<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Happy Gym | Login Admin</title>
        <link rel="icon" type="image/png" href="{{ asset('storage/images/logo2.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-red-600 via-red-800 to-black min-h-screen flex items-center justify-center">
        
        <div class="w-full sm:max-w-md px-10 py-12 bg-white shadow-2xl rounded-2xl">
            <div class="flex flex-col items-center mb-8">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo Happy Gym" class="h-20 w-auto object-contain mb-2">
                
                <h2 class="text-xl font-bold text-gray-900 mt-2">Admin Happy Gym</h2>
            </div>

            {{ $slot }}
        </div>

    </body>
</html>