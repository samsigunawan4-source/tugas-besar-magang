<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Perusahaan (Mitra Magang)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="py-3 px-4 font-semibold text-gray-600">Akun Perwakilan</th>
                                <th class="py-3 px-4 font-semibold text-gray-600">Informasi Perusahaan</th>
                                <th class="py-3 px-4 font-semibold text-gray-600 text-center">Lowongan Dibuat</th>
                                <th class="py-3 px-4 font-semibold text-gray-600 text-center">Bergabung Pada</th>
                                <th class="py-3 px-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($companies as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4">
                                        <div class="font-semibold text-gray-800">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($user->company)
                                            <a href="{{ route('admin.companies.show', $user->id) }}" class="flex items-center gap-3 hover:bg-gray-100 p-1 rounded transition-colors group">
                                                @if($user->company->logo)
                                                    <img src="{{ Storage::url($user->company->logo) }}" alt="Logo" class="h-8 w-8 object-contain bg-white border rounded p-0.5">
                                                @else
                                                    <div class="h-8 w-8 bg-gray-200 border rounded flex items-center justify-center text-gray-500 font-bold">{{ substr($user->company->nama_resmi, 0, 1) }}</div>
                                                @endif
                                                <div>
                                                    <div class="font-bold text-indigo-700 group-hover:text-indigo-900">{{ $user->company->nama_resmi }}</div>
                                                    <div class="text-xs text-gray-500 w-48 truncate" title="{{ $user->company->alamat }}">{{ $user->company->alamat }}</div>
                                                </div>
                                            </a>
                                        @else
                                            <span class="text-xs text-red-500 italic">Belum melengkapi profil</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($user->company)
                                            <span class="font-bold text-lg text-gray-700">{{ $user->company->vacancies->count() }}</span>
                                        @else
                                            <span class="text-xs text-gray-400">0</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center text-sm text-gray-500">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <a href="{{ route('admin.companies.show', $user->id) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-1.5 px-3 rounded-md transition-colors">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 px-4 text-center text-gray-500">Belum ada perusahaan mitra yang terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
