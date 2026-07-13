<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bursa Magang & Status Lamaran') }}
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

            <!-- Riwayat Lamaran -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Riwayat Lamaran Anda</h3>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2 px-4">Perusahaan</th>
                                <th class="border-b py-2 px-4">Posisi</th>
                                <th class="border-b py-2 px-4">Dokumen KHS</th>
                                <th class="border-b py-2 px-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $app)
                                <tr class="hover:bg-gray-50">
                                    <td class="border-b py-2 px-4">{{ $app->vacancy->company->nama_resmi }}</td>
                                    <td class="border-b py-2 px-4">{{ $app->vacancy->posisi }}</td>
                                    <td class="border-b py-2 px-4">
                                        <a href="{{ Storage::url($app->khs_pdf) }}" target="_blank" class="text-blue-600 hover:underline text-xs">Lihat KHS</a>
                                    </td>
                                    <td class="border-b py-4 px-4 align-top">
                                        @if($app->status === 'pending_company' || $app->status === 'pending_admin')
                                            <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded text-xs font-bold block w-max mb-1">Menunggu Seleksi</span>
                                        @elseif($app->status === 'accepted')
                                            <span class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs font-bold block w-max mb-2">Diterima / Sedang Magang</span>
                                        @elseif($app->status === 'completed')
                                            <span class="px-2 py-1 bg-indigo-200 text-indigo-800 rounded text-xs font-bold block w-max mb-2">Lulus Magang</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-200 text-red-800 rounded text-xs font-bold block w-max">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-4 px-4 text-center text-gray-500">Anda belum pernah mengirim lamaran magang.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Daftar Lowongan Tersedia -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Bursa Lowongan (Telah Disetujui Admin)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($availableVacancies as $vacancy)
                            <div class="border rounded-lg p-4 shadow-sm hover:shadow-md transition">
                                <div class="flex items-center gap-3 mb-2">
                                    @if($vacancy->company->logo)
                                        <img src="{{ Storage::url($vacancy->company->logo) }}" alt="Logo" class="h-10 w-10 object-contain bg-white border rounded p-1">
                                    @else
                                        <div class="h-10 w-10 bg-gray-200 border rounded flex items-center justify-center text-gray-500 font-bold text-lg">{{ substr($vacancy->company->nama_resmi, 0, 1) }}</div>
                                    @endif
                                    <div>
                                        <h4 class="font-bold text-xl text-blue-700 leading-tight">{{ $vacancy->posisi }}</h4>
                                        <p class="text-sm font-semibold text-gray-600">{{ $vacancy->company->nama_resmi }}</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-800 line-clamp-3 mb-4 mt-2">{{ Str::limit($vacancy->deskripsi, 100) }}</p>
                                
                                <div class="text-sm text-gray-500 mb-4 space-y-1">
                                    <p>📅 Periode: {{ $vacancy->tgl_mulai->format('d M') }} - {{ $vacancy->tgl_selesai->format('d M Y') }}</p>
                                    <p>⏰ Batas Daftar: <span class="font-bold text-red-500">{{ $vacancy->batas_daftar->format('d M Y') }}</span></p>
                                    <p>👥 Kuota: {{ $vacancy->kuota }} orang</p>
                                    
                                    <div class="mt-2">
                                        <p class="font-bold text-indigo-600 mb-1">Cocok dengan Skill Anda:</p>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($vacancy->skills as $skill)
                                                <span class="bg-indigo-100 text-indigo-800 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $skill->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="{{ route('student.applications.create', ['vacancy_id' => $vacancy->id]) }}" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                                    Lihat Detail & Lamar
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-500">Saat ini belum ada lowongan magang yang terbuka.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
