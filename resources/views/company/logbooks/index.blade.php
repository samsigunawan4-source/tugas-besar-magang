<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Logbook Mahasiswa (Perusahaan)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @forelse($vacancies as $vacancy)
                @foreach($vacancy->applications as $app)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border-l-4 border-blue-500">
                        <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $app->student->user->name }} ({{ $app->student->nim }})</h3>
                                <p class="text-sm text-gray-600">Posisi: <span class="font-bold">{{ $vacancy->posisi }}</span></p>
                            </div>
                            <div class="text-sm font-bold bg-blue-100 text-blue-800 px-3 py-1 rounded-full shadow-sm">
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
                                                    <img src="{{ Storage::url($log->foto_bukti) }}" class="h-10 w-10 object-cover rounded hover:scale-150 transition transform origin-top-left" />
                                                </a>
                                            </td>
                                            <td class="border-b py-2 px-4 align-top">
                                                <form action="{{ route('company.logbooks.update-status', $log->id) }}" method="POST" class="flex flex-col gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <div class="flex gap-2">
                                                        <select name="status" class="text-sm border-gray-300 rounded shadow-sm py-1 w-32" required>
                                                            <option value="pending" {{ $log->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                                            <option value="approved" {{ $log->status === 'approved' ? 'selected' : '' }}>Setujui</option>
                                                            <option value="rejected" {{ $log->status === 'rejected' ? 'selected' : '' }}>Tolak/Revisi</option>
                                                        </select>
                                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded">Simpan</button>
                                                    </div>
                                                    
                                                    <textarea name="feedback" rows="2" class="text-xs border-gray-300 rounded shadow-sm w-full" placeholder="Tambahkan catatan/feedback di sini...">{{ $log->feedback }}</textarea>
                                                </form>
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
                @endforeach
            @empty
                <div class="bg-white p-6 rounded shadow text-center text-gray-500">
                    Anda belum memiliki mahasiswa magang yang aktif/diterima.
                </div>
            @endforelse
            
        </div>
    </div>
</x-app-layout>
