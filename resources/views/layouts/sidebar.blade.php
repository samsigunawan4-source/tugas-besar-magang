@php
    $role = auth()->user()->role;
    $sidebarColor = 'bg-gray-900'; // default
    $activeColor = 'bg-gray-800';
    $hoverColor = 'hover:bg-gray-800';

    if ($role === 'admin') {
        $sidebarColor = 'bg-slate-800'; // Dark blue-ish slate
        $activeColor = 'bg-blue-600';
        $hoverColor = 'hover:bg-slate-700';
    } elseif ($role === 'mahasiswa') {
        $sidebarColor = 'bg-[#0f3d2f]'; // Dark green from screenshot
        $activeColor = 'bg-[#1b6b50]';
        $hoverColor = 'hover:bg-[#15543e]';
    } elseif ($role === 'perusahaan') {
        $sidebarColor = 'bg-indigo-900'; // Dark purple
        $activeColor = 'bg-indigo-600';
        $hoverColor = 'hover:bg-indigo-800';
    }
@endphp

<div class="{{ $sidebarColor }} text-white w-64 min-h-screen flex flex-col transition-all duration-300 relative z-20 shadow-xl">
    <!-- Logo -->
    <div class="h-16 flex items-center px-6 border-b border-white/10">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <!-- Icon placeholder -->
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <span class="font-bold text-lg tracking-wide">SIM Magang & KP</span>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
        
        <!-- Dashboard (Semua Role) -->
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
            <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        @if(Auth::user()->role === 'admin')
            <!-- ADMIN MENU -->
            <a href="{{ route('admin.vacancies.index') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.vacancies.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Verifikasi Lowongan
            </a>
            
            <a href="{{ route('admin.applications.index') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.applications.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Verifikasi Pelamar
            </a>

            <a href="{{ route('admin.students.index') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.students.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                </svg>
                Daftar Mahasiswa
            </a>

            <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.users.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Manajemen Role (Pengguna)
            </a>

            <a href="{{ route('admin.companies.index') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.companies.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Daftar Perusahaan
            </a>

            <a href="{{ route('admin.logbooks.index') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.logbooks.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Monitoring Logbook
            </a>

            <a href="{{ route('admin.skills.index') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.skills.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
                Kategori Skill
            </a>
        @endif

        @if(Auth::user()->role === 'mahasiswa')
            <!-- MAHASISWA MENU -->
            <a href="{{ route('student.profile.edit') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('student.profile.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profil Akademik
            </a>

            <a href="{{ route('student.applications.index') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('student.applications.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Bursa & Lamaran
            </a>

            <a href="{{ route('student.logbooks.index') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('student.logbooks.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Isi Logbook
            </a>

            <a href="{{ route('student.reports.index') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('student.reports.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Tugas Akhir Magang
            </a>
        @endif

        @if(Auth::user()->role === 'perusahaan')
            <!-- PERUSAHAAN MENU -->
            <a href="{{ route('company.profile.edit') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('company.profile.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Profil Perusahaan
            </a>

            <a href="{{ route('company.vacancies.index') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('company.vacancies.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Lowongan Magang
            </a>

            <a href="{{ route('company.applications.index') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('company.applications.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Pelamar Ditempatkan
            </a>

            <a href="{{ route('company.logbooks.index') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('company.logbooks.*') ? $activeColor . ' text-white font-semibold shadow-md' : 'text-gray-300 ' . $hoverColor . ' hover:text-white transition-colors' }}">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Review Logbook
            </a>
        @endif
        
    </nav>
    
    <!-- Logout / Profile minimal -->
    <div class="p-4 border-t border-white/10">

        
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-red-500/20 text-red-300 hover:bg-red-500 hover:text-white transition-colors font-semibold text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </button>
        </form>
    </div>
</div>
