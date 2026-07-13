<x-guest-layout>
    <x-slot name="splitScreen">true</x-slot>
    <x-slot name="illustration">{{ asset('images/auth_illustration.png') }}</x-slot>
    <x-slot name="footerText">Bergabunglah bersama kami untuk memantau, mengelola, dan mengevaluasi kegiatan magang secara terintegrasi.</x-slot>

    <!-- Right Side Content -->
    <div class="flex flex-col items-center mb-6">
        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-1">Form Registrasi</h3>
        <p class="text-gray-500 text-sm">Buat akun baru untuk melanjutkan</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900 placeholder-gray-400"
                placeholder="Masukan nama" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900 placeholder-gray-400"
                placeholder="Masukan email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative">
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900 placeholder-gray-400"
                placeholder="Masukan password" />
            
            <div onclick="let p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="relative">
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900 placeholder-gray-400"
                placeholder="Masukan ulang password" />
            
            <div onclick="let p = document.getElementById('password_confirmation'); p.type = p.type === 'password' ? 'text' : 'password';" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div>
            <select id="role" name="role" class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900" required>
                <option value="" disabled selected>Pilih Role Akun...</option>
                <option value="mahasiswa">Mahasiswa / User</option>
                <option value="perusahaan">Perusahaan</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Buttons -->
        <div class="pt-4 space-y-4">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-150 ease-in-out">
                {{ __('Daftar') }}
            </button>
            
            <div class="text-center text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800">
                    Login
                </a>
            </div>
        </div>
    </form>

    <div class="mt-8 text-center text-xs text-gray-400">
        &copy; 2024 Sistem Informasi Magang & KP
    </div>
</x-guest-layout>
