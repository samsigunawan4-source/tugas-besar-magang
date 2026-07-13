<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulir Pendaftaran Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold text-blue-800 mb-2">{{ $vacancy->posisi }}</h3>
                <p class="text-lg font-semibold text-gray-600 mb-6">{{ $vacancy->company->nama_resmi }}</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h4 class="font-bold text-gray-900 border-b pb-2 mb-2">Deskripsi Pekerjaan</h4>
                        <p class="text-gray-700 whitespace-pre-line">{{ $vacancy->deskripsi }}</p>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 border-b pb-2 mb-2">Kualifikasi Khusus</h4>
                        <p class="text-gray-700 whitespace-pre-line">{{ $vacancy->kualifikasi }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-8 border border-gray-200 text-sm">
                    <p><strong>Kuota:</strong> {{ $vacancy->kuota }} orang</p>
                    <p><strong>Periode Pelaksanaan:</strong> {{ $vacancy->tgl_mulai->format('d M Y') }} s/d {{ $vacancy->tgl_selesai->format('d M Y') }}</p>
                    <p><strong>Pendaftaran Ditutup:</strong> {{ $vacancy->batas_daftar->format('d M Y') }}</p>
                    <p class="mt-2"><a href="{{ Storage::url($vacancy->dokumen_pdf) }}" target="_blank" class="text-blue-600 hover:underline">📥 Unduh KAK / Penawaran Resmi Perusahaan (PDF)</a></p>
                </div>

                <div class="border-t pt-8 mt-4">
                    <h4 class="font-bold text-xl mb-4">Kirim Lamaran Sekarang</h4>
                    <p class="text-gray-600 mb-4 text-sm">Menurut persyaratan tugas akhir, mahasiswa diwajibkan melampirkan transkrip/KHS dalam format PDF saat melamar.</p>
                    
                    <form action="{{ route('student.applications.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="vacancy_id" value="{{ $vacancy->id }}">
                        
                        <div class="mb-6">
                            <x-input-label for="dokumen_khs" :value="__('Upload Dokumen KHS / Transkrip (PDF atau Foto)')" class="font-bold text-red-600" />
                            <x-text-input id="dokumen_khs" name="dokumen_khs" type="file" accept=".pdf, .jpg, .jpeg, .png" class="mt-1 block w-full border" required />
                            <x-input-error class="mt-2" :messages="$errors->get('dokumen_khs')" />
                            <p class="text-xs text-gray-500 mt-1">Maksimal 5MB (Format: PDF, JPG, PNG).</p>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="pembayaran_pdf" :value="__('Upload Bukti Pembayaran Semester (PDF atau Foto)')" class="font-bold text-red-600" />
                            <x-text-input id="pembayaran_pdf" name="pembayaran_pdf" type="file" accept=".pdf, .jpg, .jpeg, .png" class="mt-1 block w-full border" required />
                            <x-input-error class="mt-2" :messages="$errors->get('pembayaran_pdf')" />
                            <p class="text-xs text-gray-500 mt-1">Admin akan memverifikasi dokumen ini sebelum lamaran diteruskan ke Perusahaan.</p>
                        </div>
                        
                        <div class="flex gap-4 items-center">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow" onclick="return confirm('Apakah Anda yakin dokumen sudah benar? Lamaran tidak dapat ditarik kembali.')">
                                Kirim Lamaran
                            </button>
                            <a href="{{ route('student.applications.index') }}" class="text-gray-500 hover:underline">Batal / Kembali</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
