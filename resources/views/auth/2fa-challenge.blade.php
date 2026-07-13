<x-guest-layout>
    <div class="text-center mb-8 mt-2">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-indigo-50 border-4 border-indigo-100 mb-5 shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 mb-3 tracking-tight">Verifikasi Dua Langkah</h2>
        <p class="text-sm text-gray-500 max-w-sm mx-auto leading-relaxed">
            Demi keamanan akun Anda, silakan masukkan <span class="font-bold text-gray-700">6 digit kode</span> dari aplikasi Authenticator di perangkat Anda.
        </p>
    </div>

    <form method="POST" action="{{ route('2fa.verify') }}" class="space-y-6">
        @csrf

        <!-- Code -->
        <div>
            <label for="one_time_password" class="sr-only">Kode Autentikasi</label>
            <input id="one_time_password" 
                   class="block w-full text-center text-3xl tracking-[0.5em] font-mono border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-4 transition-all hover:border-indigo-400 placeholder:text-gray-300" 
                   type="text" 
                   name="one_time_password" 
                   required 
                   autofocus 
                   autocomplete="one-time-code" 
                   placeholder="••••••" 
                   maxlength="6" />
            <x-input-error :messages="$errors->get('one_time_password')" class="mt-3 text-center" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex items-center justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Verifikasi Sekarang
            </button>
        </div>
        
        <div class="text-center mt-6">
            <a href="#" onclick="window.history.back();" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors font-medium">
                &larr; Kembali ke halaman sebelumnya
            </a>
        </div>
    </form>
</x-guest-layout>
