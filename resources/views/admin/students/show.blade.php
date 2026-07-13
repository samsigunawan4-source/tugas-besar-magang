<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Laporan Mahasiswa') }}
            </h2>
            <a href="{{ route('admin.students.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md transition-colors text-sm">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Profil Singkat -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col md:flex-row items-center gap-6">
                    @if(isset($user->student) && $user->student->foto_profil)
                        <img src="{{ asset('storage/' . $user->student->foto_profil) }}" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover border-4 border-slate-50 shadow-sm">
                    @else
                        <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-3xl font-bold text-slate-400 border-4 border-slate-50 shadow-sm">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h3>
                        <p class="text-gray-500 mb-2">{{ $user->email }}</p>
                        
                        @if($user->student)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600 mb-4 bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div>
                                    <span class="block text-xs text-gray-400 uppercase tracking-wider font-semibold">NIM</span>
                                    <span class="font-bold text-gray-800">{{ $user->student->nim ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-400 uppercase tracking-wider font-semibold">Program Studi</span>
                                    <span class="font-bold text-gray-800">{{ $user->student->prodi ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-400 uppercase tracking-wider font-semibold">Nomor WhatsApp</span>
                                    <span class="font-bold text-gray-800">{{ $user->student->no_wa ?? '-' }}</span>
                                </div>
                                <div class="flex gap-8">
                                    <div>
                                        <span class="block text-xs text-gray-400 uppercase tracking-wider font-semibold">Semester</span>
                                        <span class="font-bold text-gray-800">{{ $user->student->semester ?? '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-xs text-gray-400 uppercase tracking-wider font-semibold">Total SKS</span>
                                        <span class="font-bold text-gray-800">{{ $user->student->jumlah_sks ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <span class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-2">Keahlian (Skills)</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($user->student->skills as $skill)
                                        <span class="px-2.5 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full border border-blue-200 shadow-sm">{{ $skill->name }}</span>
                                    @empty
                                        <span class="text-xs text-gray-400 italic">Belum mengisi keahlian.</span>
                                    @endforelse
                                </div>
                            </div>
                        @else
                            <p class="text-red-500 text-sm font-semibold italic">Mahasiswa belum melengkapi biodata akademik.</p>
                        @endif
                    </div>
                </div>
            </div>

            @if($user->student)
                @php
                    $acceptedApp = $user->student->applications->whereIn('status', ['accepted', 'completed'])->first();
                @endphp

                <!-- Status Penempatan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Penempatan Magang</h3>
                        
                        @if($acceptedApp)
                            <div class="bg-blue-50 border border-blue-100 rounded-lg p-5">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-xl font-bold text-blue-900 mb-1">{{ $acceptedApp->vacancy->company->nama_resmi }}</h4>
                                        <p class="text-blue-700 font-medium mb-3">Posisi: {{ $acceptedApp->vacancy->posisi }}</p>
                                        
                                        <div class="text-sm text-blue-800 space-y-1">
                                            <p><span class="opacity-75">Sektor Industri:</span> {{ $acceptedApp->vacancy->company->sektor_industri }}</p>
                                            <p><span class="opacity-75">Periode Magang:</span> {{ $acceptedApp->vacancy->tgl_mulai->format('d M Y') }} s/d {{ $acceptedApp->vacancy->tgl_selesai->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        @if($acceptedApp->status === 'completed')
                                            <span class="px-3 py-1 bg-blue-200 text-blue-800 text-sm font-bold rounded shadow-sm block text-center mb-2">Selesai Magang</span>
                                            
                                            <div class="bg-white p-3 rounded border text-xs">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="font-bold text-gray-700">Nilai:</span>
                                                    <span class="text-base font-black text-indigo-600">{{ $acceptedApp->nilai }}</span>
                                                </div>
                                                @if($acceptedApp->laporan_akhir)
                                                    <a href="{{ Storage::url($acceptedApp->laporan_akhir) }}" target="_blank" class="block text-center text-blue-600 hover:bg-blue-50 bg-white border border-blue-200 py-1 px-2 rounded mb-1 font-semibold">Lihat Laporan Akhir</a>
                                                @endif
                                                @if($acceptedApp->sertifikat)
                                                    <a href="{{ Storage::url($acceptedApp->sertifikat) }}" target="_blank" class="block text-center text-indigo-600 hover:bg-indigo-50 bg-white border border-indigo-200 py-1 px-2 rounded font-semibold">Lihat Sertifikat</a>
                                                @endif
                                            </div>
                                        @else
                                            <span class="px-3 py-1 bg-green-200 text-green-800 text-sm font-bold rounded shadow-sm block text-center mb-2">Sedang Magang Aktif</span>
                                            
                                            @if($acceptedApp->laporan_akhir)
                                                <div class="bg-white p-2 rounded border text-xs text-center">
                                                    <span class="text-green-600 font-bold block mb-1">Laporan Dikumpulkan</span>
                                                    <a href="{{ Storage::url($acceptedApp->laporan_akhir) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-3 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                </div>
                                <p class="text-gray-500 font-medium">Mahasiswa ini belum ditempatkan atau belum diterima magang di manapun.</p>
                                @php
                                    $pendingApps = $user->student->applications->whereIn('status', ['pending_admin', 'pending_company'])->count();
                                @endphp
                                @if($pendingApps > 0)
                                    <p class="text-sm text-yellow-600 mt-2">Status saat ini: Memiliki {{ $pendingApps }} lamaran yang menunggu seleksi.</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Riwayat Logbook -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-lg font-bold text-gray-800">Laporan Logbook (Kegiatan Harian)</h3>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Read-Only</span>
                        </div>
                        
                        @if($user->student->logbooks->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="py-2 px-4 font-semibold text-gray-600 text-sm">Tanggal</th>
                                            <th class="py-2 px-4 font-semibold text-gray-600 text-sm">Kegiatan</th>
                                            <th class="py-2 px-4 font-semibold text-gray-600 text-sm">Dokumentasi</th>
                                            <th class="py-2 px-4 font-semibold text-gray-600 text-sm text-center">Status Laporan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($user->student->logbooks->sortByDesc('tanggal') as $logbook)
                                            <tr class="hover:bg-gray-50">
                                                <td class="py-3 px-4 text-sm whitespace-nowrap">{{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}</td>
                                                <td class="py-3 px-4">
                                                    <p class="text-sm text-gray-800 line-clamp-2" title="{{ $logbook->kegiatan }}">{{ $logbook->kegiatan }}</p>
                                                    @if($logbook->feedback)
                                                        <div class="mt-2 bg-yellow-50 border border-yellow-200 rounded p-2 text-xs">
                                                            <strong class="text-yellow-700">Feedback Pembimbing:</strong>
                                                            <p class="text-yellow-800 italic mt-0.5">{{ $logbook->feedback }}</p>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-4">
                                                    @if($logbook->foto_bukti)
                                                        <a href="{{ Storage::url($logbook->foto_bukti) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-blue-600 hover:text-blue-800 font-semibold bg-blue-50 px-2 py-1 rounded">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                                            Lihat Bukti
                                                        </a>
                                                    @else
                                                        <span class="text-xs text-gray-400 italic">Tidak ada lampiran</span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-4 text-center">
                                                    @if($logbook->status === 'approved')
                                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-[10px] font-bold rounded uppercase tracking-wide">Disetujui</span>
                                                    @elseif($logbook->status === 'rejected')
                                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-[10px] font-bold rounded uppercase tracking-wide">Ditolak / Revisi</span>
                                                    @else
                                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-[10px] font-bold rounded uppercase tracking-wide">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-500 text-sm">
                                Mahasiswa ini belum pernah mengisi laporan logbook apa pun.
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
