<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Identitas Perusahaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Informasi Perusahaan') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Lengkapi profil perusahaan Anda agar terlihat meyakinkan bagi calon pelamar.") }}
                        </p>
                    </header>

                    <form method="post" action="{{ route('company.profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="nama_resmi" :value="__('Nama Resmi Perusahaan')" />
                            <x-text-input id="nama_resmi" name="nama_resmi" type="text" class="mt-1 block w-full" :value="old('nama_resmi', $company->nama_resmi ?? '')" required autofocus />
                            <x-input-error :messages="$errors->get('nama_resmi')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="sektor" :value="__('Sektor Industri')" />
                            <x-text-input id="sektor" name="sektor" type="text" class="mt-1 block w-full" :value="old('sektor', $company->sektor ?? '')" required />
                            <x-input-error :messages="$errors->get('sektor')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="alamat" :value="__('Alamat Lengkap')" />
                            <textarea id="alamat" name="alamat" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('alamat', $company->alamat ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kontak" :value="__('Nomor Kontak / WhatsApp')" />
                            <x-text-input id="kontak" name="kontak" type="text" class="mt-1 block w-full" :value="old('kontak', $company->kontak ?? '')" required />
                            <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="deskripsi" :value="__('Deskripsi Singkat')" />
                            <textarea id="deskripsi" name="deskripsi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi', $company->deskripsi ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="logo" :value="__('Upload Logo Perusahaan')" />
                            @if(isset($company) && $company->logo)
                                <div class="mb-3 mt-2">
                                    <img src="{{ Storage::url($company->logo) }}" alt="Logo Perusahaan" class="h-20 w-20 object-contain border bg-gray-50 rounded p-1">
                                </div>
                            @endif
                            <x-text-input id="logo" name="logo" type="file" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Profil') }}</x-primary-button>
                            @if (session('status') === 'profil-perusahaan-updated')
                                <p class="text-sm text-gray-600">{{ __('Tersimpan.') }}</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
