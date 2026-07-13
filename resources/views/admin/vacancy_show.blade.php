<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Verifikasi Lowongan: ') }} {{ $vacancy->posisi }}
            </h2>
            <a href="{{ route('admin.vacancies.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center gap-4 mb-4 border-b pb-4">
                        @if($vacancy->company->logo)
                            <img src="{{ Storage::url($vacancy->company->logo) }}" alt="Logo" class="h-16 w-16 object-contain bg-white border rounded p-1">
                        @else
                            <div class="h-16 w-16 bg-gray-200 border rounded flex items-center justify-center text-gray-500 font-bold text-2xl">{{ substr($vacancy->company->nama_resmi, 0, 1) }}</div>
                        @endif
                        <div>
                            <h3 class="text-xl font-bold">Informasi Lowongan</h3>
                            <p class="text-gray-500 font-semibold">{{ $vacancy->company->nama_resmi }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Posisi:</p>
                            <p class="font-semibold mb-3">{{ $vacancy->posisi }}</p>
                            
                            <p class="text-sm text-gray-500">Kuota:</p>
                            <p class="font-semibold mb-3">{{ $vacancy->kuota }} Orang</p>
                            
                            <p class="text-sm text-gray-500">Periode Magang:</p>
                            <p class="font-semibold mb-3">{{ $vacancy->tgl_mulai->format('d M Y') }} s/d {{ $vacancy->tgl_selesai->format('d M Y') }}</p>
                            
                            <p class="text-sm text-gray-500">Dokumen KAK:</p>
                            <p class="mb-3">
                                <a href="{{ Storage::url($vacancy->dokumen_pdf) }}" target="_blank" class="text-blue-600 hover:underline font-bold text-sm">Buka Dokumen PDF</a>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Deskripsi Singkat:</p>
                            <p class="mb-3 text-sm whitespace-pre-line">{{ $vacancy->deskripsi }}</p>
                            
                            <p class="text-sm text-gray-500">Kualifikasi Khusus:</p>
                            <p class="mb-3 text-sm whitespace-pre-line">{{ $vacancy->kualifikasi }}</p>
                            
                            <p class="text-sm text-gray-500">Kriteria Keahlian Wajib:</p>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($vacancy->skills as $skill)
                                    <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Aksi Verifikasi -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Aksi Verifikasi</h3>
                    <div class="flex flex-col md:flex-row items-center gap-4">
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Status Saat Ini: 
                                @if($vacancy->status === 'pending')
                                    <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded text-xs font-bold">Menunggu Verifikasi</span>
                                @elseif($vacancy->status === 'approved')
                                    <span class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs font-bold">Disetujui (Tayang)</span>
                                @else
                                    <span class="px-2 py-1 bg-red-200 text-red-800 rounded text-xs font-bold">Ditolak</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="flex gap-2">
                            @if($vacancy->status !== 'approved')
                                <form method="POST" action="{{ route('admin.vacancies.approve', $vacancy) }}">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white text-sm font-bold py-2 px-4 rounded shadow">
                                        {{ $vacancy->status === 'pending' ? 'Terima Lowongan' : 'Buka Kembali Lowongan' }}
                                    </button>
                                </form>
                            @endif
                            
                            @if($vacancy->status !== 'rejected')
                                <form method="POST" action="{{ route('admin.vacancies.approve', $vacancy) }}">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded shadow" onclick="return confirm('Apakah Anda yakin ingin menolak/menghentikan lowongan ini? Mahasiswa tidak akan bisa mendaftar.');">
                                        {{ $vacancy->status === 'pending' ? 'Tolak Lowongan' : 'Hentikan Sementara' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
