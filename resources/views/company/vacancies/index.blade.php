<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Lowongan Magang') }}
            </h2>
            <a href="{{ route('company.vacancies.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Buka Lowongan Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-4 flex border-b border-gray-200">
                <a href="{{ route('company.vacancies.index', ['tab' => 'active']) }}" class="py-2 px-4 {{ $tab === 'active' ? 'border-b-2 border-blue-500 text-blue-600 font-bold' : 'text-gray-500 hover:text-gray-700' }}">Lowongan Aktif & Menunggu</a>
                <a href="{{ route('company.vacancies.index', ['tab' => 'expired']) }}" class="py-2 px-4 {{ $tab === 'expired' ? 'border-b-2 border-gray-500 text-gray-800 font-bold' : 'text-gray-500 hover:text-gray-700' }}">Arsip (Kadaluarsa)</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2 px-4">Posisi</th>
                                <th class="border-b py-2 px-4">Kuota</th>
                                <th class="border-b py-2 px-4">Periode</th>
                                <th class="border-b py-2 px-4">Status</th>
                                <th class="border-b py-2 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vacancies as $vacancy)
                                <tr class="hover:bg-gray-50">
                                    <td class="border-b py-2 px-4 font-semibold">{{ $vacancy->posisi }}</td>
                                    <td class="border-b py-2 px-4">{{ $vacancy->kuota }} orang</td>
                                    <td class="border-b py-2 px-4">{{ $vacancy->tgl_mulai->format('d M Y') }} - {{ $vacancy->tgl_selesai->format('d M Y') }}</td>
                                    <td class="border-b py-2 px-4">
                                        @if($vacancy->status === 'pending')
                                            <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded text-xs font-bold">Menunggu Verifikasi Admin</span>
                                        @elseif($vacancy->status === 'approved')
                                            <span class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs font-bold">Aktif / Tayang</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-200 text-red-800 rounded text-xs font-bold">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="border-b py-2 px-4">
                                        <a href="{{ route('company.vacancies.show', $vacancy) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Detail & Pelamar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 px-4 text-center text-gray-500">Anda belum membuat lowongan magang apapun.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
