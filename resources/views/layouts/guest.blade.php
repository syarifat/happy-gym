<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Admin Happy Gym') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-red-600 via-red-800 to-black min-h-screen flex items-center justify-center">
        
        <div class="w-full sm:max-w-md px-10 py-12 bg-white shadow-2xl rounded-2xl">
            <div class="flex flex-col items-center mb-8">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center font-bold text-xl">
                        h
                    </div>
                    <span class="text-2xl font-extrabold text-gray-800 tracking-tight">happy<span class="text-red-600">gym</span></span>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mt-2">Admin Happy Gym</h2>
            </div>

            {{ $slot }}
        </div>

    </body>
</html>