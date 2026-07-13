<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tugas Akhir Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Pengumpulan Laporan Akhir</h3>
                    <p class="text-sm text-gray-500 mb-6">Unggah laporan akhir magang Anda di sini setelah seluruh kegiatan magang selesai. Laporan ini akan dinilai oleh perusahaan untuk menerbitkan sertifikat.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($applications as $app)
                            <div class="border rounded-lg p-5 shadow-sm">
                                <h4 class="font-bold text-xl text-blue-800">{{ $app->vacancy->posisi }}</h4>
                                <p class="text-sm font-semibold text-gray-600 mb-4">{{ $app->vacancy->company->nama_resmi }}</p>
                                
                                @if($app->status === 'accepted')
                                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                        <p class="text-sm font-bold text-blue-800 mb-3">Laporan Akhir Magang</p>
                                        @if($app->laporan_akhir)
                                            <div class="flex items-center justify-between bg-white p-3 rounded border">
                                                <a href="{{ Storage::url($app->laporan_akhir) }}" target="_blank" class="text-blue-600 text-sm hover:underline flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                                    Lihat Dokumen Laporan
                                                </a>
                                                <span class="text-xs text-green-700 font-bold bg-green-100 px-2 py-1 rounded">Terkirim</span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-2 italic">Menunggu penilaian akhir dan sertifikat dari perusahaan.</p>
                                        @else
                                            <form action="{{ route('student.applications.upload-report', $app->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3">
                                                @csrf
                                                <div>
                                                    <label class="block text-xs font-bold text-gray-700 mb-1">File Laporan (PDF, Max 10MB)</label>
                                                    <input type="file" name="laporan_akhir" accept="application/pdf" class="text-sm w-full text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer bg-white border rounded" required>
                                                </div>
                                                @error('laporan_akhir')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded w-full mt-2">
                                                    Unggah Laporan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @elseif($app->status === 'completed')
                                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="text-sm font-bold text-green-800">Status:</span>
                                            <span class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs font-bold">Lulus Magang</span>
                                        </div>
                                        <div class="flex items-center gap-2 mb-3">
                                            <span class="text-sm font-bold text-gray-700">Nilai Akhir:</span>
                                            <span class="text-xl font-black text-indigo-700">{{ $app->nilai ?? '-' }}</span>
                                        </div>
                                        @if($app->sertifikat)
                                            <a href="{{ Storage::url($app->sertifikat) }}" target="_blank" class="text-sm font-bold bg-yellow-400 hover:bg-yellow-500 text-yellow-900 px-4 py-2 rounded flex items-center justify-center gap-2 w-full text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd" /></svg>
                                                Unduh Sertifikat Magang
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="col-span-1 md:col-span-2 text-center py-8">
                                <p class="text-gray-500">Anda belum memiliki magang yang disetujui atau diselesaikan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
