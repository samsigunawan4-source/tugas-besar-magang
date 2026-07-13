<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Role Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="py-3 px-4 font-semibold text-gray-600">Nama Pengguna</th>
                                <th class="py-3 px-4 font-semibold text-gray-600">Email</th>
                                <th class="py-3 px-4 font-semibold text-gray-600">Tanggal Terdaftar</th>
                                <th class="py-3 px-4 font-semibold text-gray-600">Role Saat Ini</th>
                                <th class="py-3 px-4 font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4">
                                        <div class="font-semibold text-gray-800">{{ $user->name }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-500">
                                        {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($user->role === 'admin')
                                            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-bold rounded capitalize">{{ $user->role }}</span>
                                        @elseif($user->role === 'perusahaan')
                                            <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-bold rounded capitalize">{{ $user->role }}</span>
                                        @else
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded capitalize">{{ $user->role }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($user->id === auth()->id())
                                            <span class="text-xs text-gray-400 italic">Anda sendiri (Dilindungi)</span>
                                        @else
                                            <div class="flex items-center gap-4">
                                                <form action="{{ route('admin.users.update-role', $user->id) }}" method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="role" class="text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                        <option value="mahasiswa" {{ $user->role === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                                        <option value="perusahaan" {{ $user->role === 'perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                    </select>
                                                    <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold py-1.5 px-3 rounded-md transition-colors">
                                                        Simpan
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini secara permanen? Semua data terkait juga akan terhapus.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1.5 px-3 rounded-md transition-colors">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
