<x-guru-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="p-5 lg:p-6 space-y-5">

        {{-- ===== WELCOME BANNER ===== --}}
        <div class="bg-amber-500 rounded-xl px-6 py-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <p class="text-amber-100 text-xs mb-0.5">
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </p>
                    <h1 class="text-white font-semibold text-xl">
                        Selamat datang, {{ auth()->user()->name }}
                    </h1>
                    <p class="text-amber-100 text-sm mt-0.5">
                        @if($hasData)
                            {{ $classrooms->count() }} kelas &middot; {{ $totalStudents }} siswa
                        @else
                            Belum ada data absensi.
                        @endif
                    </p>
                </div>
                @if($teacher && $teacher->nip)
                    <div class="bg-white/20 rounded-lg px-4 py-2 text-sm">
                        <div class="text-amber-100 text-xs">NIP</div>
                        <div class="text-white font-medium">{{ $teacher->nip }}</div>
                    </div>
                @endif
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Total Siswa</p>
                <p class="text-gray-900 text-2xl font-bold mt-1">{{ $totalStudents }}</p>
                <p class="text-gray-400 text-xs mt-1">{{ $classrooms->count() }} kelas</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Sesi Hari Ini</p>
                <p class="text-gray-900 text-2xl font-bold mt-1">{{ $todaySessions }}</p>
                <p class="text-gray-400 text-xs mt-1">sesi absensi</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Kehadiran Bulan Ini</p>
                <p class="text-gray-900 text-2xl font-bold mt-1">{{ $attendancePercentage }}<span class="text-base font-normal text-gray-400">%</span></p>
                <p class="text-gray-400 text-xs mt-1">dari {{ $totalMonth }} data</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Alpa Hari Ini</p>
                <p class="text-2xl font-bold mt-1 {{ $todayAlpha > 0 ? 'text-red-500' : 'text-gray-900' }}">
                    {{ $todayAlpha }}
                </p>
                <p class="text-gray-400 text-xs mt-1">siswa tidak hadir</p>
            </div>

        </div>

        {{-- ===== CHART + KELAS ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Chart --}}
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-5">
                <div class="mb-4">
                    <h2 class="text-gray-800 font-semibold text-sm">Tren Kehadiran</h2>
                    <p class="text-gray-400 text-xs mt-0.5">Jumlah siswa hadir per hari (7 hari terakhir)</p>
                </div>

                @if($hasData && array_sum($chartData) > 0)
                    <div style="height: 200px; position: relative;">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-10 text-center text-gray-400">
                        <svg class="w-8 h-8 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10"/>
                        </svg>
                        <p class="text-sm">Belum ada data kehadiran</p>
                    </div>
                @endif
            </div>

            {{-- Kelas --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-gray-800 font-semibold text-sm">Kelas Anda</h2>
                        <p class="text-gray-400 text-xs mt-0.5">Kelas yang pernah diajar</p>
                    </div>
                    <span class="text-xs font-semibold text-amber-700 bg-amber-50 border border-amber-100 px-2 py-0.5 rounded">
                        {{ $classrooms->count() }}
                    </span>
                </div>

                @if($classrooms->isNotEmpty())
                    <div class="max-h-[200px] overflow-y-auto pr-1 space-y-1.5">
                        @foreach($classrooms as $classroom)
                            <div class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="w-7 h-7 rounded-lg bg-amber-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($classroom->name, 0, 2)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-gray-700 text-sm font-medium truncate">{{ $classroom->name }}</div>
                                    <div class="text-gray-400 text-xs">{{ $classroom->students()->count() }} siswa</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-8 text-center text-gray-400">
                        <svg class="w-7 h-7 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                        </svg>
                        <p class="text-sm">Belum ada kelas</p>
                    </div>
                @endif
            </div>

        </div>

        {{-- ===== TABEL ABSENSI TERBARU ===== --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div>
                    <h2 class="text-gray-800 font-semibold text-sm">Absensi Terbaru</h2>
                    <p class="text-gray-400 text-xs mt-0.5">5 sesi absensi terakhir</p>
                </div>
            </div>

            @if($recentAttendances->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Tanggal</th>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Kelas</th>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Mata Pelajaran</th>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Hadir</th>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Alpa</th>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">%</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($recentAttendances as $att)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-3">
                                        <div class="text-gray-700 font-medium text-sm">
                                            {{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}
                                        </div>
                                        <div class="text-gray-400 text-xs">
                                            {{ \Carbon\Carbon::parse($att->date)->locale('id')->isoFormat('dddd') }}
                                        </div>
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="bg-amber-50 text-amber-700 border border-amber-100 text-xs font-medium px-2 py-0.5 rounded">
                                            {{ $att->classroom->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-gray-600 text-sm">{{ $att->subject->name ?? '-' }}</td>
                                    <td class="px-5 py-3 text-gray-700 font-medium text-sm">
                                        {{ $att->hadir }}<span class="text-gray-400 font-normal">/{{ $att->total }}</span>
                                    </td>
                                    <td class="px-5 py-3 text-sm">
                                        <span class="{{ $att->alpa > 0 ? 'text-red-500 font-medium' : 'text-gray-400' }}">
                                            {{ $att->alpa }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                <div class="h-full rounded-full"
                                                     style="width: {{ $att->persen }}%;
                                                            background: {{ $att->persen >= 80 ? '#22c55e' : ($att->persen >= 60 ? '#f59e0b' : '#ef4444') }}">
                                                </div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-600">{{ $att->persen }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-14 text-center text-gray-400">
                    <svg class="w-10 h-10 mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-sm font-medium text-gray-500">Belum ada data absensi</p>
                    <p class="text-xs text-gray-400 mt-1">Mulai input absensi untuk melihat rekap di sini.</p>
                    <a href="#" id="btn-mulai-absensi"
                       class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Input Absensi
                    </a>
                </div>
            @endif
        </div>

    </div>

    @push('scripts')
    @if($hasData && array_sum($chartData) > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('weeklyChart');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Siswa Hadir',
                        data: @json($chartData),
                        backgroundColor: '#fde68a',
                        borderColor: '#f59e0b',
                        borderWidth: 1.5,
                        borderRadius: 4,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1c1917',
                            titleColor: '#a8a29e',
                            bodyColor: '#e7e5e4',
                            padding: 8,
                            cornerRadius: 6,
                            callbacks: {
                                label: ctx => ` ${ctx.parsed.y} siswa hadir`
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { color: '#9ca3af', font: { size: 11, family: 'Inter' } }
                        },
                        y: {
                            beginAtZero: true,
                            border: { display: false },
                            grid: { color: '#f3f4f6' },
                            ticks: {
                                color: '#9ca3af',
                                font: { size: 11, family: 'Inter' },
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endif
    @endpush

</x-guru-layout>
