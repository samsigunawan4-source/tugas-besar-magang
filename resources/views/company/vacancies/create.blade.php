<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buka Lowongan Magang Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Detail Lowongan & Dokumen Legalitas') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Lowongan yang Anda buat akan diperiksa terlebih dahulu oleh Admin (Kampus) sebelum dapat tayang dan dilihat oleh mahasiswa. Pastikan dokumen yang diunggah valid dan resmi.") }}
                        </p>
                    </header>

                    <form method="post" action="{{ route('company.vacancies.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="posisi" :value="__('Posisi Magang')" />
                            <x-text-input id="posisi" name="posisi" type="text" class="mt-1 block w-full" :value="old('posisi')" required autofocus placeholder="Contoh: Web Developer Intern" />
                            <x-input-error class="mt-2" :messages="$errors->get('posisi')" />
                        </div>

                        <div>
                            <x-input-label for="deskripsi" :value="__('Deskripsi Pekerjaan (Jobdesk)')" />
                            <textarea id="deskripsi" name="deskripsi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required rows="4">{{ old('deskripsi') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                        </div>

                        <div>
                            <x-input-label for="kualifikasi" :value="__('Kualifikasi Khusus')" />
                            <textarea id="kualifikasi" name="kualifikasi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required rows="3">{{ old('kualifikasi') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('kualifikasi')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="kuota" :value="__('Kuota Penerimaan (Orang)')" />
                                <x-text-input id="kuota" name="kuota" type="number" min="1" class="mt-1 block w-full" :value="old('kuota')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('kuota')" />
                            </div>
                            <div>
                                <x-input-label for="batas_daftar" :value="__('Batas Waktu Pendaftaran')" />
                                <x-text-input id="batas_daftar" name="batas_daftar" type="date" class="mt-1 block w-full" :value="old('batas_daftar')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('batas_daftar')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="tgl_mulai" :value="__('Tanggal Mulai Magang')" />
                                <x-text-input id="tgl_mulai" name="tgl_mulai" type="date" class="mt-1 block w-full" :value="old('tgl_mulai')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('tgl_mulai')" />
                            </div>
                            <div>
                                <x-input-label for="tgl_selesai" :value="__('Tanggal Selesai Magang')" />
                                <x-text-input id="tgl_selesai" name="tgl_selesai" type="date" class="mt-1 block w-full" :value="old('tgl_selesai')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('tgl_selesai')" />
                            </div>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="dokumen_pdf" :value="__('Upload KAK / Surat Penawaran Resmi (Wajib PDF)')" class="font-bold text-red-600" />
                            <x-text-input id="dokumen_pdf" name="dokumen_pdf" type="file" accept=".pdf" class="mt-1 block w-full border" required />
                            <x-input-error class="mt-2" :messages="$errors->get('dokumen_pdf')" />
                            <p class="text-xs text-gray-500 mt-1">Maksimal 5MB. Dokumen ini akan divalidasi oleh Admin Kampus.</p>
                        </div>

                        <div class="mb-6 border-t pt-6">
                            <h3 class="text-md font-bold mb-2">Syarat Keahlian (Skills)</h3>
                            <p class="text-sm text-gray-600 mb-4">Pilih minimal 1 keahlian yang dibutuhkan untuk posisi ini. (Sistem hanya akan memunculkan lowongan ini pada mahasiswa yang memiliki skill tersebut).</p>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($skills as $skill)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="skills[]" value="{{ $skill->id }}" 
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            {{ in_array($skill->id, old('skills', [])) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">{{ $skill->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow">
                                Submit Lowongan
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
