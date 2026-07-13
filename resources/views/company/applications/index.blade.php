<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seleksi Pelamar Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($vacancies as $vacancy)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border-l-4 border-blue-500">
                    <div class="p-6 bg-gray-50 border-b flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $vacancy->posisi }}</h3>
                            <p class="text-sm text-gray-600">Kuota: {{ $vacancy->kuota }} orang | Status Lowongan: <span class="font-bold">{{ strtoupper($vacancy->status) }}</span></p>
                        </div>
                        <div class="text-sm bg-blue-100 text-blue-800 py-1 px-3 rounded-full font-bold">
                            Total Pelamar: {{ $vacancy->applications->count() }}
                        </div>
                    </div>
                    
                    <div class="p-6 overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="border-b py-2 px-4">Nama Mahasiswa</th>
                                    <th class="border-b py-2 px-4">NIM</th>
                                    <th class="border-b py-2 px-4">Universitas</th>
                                    <th class="border-b py-2 px-4">KHS / Transkrip</th>
                                    <th class="border-b py-2 px-4">Status Penempatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vacancy->applications as $app)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border-b py-2 px-4 font-semibold">
                                            {{ $app->student->user->name }}
                                            @php
                                                $vacancySkillIds = $vacancy->skills->pluck('id')->toArray();
                                                $matchedSkills = $app->student->skills->filter(fn($s) => in_array($s->id, $vacancySkillIds));
                                            @endphp
                                            <div class="mt-1">
                                                <span class="bg-indigo-100 text-indigo-800 text-[10px] px-2 py-0.5 rounded-full font-bold">Cocok: {{ $matchedSkills->count() }} Skill</span>
                                            </div>
                                        </td>
                                        <td class="border-b py-2 px-4">{{ $app->student->nim }}</td>
                                        <td class="border-b py-2 px-4">{{ $app->student->universitas }}</td>
                                        <td class="border-b py-2 px-4">
                                            <a href="{{ Storage::url($app->khs_pdf) }}" target="_blank" class="text-blue-600 hover:underline text-sm font-bold">Lihat PDF KHS</a>
                                        </td>
                                        <td class="border-b py-2 px-4">
                                            @if($app->status === 'accepted')
                                                <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 mb-2">
                                                    <p class="text-[10px] font-bold text-gray-700 mb-1">Laporan Akhir Mahasiswa:</p>
                                                    @if($app->laporan_akhir)
                                                        <a href="{{ Storage::url($app->laporan_akhir) }}" target="_blank" class="text-blue-600 hover:underline text-xs font-bold flex items-center gap-1 mb-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                                            Unduh Laporan Akhir
                                                        </a>
                                                        <form action="{{ route('company.applications.complete', $app->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2 border-t border-blue-200 pt-2">
                                                            @csrf
                                                            <div class="flex items-center gap-2">
                                                                <label class="text-[10px] font-bold text-gray-700 w-16">Nilai Akhir:</label>
                                                                <input type="text" name="nilai" class="text-xs p-1 border rounded w-full" placeholder="Contoh: A / 85" required>
                                                            </div>
                                                            <div class="flex items-center gap-2 mt-1">
                                                                <label class="text-[10px] font-bold text-gray-700 w-16">Sertifikat (PDF):</label>
                                                                <input type="file" name="sertifikat" accept="application/pdf" class="text-[10px] w-full text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-sm file:border-0 file:text-[10px] file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer" required>
                                                            </div>
                                                            @error('sertifikat')<span class="text-red-500 text-[10px]">{{ $message }}</span>@enderror
                                                            @error('nilai')<span class="text-red-500 text-[10px]">{{ $message }}</span>@enderror
                                                            
                                                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-bold py-1.5 px-2 rounded mt-1" onclick="return confirm('Selesaikan magang mahasiswa ini? Anda tidak bisa mengubah data ini nanti.')">
                                                                Selesaikan Magang
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-[10px] text-gray-500 italic block mt-1">Menunggu mahasiswa mengunggah laporan akhir.</span>
                                                    @endif
                                                </div>
                                            @elseif($app->status === 'completed')
                                                <span class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs font-bold block w-max mb-1">Magang Selesai</span>
                                                <div class="text-[10px] text-gray-600">
                                                    <p><span class="font-bold">Nilai:</span> {{ $app->nilai }}</p>
                                                    <a href="{{ Storage::url($app->sertifikat) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Sertifikat</a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 px-4 text-center text-gray-500">Belum ada mahasiswa yang melamar ke posisi ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 rounded shadow text-center text-gray-500">
                    Perusahaan Anda belum pernah membuka lowongan magang.
                </div>
            @endforelse
            
        </div>
    </div>
</x-app-layout>
