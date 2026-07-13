<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
            <p class="text-sm text-gray-500">Ringkasan informasi sistem</p>
        </div>
    </x-slot>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Mahasiswa -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500">Total Mahasiswa</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_students'] }}</p>
                <p class="text-xs text-gray-400">Mahasiswa terdaftar</p>
            </div>
        </div>

        <!-- Program Aktif -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500">Program Aktif</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['active_programs'] }}</p>
                <p class="text-xs text-gray-400">Lowongan disetujui</p>
            </div>
        </div>

        <!-- Pengajuan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-yellow-50 text-yellow-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500">Pengajuan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['pending_applications'] }}</p>
                <p class="text-xs text-gray-400">Menunggu verifikasi</p>
            </div>
        </div>

        <!-- Sedang Berjalan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500">Sedang Berjalan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['running_programs'] }}</p>
                <p class="text-xs text-gray-400">Mahasiswa magang</p>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Status Program Pie Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 col-span-1">
            <h3 class="font-bold text-gray-800 mb-4">Status Program</h3>
            <div class="relative h-64 w-full flex items-center justify-center">
                <canvas id="statusChart"></canvas>
            </div>
            <div class="mt-4 flex flex-col gap-2 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-yellow-400"></span> Menunggu Verifikasi</span>
                    <span class="font-bold">{{ $pieChartData['pending'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-green-500"></span> Disetujui (Ditempatkan)</span>
                    <span class="font-bold">{{ $pieChartData['accepted'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-500"></span> Ditolak</span>
                    <span class="font-bold">{{ $pieChartData['rejected'] }}</span>
                </div>
            </div>
        </div>

        <!-- Line Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 col-span-2">
            <h3 class="font-bold text-gray-800 mb-4">Pengajuan per Bulan (Simulasi)</h3>
            <div class="relative h-64 w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Table Row -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Pengajuan Terbaru</h3>
            <a href="{{ route('admin.applications.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4">Mahasiswa</th>
                        <th class="px-6 py-4">Perusahaan</th>
                        <th class="px-6 py-4">Posisi</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($recentApplications as $app)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $app->student->user->name }}</td>
                            <td class="px-6 py-4">{{ $app->vacancy->company->nama_resmi }}</td>
                            <td class="px-6 py-4">{{ $app->vacancy->posisi }}</td>
                            <td class="px-6 py-4">
                                @if($app->status === 'pending_admin' || $app->status === 'pending_company')
                                    <span class="px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-semibold">Menunggu Verifikasi</span>
                                @elseif($app->status === 'accepted')
                                    <span class="px-2.5 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">Disetujui</span>
                                @else
                                    <span class="px-2.5 py-1 bg-red-100 text-red-800 rounded text-xs font-semibold">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $app->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada pengajuan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pie Chart
            const ctxPie = document.getElementById('statusChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: ['Menunggu', 'Disetujui', 'Ditolak'],
                    datasets: [{
                        data: [{{ $pieChartData['pending'] }}, {{ $pieChartData['accepted'] }}, {{ $pieChartData['rejected'] }}],
                        backgroundColor: ['#FBBF24', '#22C55E', '#EF4444'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // Line Chart
            const ctxLine = document.getElementById('trendChart').getContext('2d');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Pengajuan Masuk',
                        data: [10, 24, 26, 22, 31, 20],
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#3B82F6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f3f4f6' },
                            border: { display: false }
                        },
                        x: {
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
