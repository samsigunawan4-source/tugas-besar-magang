<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Kategori Skill') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <div class="w-full md:w-1/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-bold mb-4">Tambah Kategori Baru</h3>
                        
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.skills.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <x-input-label for="name" :value="__('Nama Keahlian/Skill')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Web Development" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                                Tambah Skill
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-2/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-bold mb-4">Daftar Keahlian (Master Data)</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr>
                                        <th class="border-b py-2 px-4">No.</th>
                                        <th class="border-b py-2 px-4">Nama Keahlian</th>
                                        <th class="border-b py-2 px-4 text-center w-24">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($skills as $skill)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border-b py-2 px-4 text-gray-500">{{ $loop->iteration }}</td>
                                            <td class="border-b py-2 px-4 font-bold">{{ $skill->name }}</td>
                                            <td class="border-b py-2 px-4 text-center">
                                                <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus skill ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold text-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-4 px-4 text-center text-gray-500">Belum ada daftar keahlian. Silakan tambahkan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
