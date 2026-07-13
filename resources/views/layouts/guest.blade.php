<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-white">
        @isset($splitScreen)
            <div class="min-h-screen flex">
                <!-- Left Side (Illustration & Info) -->
                <div class="hidden lg:flex lg:w-5/12 bg-gradient-to-b from-indigo-50 via-blue-50 to-blue-100 flex-col justify-between p-12 relative overflow-hidden">
                    <div class="text-center z-10">
                        <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Sistem Informasi Monitoring</h2>
                        <h2 class="text-3xl font-extrabold text-blue-600 tracking-tight">Magang dan Kerja Praktik Mahasiswa</h2>
                    </div>

                    <div class="flex-grow flex items-center justify-center z-10 py-10">
                        <img src="{{ $illustration }}" alt="Illustration" class="w-full max-w-sm drop-shadow-xl" />
                    </div>

                    <div class="text-center z-10 text-gray-600 text-sm max-w-sm mx-auto">
                        {{ $footerText }}
                    </div>
                    
                    <!-- Decorative Background Elements -->
                    <div class="absolute top-0 left-0 w-64 h-64 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 right-0 w-80 h-80 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 translate-x-1/3 translate-y-1/3"></div>
                </div>

                <!-- Right Side (Form) -->
                <div class="w-full lg:w-7/12 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-white relative">
                    <div class="w-full max-w-md">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        @else
            <!-- Default Auth Layout (for Forgot Password, etc) -->
            <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                <div>
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-blue-600" />
                    </a>
                </div>

                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    {{ $slot }}
                </div>
            </div>
        @endisset
    </body>
</html>
