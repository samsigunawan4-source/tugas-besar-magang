<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="py-3 px-4 font-semibold text-gray-600">Nama Mahasiswa</th>
                                <th class="py-3 px-4 font-semibold text-gray-600">Email</th>
                                <th class="py-3 px-4 font-semibold text-gray-600">NIM & Kampus</th>
                                <th class="py-3 px-4 font-semibold text-gray-600">Keahlian (Skill)</th>
                                <th class="py-3 px-4 font-semibold text-gray-600">Status Magang</th>
                                <th class="py-3 px-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($students as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4">
                                        <div class="font-semibold text-gray-800">{{ $user->name }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="py-3 px-4">
                                        @if($user->student)
                                            <div class="text-sm font-semibold">{{ $user->student->nim }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->student->universitas }}</div>
                                        @else
                                            <span class="text-xs text-red-500 italic">Belum melengkapi profil</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($user->student && $user->student->skills->count() > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($user->student->skills as $skill)
                                                    <span class="px-2 py-0.5 bg-green-100 text-green-800 text-[10px] rounded-full">{{ $skill->name }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Belum ada</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($user->student)
                                            @php
                                                $acceptedApp = $user->student->applications->whereIn('status', ['accepted', 'completed'])->first();
                                                $pendingCount = $user->student->applications->whereIn('status', ['pending_admin', 'pending_company'])->count();
                                            @endphp

                                            @if($acceptedApp)
                                                @if($acceptedApp->status === 'completed')
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded">Selesai Magang</span>
                                                    <div class="text-[10px] text-gray-500 mt-1">{{ $acceptedApp->vacancy->company->nama_resmi ?? '' }}</div>
                                                @else
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded">Sedang Magang</span>
                                                    <div class="text-[10px] text-gray-500 mt-1">{{ $acceptedApp->vacancy->company->nama_resmi ?? '' }}</div>
                                                @endif
                                            @elseif($pendingCount > 0)
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded">Mencari Magang ({{ $pendingCount }} Lamaran)</span>
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded">Belum Melamar</span>
                                            @endif
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <a href="{{ route('admin.students.show', $user->id) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-1.5 px-3 rounded-md transition-colors">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 px-4 text-center text-gray-500">Belum ada mahasiswa yang terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
