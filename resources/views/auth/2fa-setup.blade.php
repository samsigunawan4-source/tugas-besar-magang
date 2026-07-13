<x-guest-layout>
    <div class="mb-6 text-sm text-gray-600 dark:text-gray-400">
        <h2 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Panduan Aktivasi Keamanan 2FA:</h2>
        <ol class="list-decimal list-inside space-y-2">
            <li>Download aplikasi <strong>Google Authenticator</strong> di HP Anda melalui Play Store (Android) atau App Store (iOS).</li>
            <li>Buka aplikasi tersebut, klik ikon tambah (+), lalu pilih opsi <strong>Scan a QR code</strong> (Pindai kode QR).</li>
            <li>Arahkan kamera HP Anda ke gambar QR Code di bawah ini.</li>
            <li>Setelah berhasil di-scan, aplikasi akan menampilkan <strong>6 digit kode angka</strong>. Masukkan kode tersebut pada kolom di paling bawah halaman ini.</li>
        </ol>
    </div>

    <div class="flex justify-center mb-4">
        <div class="p-2 bg-white rounded-lg border border-gray-200">
            <img src="data:image/svg+xml;base64,{{ $qrCodeImage }}" alt="QR Code" class="w-48 h-48" />
        </div>
    </div>

    <div class="mb-6 text-sm text-gray-600 dark:text-gray-400 text-center bg-gray-50 dark:bg-gray-800 p-3 rounded-md">
        Kamera bermasalah? Pilih opsi "Enter a setup key" di aplikasi dan masukkan kode rahasia ini:<br>
        <strong class="text-lg tracking-widest text-indigo-600 dark:text-indigo-400 mt-2 block">{{ $secret }}</strong>
    </div>

    <form method="POST" action="{{ route('2fa.verify-setup') }}">
        @csrf

        <!-- Code -->
        <div>
            <x-input-label for="one_time_password" value="Masukkan 6 Digit Kode Verifikasi" />
            <x-text-input id="one_time_password" class="block mt-1 w-full text-center text-xl tracking-widest" type="text" name="one_time_password" required autofocus placeholder="123456" maxlength="6" autocomplete="off" />
            <x-input-error :messages="$errors->get('one_time_password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Verifikasi & Aktifkan 2FA Sekarang') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
