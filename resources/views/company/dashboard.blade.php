<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Perusahaan</h2>
            <p class="text-sm text-gray-500">Ringkasan aktivitas rekrutmen magang</p>
        </div>
    </x-slot>

    @if(!auth()->user()->company)
        <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded-lg relative flex flex-col md:flex-row items-center justify-between">
            <div class="mb-2 md:mb-0">
                <strong>Peringatan!</strong> Profil perusahaan Anda belum lengkap. Anda harus melengkapinya sebelum bisa membuka lowongan magang.
            </div>
            <a href="{{ route('company.profile.edit') }}" class="font-bold underline text-yellow-900 bg-yellow-200 px-3 py-1 rounded">Lengkapi Profil &rarr;</a>
        </div>
    @endif

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Lowongan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 border-l-4 border-blue-500">
            <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500">Total Lowongan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalLowongan }}</p>
                <p class="text-xs text-gray-400">Lowongan dibuat</p>
            </div>
        </div>

        <!-- Lowongan Aktif -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 border-l-4 border-green-500">
            <div class="w-12 h-12 rounded-full bg-green-50 text-green-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500">Lowongan Aktif</p>
                <p class="text-2xl font-bold text-gray-800">{{ $lowonganAktif }}</p>
                <p class="text-xs text-gray-400">Disetujui Admin</p>
            </div>
        </div>

        <!-- Total Pelamar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 border-l-4 border-yellow-500">
            <div class="w-12 h-12 rounded-full bg-yellow-50 text-yellow-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500">Total Pelamar</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalPelamar }}</p>
                <p class="text-xs text-gray-400">Mahasiswa melamar</p>
            </div>
        </div>

        <!-- Pelamar Diterima -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 border-l-4 border-purple-500">
            <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500">Pelamar Diterima</p>
                <p class="text-2xl font-bold text-gray-800">{{ $pelamarDiterima }}</p>
                <p class="text-xs text-gray-400">Oleh sistem/Admin</p>
            </div>
        </div>
    </div>

    <!-- Table Row -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Pelamar Masuk (Semua Lowongan)</h3>
            <a href="{{ route('company.applications.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Kelola Pelamar</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4">Nama Mahasiswa</th>
                        <th class="px-6 py-4">Posisi Lowongan</th>
                        <th class="px-6 py-4">Universitas</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tanggal Masuk</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($recentApplications as $app)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $app->student->user->name }}</td>
                            <td class="px-6 py-4">{{ $app->vacancy->posisi }}</td>
                            <td class="px-6 py-4">{{ $app->student->universitas }}</td>
                            <td class="px-6 py-4">
                                @if($app->status === 'pending_admin' || $app->status === 'pending_company')
                                    <span class="px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-semibold">Sedang Diproses</span>
                                @elseif($app->status === 'accepted')
                                    <span class="px-2.5 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">Telah Ditempatkan</span>
                                @else
                                    <span class="px-2.5 py-1 bg-red-100 text-red-800 rounded text-xs font-semibold">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $app->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada mahasiswa yang melamar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
