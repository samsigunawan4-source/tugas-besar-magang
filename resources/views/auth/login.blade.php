<x-guest-layout>
    <x-slot name="splitScreen">true</x-slot>
    <x-slot name="illustration">{{ asset('images/auth_login_illustration.png') }}</x-slot>
    <x-slot name="footerText">Memantau, mengelola, dan mengevaluasi kegiatan magang/kerja praktik mahasiswa secara terintegrasi.</x-slot>

    <!-- Right Side Content -->
    <div class="flex flex-col items-center mb-8">
        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-1">Selamat Datang!</h3>
        <p class="text-gray-500 text-sm">Silakan login untuk melanjutkan</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                class="block w-full px-4 py-3 border-2 border-indigo-400 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900 placeholder-gray-400"
                placeholder="Email / Username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative">
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900 placeholder-gray-400"
                placeholder="Password" />
            
            <div onclick="let p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-blue-600 hover:text-blue-800 focus:outline-none" href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
        </div>

        <!-- Buttons -->
        <div class="pt-4 space-y-3">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-150 ease-in-out">
                {{ __('Login') }}
            </button>
            
            <a href="{{ route('register') }}" class="w-full flex justify-center bg-gray-50 hover:bg-gray-100 text-gray-800 font-bold py-3 px-4 rounded-lg border border-gray-200 transition duration-150 ease-in-out">
                {{ __('Register') }}
            </a>
        </div>
    </form>

    <div class="mt-12 text-center text-xs text-gray-400">
        &copy; 2024 Sistem Informasi Magang & KP
    </div>
</x-guest-layout>
