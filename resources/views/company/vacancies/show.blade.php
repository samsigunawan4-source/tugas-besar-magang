<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Lowongan: ') }} {{ $vacancy->posisi }}
            </h2>
            <a href="{{ route('company.vacancies.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Vacancy Info -->
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
                            
                            <p class="text-sm text-gray-500">Status Lowongan:</p>
                            <p class="font-semibold mb-3">
                                @if($vacancy->status === 'approved')
                                    <span class="text-green-600">Disetujui Admin (Aktif)</span>
                                @elseif($vacancy->status === 'pending')
                                    <span class="text-yellow-600">Menunggu Verifikasi</span>
                                @else
                                    <span class="text-red-600">Ditolak</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Deskripsi:</p>
                            <p class="mb-3 text-sm">{{ $vacancy->deskripsi }}</p>
                            
                            <p class="text-sm text-gray-500">Kualifikasi:</p>
                            <p class="mb-3 text-sm">{{ $vacancy->kualifikasi }}</p>
                            
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

            <!-- Placed Students -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-bold">Daftar Mahasiswa Ditempatkan</h3>
                        <span class="text-sm text-gray-500">Berdasarkan Seleksi Admin</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="border-b py-2 px-4 bg-gray-50">Nama Mahasiswa</th>
                                    <th class="border-b py-2 px-4 bg-gray-50">NIM</th>
                                    <th class="border-b py-2 px-4 bg-gray-50">Universitas</th>
                                    <th class="border-b py-2 px-4 bg-gray-50">Keahlian Mahasiswa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Sesuai permintaan: Perusahaan HANYA melihat mahasiswa yang telah DISETUJUI (accepted) oleh Admin
                                    $acceptedApplications = $vacancy->applications->where('status', 'accepted');
                                @endphp
                                
                                @forelse($acceptedApplications as $app)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border-b py-3 px-4 font-semibold">{{ $app->student->user->name }}</td>
                                        <td class="border-b py-3 px-4">{{ $app->student->nim }}</td>
                                        <td class="border-b py-3 px-4">{{ $app->student->universitas }}</td>
                                        <td class="border-b py-3 px-4">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($app->student->skills as $skill)
                                                    <span class="px-2 py-0.5 bg-green-100 text-green-800 text-[10px] rounded">{{ $skill->name }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 px-4 text-center text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                            Belum ada mahasiswa yang ditempatkan oleh Admin di lowongan ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
