<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Logbook Mahasiswa (Admin)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @forelse($applications as $app)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-gray-200 border-b flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $app->student->user->name }} ({{ $app->student->nim }})</h3>
                            <p class="text-sm text-gray-600">Magang di: <span class="font-bold">{{ $app->vacancy->company->nama_resmi }}</span> - {{ $app->vacancy->posisi }}</p>
                        </div>
                        <div class="text-sm font-bold bg-white px-3 py-1 rounded shadow-sm">
                            Total Entri: {{ $app->logbooks->count() }} Hari
                        </div>
                    </div>
                    
                    <div class="p-4 overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr>
                                    <th class="border-b py-2 px-4 w-32">Tanggal</th>
                                    <th class="border-b py-2 px-4">Deskripsi Kegiatan</th>
                                    <th class="border-b py-2 px-4 w-24">Foto</th>
                                    <th class="border-b py-2 px-4">Status & Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($app->logbooks as $log)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border-b py-2 px-4 font-semibold align-top">{{ $log->tanggal->format('d M Y') }}</td>
                                        <td class="border-b py-2 px-4 align-top">{{ $log->kegiatan }}</td>
                                        <td class="border-b py-2 px-4 align-top">
                                            <a href="{{ Storage::url($log->foto_bukti) }}" target="_blank">
                                                <img src="{{ Storage::url($log->foto_bukti) }}" class="h-10 w-10 object-cover rounded" />
                                            </a>
                                        </td>
                                        <td class="border-b py-2 px-4 align-top">
                                            @if($log->status === 'pending')
                                                <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded text-xs font-bold block mb-1 w-max">Menunggu Pengecekan</span>
                                            @elseif($log->status === 'approved')
                                                <span class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs font-bold block mb-1 w-max">Disetujui</span>
                                            @elseif($log->status === 'rejected')
                                                <span class="px-2 py-1 bg-red-200 text-red-800 rounded text-xs font-bold block mb-1 w-max">Perlu Revisi</span>
                                            @endif
                                            
                                            @if($log->feedback)
                                                <div class="mt-2 text-xs text-gray-700 bg-gray-100 p-2 rounded border border-gray-200">
                                                    <strong>Catatan:</strong> {{ $log->feedback }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-4 px-4 text-center text-gray-500">Mahasiswa ini belum mengisi logbook sama sekali.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 rounded shadow text-center text-gray-500">
                    Belum ada mahasiswa yang berstatus Diterima Magang.
                </div>
            @endforelse
            
        </div>
    </div>
</x-app-layout>
