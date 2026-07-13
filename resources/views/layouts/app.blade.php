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
        
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50">
        <div class="flex h-screen overflow-hidden bg-gray-50">
            
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col h-screen overflow-hidden">
                
                <!-- Top Header -->
                <header class="bg-white shadow-sm z-10 flex-shrink-0 h-16 flex items-center justify-between px-8">
                    <!-- Page Heading (optional breadcrumbs) -->
                    <div class="flex-1">
                        @isset($header)
                            {{ $header }}
                        @endisset
                    </div>

                    <!-- Right side topnav (Notifications & User) -->
                    <div class="flex items-center gap-6">
                        <!-- Notification Bell -->
                        <button class="relative text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
                        </button>

                        <div class="border-l border-gray-200 h-6"></div>

                        <!-- User Profile Link -->
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 hover:bg-gray-50 p-2 rounded-lg transition-colors">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-bold text-gray-700 leading-tight">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                            </div>
                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-800 font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </a>
                    </div>
                </header>

                <!-- Scrollable Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-8">
                    {{ $slot }}
                </main>
                
            </div>
            
        </div>
    </body>
</html>
