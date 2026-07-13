<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Mahasiswa</h2>
            <p class="text-sm text-gray-500">Selamat datang, {{ Auth::user()->name }}</p>
        </div>
    </x-slot>

    @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative">
            {{ session('error') }}
        </div>
    @endif
    
    @if(!Auth::user()->student)
        <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded-lg relative flex items-center justify-between">
            <div>
                <strong>Peringatan!</strong> Profil akademik Anda belum lengkap.
            </div>
            <a href="{{ route('student.profile.edit') }}" class="font-bold underline text-yellow-900">Lengkapi Sekarang</a>
        </div>
    @endif

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Pengajuan Saya -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 border-l-4 border-blue-500">
            <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500">Pengajuan Saya</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalPengajuan }}</p>
                <p class="text-xs text-gray-400">Total lamaran terkirim</p>
            </div>
        </div>

        <!-- Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 border-l-4 border-yellow-500">
            <div class="w-12 h-12 rounded-full bg-yellow-50 text-yellow-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500">Status</p>
                @php
                    $statusColor = 'text-gray-800';
                    $statusText = 'Belum Ada';
                    if ($statusSaatIni === 'pending_admin' || $statusSaatIni === 'pending_company') {
                        $statusColor = 'text-yellow-600';
                        $statusText = 'Menunggu Verifikasi';
                    } elseif ($statusSaatIni === 'accepted') {
                        $statusColor = 'text-green-600';
                        $statusText = 'Disetujui (Diterima)';
                    } elseif ($statusSaatIni === 'rejected') {
                        $statusColor = 'text-red-600';
                        $statusText = 'Ditolak';
                    }
                @endphp
                <p class="text-lg font-bold {{ $statusColor }} leading-tight">{{ $statusText }}</p>
                <p class="text-xs text-gray-400 mt-1">Status pengajuan terakhir</p>
            </div>
        </div>

        <!-- Program -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 border-l-4 border-green-500">
            <div class="w-12 h-12 rounded-full bg-green-50 text-green-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500">Program Aktif</p>
                <p class="text-lg font-bold text-gray-800 truncate w-32" title="{{ $program }}">{{ $program }}</p>
                <p class="text-xs text-gray-400 mt-1">Posisi & Tempat Magang</p>
            </div>
        </div>

        <!-- Periode -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 border-l-4 border-purple-500">
            <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500">Periode</p>
                <p class="text-lg font-bold text-gray-800">{{ $periode }}</p>
                <p class="text-xs text-gray-400 mt-1">Estimasi Waktu Magang</p>
            </div>
        </div>
    </div>

    <!-- Middle Row (Logbook & Pengumuman) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Logbook Terbaru -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-800">Logbook Terbaru</h3>
                <a href="{{ route('student.logbooks.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Lihat Semua Logbook</a>
            </div>
            <div class="p-6 flex-1">
                @forelse($recentLogbooks as $logbook)
                    <div class="mb-4 pb-4 border-b border-gray-50 last:mb-0 last:pb-0 last:border-0 flex justify-between items-start">
                        <div>
                            <p class="text-xs text-gray-400 mb-1">{{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}</p>
                            <p class="text-sm font-bold text-gray-800">{{ \Illuminate\Support\Str::limit($logbook->kegiatan, 50) }}</p>
                        </div>
                        <div>
                            @if($logbook->status === 'approved')
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full">Disetujui</span>
                            @elseif($logbook->status === 'rejected')
                                <span class="px-2 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-full">Revisi/Ditolak</span>
                            @else
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-[10px] font-bold rounded-full">Menunggu</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-8">Belum ada catatan logbook.</div>
                @endforelse
            </div>
        </div>

        <!-- Pengumuman Terbaru (Dummy) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-800">Pengumuman Terbaru</h3>
                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Lihat Semua Pengumuman</a>
            </div>
            <div class="p-6 flex-1">
                <div class="mb-4 pb-4 border-b border-gray-50 flex justify-between items-start">
                    <p class="text-sm font-bold text-gray-800">Batas akhir pengumpulan laporan akhir</p>
                    <p class="text-xs text-gray-400 whitespace-nowrap ml-4">24 Mei 2024</p>
                </div>
                <div class="mb-4 pb-4 border-b border-gray-50 flex justify-between items-start">
                    <p class="text-sm font-bold text-gray-800">Pelatihan penyusunan laporan magang</p>
                    <p class="text-xs text-gray-400 whitespace-nowrap ml-4">20 Mei 2024</p>
                </div>
                <div class="flex justify-between items-start">
                    <p class="text-sm font-bold text-gray-800">Info penilaian oleh pembimbing lapangan</p>
                    <p class="text-xs text-gray-400 whitespace-nowrap ml-4">18 Mei 2024</p>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
