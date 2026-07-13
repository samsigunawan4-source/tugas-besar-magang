<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Laporan Perusahaan') }}
            </h2>
            <a href="{{ route('admin.companies.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md transition-colors text-sm">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Profil Singkat Perusahaan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                <div class="p-6 text-gray-900 flex flex-col md:flex-row items-center gap-6">
                    <div class="w-24 h-24 rounded-2xl bg-indigo-50 flex items-center justify-center text-4xl font-bold text-indigo-300 border-2 border-indigo-100 shadow-sm overflow-hidden">
                        @if($user->company && $user->company->logo)
                            <img src="{{ Storage::url($user->company->logo) }}" alt="Logo" class="w-full h-full object-contain bg-white">
                        @elseif($user->company && $user->company->nama_resmi)
                            {{ strtoupper(substr($user->company->nama_resmi, 0, 1)) }}
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="flex-1">
                        @if($user->company)
                            <h3 class="text-3xl font-bold text-indigo-900">{{ $user->company->nama_resmi }}</h3>
                            <p class="text-indigo-600 font-semibold mb-3">Sektor: {{ $user->company->sektor }}</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <div>
                                        <p class="font-bold text-gray-700">Alamat Lengkap</p>
                                        <p>{{ $user->company->alamat }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    <div>
                                        <p class="font-bold text-gray-700">Akun Perwakilan (PIC)</p>
                                        <p>{{ $user->name }} &middot; {{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            @if($user->company->deskripsi)
                            <div class="mt-4 pt-4 border-t border-gray-100 text-sm text-gray-600">
                                <p class="font-bold text-gray-700 mb-1">Deskripsi Singkat</p>
                                <p class="whitespace-pre-line">{{ $user->company->deskripsi }}</p>
                            </div>
                            @endif
                        @else
                            <h3 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h3>
                            <p class="text-gray-500 mb-2">{{ $user->email }}</p>
                            <p class="text-red-500 text-sm font-semibold italic mt-2">Perusahaan ini belum melengkapi biodata profil mereka.</p>
                        @endif
                    </div>
                </div>
            </div>

            @if($user->company)
                @php
                    $totalVacancies = $user->company->vacancies->count();
                    $activeVacancies = $user->company->vacancies->where('status', 'approved')->count();
                    
                    $totalInterns = 0;
                    $totalApplicants = 0;
                    
                    foreach($user->company->vacancies as $vacancy) {
                        $totalApplicants += $vacancy->applications->count();
                        $totalInterns += $vacancy->applications->whereIn('status', ['accepted', 'completed'])->count();
                    }
                @endphp

                <!-- Statistik Kinerja Mitra -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 flex items-center gap-4">
                        <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Lowongan</p>
                            <p class="text-2xl font-black text-gray-800">{{ $totalVacancies }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 flex items-center gap-4">
                        <div class="bg-green-100 text-green-600 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Lowongan Aktif</p>
                            <p class="text-2xl font-black text-gray-800">{{ $activeVacancies }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 flex items-center gap-4">
                        <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Pelamar</p>
                            <p class="text-2xl font-black text-gray-800">{{ $totalApplicants }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 flex items-center gap-4 border-b-4 border-indigo-500">
                        <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-indigo-500 font-bold uppercase tracking-wider">Mhs Sedang/Telah Magang</p>
                            <p class="text-2xl font-black text-indigo-900">{{ $totalInterns }}</p>
                        </div>
                    </div>
                </div>

                <!-- Daftar Lowongan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-lg font-bold text-gray-800">Daftar Lowongan & Rekrutmen</h3>
                        </div>
                        
                        @if($user->company->vacancies->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="py-3 px-4 font-semibold text-gray-600">Posisi & Deskripsi Singkat</th>
                                            <th class="py-3 px-4 font-semibold text-gray-600">Periode Magang</th>
                                            <th class="py-3 px-4 font-semibold text-gray-600 text-center">Status</th>
                                            <th class="py-3 px-4 font-semibold text-gray-600 text-center">Tingkat Keterisian</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($user->company->vacancies->sortByDesc('created_at') as $vacancy)
                                            <tr class="hover:bg-gray-50">
                                                <td class="py-4 px-4">
                                                    <div class="font-bold text-gray-900 text-lg">{{ $vacancy->posisi }}</div>
                                                    <div class="text-xs text-gray-500 line-clamp-2 mt-1 w-64">{{ $vacancy->deskripsi }}</div>
                                                </td>
                                                <td class="py-4 px-4 text-sm text-gray-700">
                                                    <div>{{ \Carbon\Carbon::parse($vacancy->tgl_mulai)->format('d M Y') }}</div>
                                                    <div class="text-gray-400 text-xs">sampai dengan</div>
                                                    <div>{{ \Carbon\Carbon::parse($vacancy->tgl_selesai)->format('d M Y') }}</div>
                                                </td>
                                                <td class="py-4 px-4 text-center">
                                                    @if($vacancy->status === 'approved')
                                                        <span class="px-2.5 py-1 bg-green-100 text-green-800 text-[10px] font-bold rounded uppercase tracking-wide">Aktif (Disetujui)</span>
                                                    @elseif($vacancy->status === 'rejected')
                                                        <span class="px-2.5 py-1 bg-red-100 text-red-800 text-[10px] font-bold rounded uppercase tracking-wide">Ditolak Admin</span>
                                                    @else
                                                        <span class="px-2.5 py-1 bg-yellow-100 text-yellow-800 text-[10px] font-bold rounded uppercase tracking-wide">Menunggu Persetujuan</span>
                                                    @endif
                                                </td>
                                                <td class="py-4 px-4">
                                                    @php
                                                        $acceptedCount = $vacancy->applications->whereIn('status', ['accepted', 'completed'])->count();
                                                        $pendingCount = $vacancy->applications->whereIn('status', ['pending_admin', 'pending_company'])->count();
                                                        
                                                        // Calculate percentage for progress bar
                                                        $percentage = $vacancy->kuota > 0 ? min(100, ($acceptedCount / $vacancy->kuota) * 100) : 0;
                                                        $barColor = $percentage >= 100 ? 'bg-red-500' : ($percentage >= 50 ? 'bg-yellow-400' : 'bg-green-500');
                                                    @endphp
                                                    
                                                    <div class="flex justify-between text-xs mb-1">
                                                        <span class="font-bold text-gray-700">{{ $acceptedCount }} <span class="font-normal text-gray-500">dari</span> {{ $vacancy->kuota }} Kuota Terisi</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                                        <div class="{{ $barColor }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                                    </div>
                                                    @if($pendingCount > 0)
                                                        <p class="text-[10px] text-yellow-600 font-semibold">{{ $pendingCount }} pelamar menunggu diseleksi.</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500 text-sm bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                Perusahaan ini belum pernah membuka lowongan magang.
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
