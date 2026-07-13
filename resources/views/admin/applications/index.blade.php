<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Administrasi Pelamar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto">
                    <p class="mb-4 text-gray-600 text-sm">Periksa kelengkapan KHS dan Bukti Pembayaran Semester. Jika lengkap, setujui agar diteruskan ke pihak Perusahaan.</p>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2 px-4">Nama Mahasiswa</th>
                                <th class="border-b py-2 px-4">Lowongan Tujuan</th>
                                <th class="border-b py-2 px-4">Dokumen KHS</th>
                                <th class="border-b py-2 px-4">Bukti Pembayaran</th>
                                <th class="border-b py-2 px-4">Status</th>
                                <th class="border-b py-2 px-4 text-center">Aksi (Verifikasi)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $app)
                                <tr class="hover:bg-gray-50">
                                    <td class="border-b py-2 px-4 font-semibold">
                                        {{ $app->student->user->name }}
                                        @php
                                            $vacancySkillIds = $app->vacancy->skills->pluck('id')->toArray();
                                            $matchedSkills = $app->student->skills->filter(fn($s) => in_array($s->id, $vacancySkillIds));
                                        @endphp
                                        <div class="mt-1">
                                            <span class="bg-indigo-100 text-indigo-800 text-[10px] px-2 py-0.5 rounded-full font-bold">Kecocokan Skill: {{ $matchedSkills->count() }}</span>
                                        </div>
                                    </td>
                                    <td class="border-b py-2 px-4">{{ $app->vacancy->posisi }} ({{ $app->vacancy->company->nama_resmi }})</td>
                                    <td class="border-b py-2 px-4">
                                        <a href="{{ Storage::url($app->khs_pdf) }}" target="_blank" class="text-blue-600 hover:underline text-xs font-bold">PDF KHS</a>
                                    </td>
                                    <td class="border-b py-2 px-4">
                                        @if($app->pembayaran_pdf)
                                            <a href="{{ Storage::url($app->pembayaran_pdf) }}" target="_blank" class="text-blue-600 hover:underline text-xs font-bold">PDF Pembayaran</a>
                                        @else
                                            <span class="text-red-500 text-xs italic">Tidak ada file</span>
                                        @endif
                                    </td>
                                    <td class="border-b py-2 px-4">
                                        @if($app->status === 'pending_admin' || $app->status === 'pending_company')
                                            <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded text-xs font-bold">Menunggu Seleksi</span>
                                        @elseif($app->status === 'accepted')
                                            <span class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs font-bold">Diterima (Sedang Magang)</span>
                                        @elseif($app->status === 'completed')
                                            <span class="px-2 py-1 bg-blue-200 text-blue-800 rounded text-xs font-bold">Selesai Magang</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-200 text-red-800 rounded text-xs font-bold">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="border-b py-2 px-4 text-center">
                                        @if($app->status === 'pending_admin' || $app->status === 'pending_company')
                                            <div class="flex justify-center gap-2">
                                                <form method="POST" action="{{ route('admin.applications.verify', $app->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="accepted">
                                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white text-xs font-bold py-1 px-2 rounded" onclick="return confirm('Terima mahasiswa ini dan tempatkan di perusahaan tersebut? Lamaran lain milik mahasiswa ini akan OTOMATIS DITOLAK.')">Terima</button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.applications.verify', $app->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-2 rounded" onclick="return confirm('Tolak lamaran ini?')">Tolak</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Arsip ({{ ucfirst($app->status) }})</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 px-4 text-center text-gray-500">Belum ada mahasiswa yang melamar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
