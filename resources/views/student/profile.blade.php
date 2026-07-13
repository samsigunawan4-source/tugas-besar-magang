<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Akademik Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Informasi Akademik') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Lengkapi profil akademik Anda untuk mulai melamar magang.") }}
                        </p>
                    </header>

                    <form method="post" action="{{ route('student.profile.update') }}" enctype="multipart/form-data" class="mt-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            
                            <!-- Kolom 1: Data Pribadi -->
                            <div class="space-y-6">
                                <h3 class="text-md font-bold text-gray-800 border-b pb-2">Data Diri & Kontak</h3>
                                
                                <div>
                                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-gray-50 focus:bg-white transition-colors" :value="old('name', Auth::user()->name)" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>

                                <div>
                                    <x-input-label for="no_wa" :value="__('Nomor WhatsApp')" />
                                    <x-text-input id="no_wa" name="no_wa" type="text" class="mt-1 block w-full bg-gray-50 focus:bg-white transition-colors" :value="old('no_wa', $student->no_wa ?? '')" required placeholder="Contoh: 08123456789" />
                                    <x-input-error class="mt-2" :messages="$errors->get('no_wa')" />
                                </div>

                                <div>
                                    <x-input-label for="foto_profil" :value="__('Foto Profil Resmi')" />
                                    
                                    @if(isset($student->foto_profil) && $student->foto_profil)
                                        <div class="mt-2 mb-4 flex items-center gap-4">
                                            <img src="{{ asset('storage/' . $student->foto_profil) }}" alt="Foto Profil" class="w-16 h-16 object-cover rounded-full border border-gray-200 shadow-sm">
                                            <span class="text-sm text-gray-500">Foto saat ini terpasang.</span>
                                        </div>
                                    @endif

                                    <div x-data="{ fileName: '' }" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors bg-gray-50">
                                        <div class="space-y-1 text-center">
                                            <svg x-show="!fileName" class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div x-show="fileName" class="mx-auto h-12 w-12 text-blue-500 flex items-center justify-center" style="display: none;">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            </div>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <label for="foto_profil" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 px-1">
                                                    <span x-text="fileName ? 'Ganti foto' : 'Pilih foto'">Pilih foto</span>
                                                    <input id="foto_profil" name="foto_profil" type="file" class="sr-only" x-on:change="fileName = $event.target.files[0].name" />
                                                </label>
                                            </div>
                                            <p x-text="fileName ? fileName : 'PNG, JPG, GIF max 2MB'" class="text-xs text-gray-500 font-semibold truncate max-w-xs mx-auto">PNG, JPG, GIF max 2MB</p>
                                        </div>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('foto_profil')" />
                                </div>
                            </div>

                            <!-- Kolom 2: Data Akademik -->
                            <div class="space-y-6">
                                <h3 class="text-md font-bold text-gray-800 border-b pb-2">Informasi Kampus</h3>

                                <div>
                                    <x-input-label for="nim" :value="__('Nomor Induk Mahasiswa (NIM)')" />
                                    <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full bg-gray-50 focus:bg-white transition-colors" :value="old('nim', $student->nim ?? '')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('nim')" />
                                </div>

                                <div>
                                    <x-input-label for="prodi" :value="__('Program Studi')" />
                                    <x-text-input id="prodi" name="prodi" type="text" class="mt-1 block w-full bg-gray-50 focus:bg-white transition-colors" :value="old('prodi', $student->prodi ?? '')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('prodi')" />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="semester" :value="__('Semester')" />
                                        <x-text-input id="semester" name="semester" type="number" class="mt-1 block w-full bg-gray-50 focus:bg-white transition-colors text-center" :value="old('semester', $student->semester ?? '')" required min="1" max="14" />
                                        <x-input-error class="mt-2" :messages="$errors->get('semester')" />
                                    </div>
                                    <div>
                                        <x-input-label for="jumlah_sks" :value="__('SKS Tempuh')" />
                                        <x-text-input id="jumlah_sks" name="jumlah_sks" type="number" class="mt-1 block w-full bg-gray-50 focus:bg-white transition-colors text-center" :value="old('jumlah_sks', $student->jumlah_sks ?? '')" required min="0" max="160" />
                                        <x-input-error class="mt-2" :messages="$errors->get('jumlah_sks')" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Keahlian (Skills) Full Width -->
                        <div class="mt-10 pt-6 border-t border-gray-200">
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-gray-900">Keahlian (Skills)</h3>
                                <p class="text-sm text-gray-500">Pilih minimal 3 keahlian yang Anda miliki. Keahlian ini akan dicocokkan dengan kebutuhan lowongan magang dari perusahaan.</p>
                            </div>
                            
                            <div class="flex flex-wrap gap-3 mt-4">
                                @php
                                    $studentSkillIds = isset($student) ? $student->skills->pluck('id')->toArray() : [];
                                @endphp
                                @foreach($skills as $skill)
                                    <div class="relative">
                                        <input type="checkbox" id="skill_{{ $skill->id }}" name="skills[]" value="{{ $skill->id }}" class="peer hidden" {{ in_array($skill->id, old('skills', $studentSkillIds)) ? 'checked' : '' }}>
                                        <label for="skill_{{ $skill->id }}" class="inline-flex items-center justify-center px-4 py-2 border-2 border-gray-200 rounded-full cursor-pointer bg-white text-gray-600 hover:bg-gray-50 peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 transition-all font-medium text-sm shadow-sm select-none">
                                            {{ $skill->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <x-input-error class="mt-3" :messages="$errors->get('skills')" />
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex items-center justify-end gap-4 border-t pt-6">
                            @if (session('status') === 'profil-akademik-updated')
                                <p class="text-sm text-green-600 font-semibold bg-green-50 px-3 py-1 rounded-md">{{ __('Data berhasil disimpan!') }}</p>
                            @endif
                            <x-primary-button class="px-8 py-3 text-base shadow-lg hover:shadow-xl transition-shadow bg-blue-600 hover:bg-blue-700">{{ __('Simpan Profil Akademik') }}</x-primary-button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
