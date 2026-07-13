<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengisian Logbook Harian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border-l-4 border-indigo-500">
                <div class="p-6 bg-gray-50 border-b">
                    <h3 class="text-xl font-bold text-gray-900">Magang Aktif: {{ $application->vacancy->posisi }}</h3>
                    <p class="text-sm text-gray-600">Perusahaan: {{ $application->vacancy->company->nama_resmi }}</p>
                </div>
                
                <div class="p-6 border-b">
                    <h4 class="font-bold mb-4">Isi Laporan Hari Ini</h4>
                    <form action="{{ route('student.logbooks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <x-input-label for="tanggal" :value="__('Tanggal Kegiatan')" />
                                <x-text-input id="tanggal" name="tanggal" type="date" class="mt-1 block w-full border" required value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
                            </div>
                            
                            <div>
                                <x-input-label for="foto_bukti" :value="__('Upload Foto Bukti (JPG/PNG)')" class="text-red-600 font-bold" />
                                <x-text-input id="foto_bukti" name="foto_bukti" type="file" accept="image/*" class="mt-1 block w-full border" required />
                                <x-input-error class="mt-2" :messages="$errors->get('foto_bukti')" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="kegiatan" :value="__('Deskripsi Kegiatan')" />
                            <textarea id="kegiatan" name="kegiatan" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Jelaskan apa yang Anda kerjakan hari ini..."></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('kegiatan')" />
                        </div>

                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow">
                            Simpan Logbook
                        </button>
                    </form>
                </div>
                
                <div class="p-6 overflow-x-auto bg-white">
                    <h4 class="font-bold mb-4">Riwayat Logbook Anda</h4>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2 px-4">Tanggal</th>
                                <th class="border-b py-2 px-4">Kegiatan</th>
                                <th class="border-b py-2 px-4">Foto Bukti</th>
                                <th class="border-b py-2 px-4">Status & Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logbooks as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="border-b py-2 px-4 font-semibold whitespace-nowrap align-top">{{ $log->tanggal->format('d M Y') }}</td>
                                    <td class="border-b py-2 px-4 align-top">{{ $log->kegiatan }}</td>
                                    <td class="border-b py-2 px-4 align-top">
                                        <a href="{{ Storage::url($log->foto_bukti) }}" target="_blank">
                                            <img src="{{ Storage::url($log->foto_bukti) }}" alt="Foto Bukti" class="h-16 w-16 object-cover rounded shadow hover:scale-150 transition transform origin-top-left" />
                                        </a>
                                    </td>
                                    <td class="border-b py-2 px-4 align-top">
                                        @if($log->status === 'pending')
                                            <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded text-xs font-bold block mb-2 w-max">Menunggu Pengecekan</span>
                                        @elseif($log->status === 'approved')
                                            <span class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs font-bold block mb-2 w-max">Disetujui</span>
                                        @elseif($log->status === 'rejected')
                                            <span class="px-2 py-1 bg-red-200 text-red-800 rounded text-xs font-bold block mb-2 w-max">Perlu Revisi</span>
                                        @endif
                                        
                                        @if($log->feedback)
                                            <div class="mt-2 text-xs text-gray-700 bg-gray-100 p-2 rounded border border-gray-200">
                                                <strong>Catatan Supervisor:</strong><br>
                                                {{ $log->feedback }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 px-4 text-center text-gray-500">Anda belum pernah mengisi logbook harian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
