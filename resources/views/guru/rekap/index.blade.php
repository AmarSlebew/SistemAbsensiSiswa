<x-guru-layout>
    <x-slot name="title">Rekap Absensi</x-slot>

    <div class="p-5 lg:p-6 space-y-5">

        {{-- Header --}}
        <div>
            <h1 class="text-gray-900 font-semibold text-lg">Rekap Absensi</h1>
            <p class="text-gray-400 text-sm">Lihat akumulasi kehadiran siswa di kelas Anda</p>
        </div>

        {{-- Filter Panel --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <form method="GET" action="{{ route('rekap.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    {{-- Kelas --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5" for="classroom_id">Kelas *</label>
                        <select name="classroom_id" id="classroom_id" required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classrooms as $class)
                                <option value="{{ $class->id }}" {{ $selectedClassroom == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Mapel --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5" for="subject_id">Mata Pelajaran (Opsional)</label>
                        <select name="subject_id" id="subject_id"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
                            <option value="">Semua Mapel</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5" for="start_date">Dari Tanggal (Opsional)</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5" for="end_date">Sampai Tanggal (Opsional)</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                    <p class="text-[11px] text-gray-400">* Menunjukkan filter wajib diisi.</p>
                    <div class="flex items-center gap-2">
                        @if($selectedClassroom)
                            <a href="{{ route('rekap.index') }}"
                               class="px-4 py-2 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                                Reset
                            </a>
                        @endif
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Tampilkan Rekap
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Data Panel --}}
        @if($selectedClassroom)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between flex-wrap gap-2">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-700">Daftar Kehadiran Siswa</h2>
                        <p class="text-gray-400 text-xs mt-0.5">
                            Kelas: <span class="font-medium text-gray-600">{{ $classrooms->firstWhere('id', $selectedClassroom)->name ?? '-' }}</span>
                            @if($selectedSubject)
                                &middot; Mapel: <span class="font-medium text-gray-600">{{ $subjects->firstWhere('id', $selectedSubject)->name ?? '-' }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($recapData->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide w-8">#</th>
                                    <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Nama Siswa</th>
                                    <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">NIS</th>
                                    <th class="text-center px-4 py-3 text-xs font-medium text-green-600 uppercase tracking-wide">Hadir</th>
                                    <th class="text-center px-4 py-3 text-xs font-medium text-blue-600 uppercase tracking-wide">Izin</th>
                                    <th class="text-center px-4 py-3 text-xs font-medium text-yellow-600 uppercase tracking-wide">Sakit</th>
                                    <th class="text-center px-4 py-3 text-xs font-medium text-red-500 uppercase tracking-wide">Alpa</th>
                                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Total Sesi</th>
                                    <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide w-32">% Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($recapData as $i => $row)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3 text-gray-400 text-sm">{{ $i + 1 }}</td>
                                        <td class="px-5 py-3 text-gray-700 font-medium text-sm">{{ $row->student->name }}</td>
                                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $row->student->nis }}</td>
                                        <td class="px-4 py-3 text-center text-green-600 font-semibold">{{ $row->hadir }}</td>
                                        <td class="px-4 py-3 text-center text-blue-500">{{ $row->izin }}</td>
                                        <td class="px-4 py-3 text-center text-yellow-500">{{ $row->sakit }}</td>
                                        <td class="px-4 py-3 text-center text-red-500 font-semibold">{{ $row->alpa }}</td>
                                        <td class="px-4 py-3 text-center text-gray-500">{{ $row->total }}</td>
                                        <td class="px-5 py-3">
                                            <div class="flex items-center gap-2">
                                                <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                    <div class="h-full rounded-full"
                                                         style="width: {{ $row->percentage }}%;
                                                                background: {{ $row->percentage >= 80 ? '#22c55e' : ($row->percentage >= 60 ? '#f59e0b' : '#ef4444') }}">
                                                    </div>
                                                </div>
                                                <span class="text-xs font-medium text-gray-600">{{ $row->percentage }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-16 text-center text-gray-400">
                        <p class="text-sm">Tidak ada data siswa ditemukan untuk kelas ini.</p>
                    </div>
                @endif
            </div>
        @else
            {{-- Empty State (Belum Pilih Kelas) --}}
            <div class="bg-white rounded-xl border border-gray-200 py-16 px-6 text-center text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-sm font-medium text-gray-500">Silakan pilih kelas terlebih dahulu</p>
                <p class="text-xs text-gray-400 mt-1">Pilih kelas di panel filter di atas untuk melihat rekap kehadiran.</p>
            </div>
        @endif

    </div>
</x-guru-layout>
