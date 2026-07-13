<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Lowongan Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex border-b border-gray-200">
                <a href="{{ route('admin.vacancies.index', ['tab' => 'active']) }}" class="py-2 px-4 {{ $tab === 'active' ? 'border-b-2 border-blue-500 text-blue-600 font-bold' : 'text-gray-500 hover:text-gray-700' }}">Lowongan Aktif & Menunggu</a>
                <a href="{{ route('admin.vacancies.index', ['tab' => 'expired']) }}" class="py-2 px-4 {{ $tab === 'expired' ? 'border-b-2 border-gray-500 text-gray-800 font-bold' : 'text-gray-500 hover:text-gray-700' }}">Arsip (Kadaluarsa)</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2 px-4">Perusahaan</th>
                                <th class="border-b py-2 px-4">Posisi</th>
                                <th class="border-b py-2 px-4">Detail</th>
                                <th class="border-b py-2 px-4">Status</th>
                                <th class="border-b py-2 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vacancies as $vacancy)
                                <tr class="hover:bg-gray-50">
                                    <td class="border-b py-2 px-4 font-semibold">{{ $vacancy->company->nama_resmi ?? 'Unknown' }}</td>
                                    <td class="border-b py-2 px-4">{{ $vacancy->posisi }}</td>
                                    <td class="border-b py-2 px-4">
                                        <a href="{{ route('admin.vacancies.show', $vacancy->id) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded shadow-md transition-colors">
                                            Lihat Detail Lowongan
                                        </a>
                                    </td>
                                    <td class="border-b py-2 px-4">
                                        @if($vacancy->status === 'pending')
                                            <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded text-xs font-bold">Menunggu</span>
                                        @elseif($vacancy->status === 'approved')
                                            <span class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs font-bold">Disetujui</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-200 text-red-800 rounded text-xs font-bold">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="border-b py-2 px-4">
                                        @if($vacancy->status === 'approved')
                                            <form method="POST" action="{{ route('admin.vacancies.approve', $vacancy) }}">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1.5 px-3 rounded shadow-sm" onclick="return confirm('Apakah Anda yakin ingin menghentikan sementara lowongan ini? Mahasiswa tidak akan bisa mendaftar.');">
                                                    Hentikan Sementara
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs italic">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 px-4 text-center text-gray-500">Belum ada lowongan yang masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
