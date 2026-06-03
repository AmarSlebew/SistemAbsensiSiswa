<x-guru-layout>
    <x-slot name="title">Detail Absensi</x-slot>

    <div class="p-5 lg:p-6 space-y-4">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('absensi.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="flex-1">
                <h1 class="text-gray-900 font-semibold text-lg">Detail Absensi</h1>
                <p class="text-gray-400 text-sm">
                    {{ $attendance->classroom->name ?? '-' }} &middot;
                    {{ $attendance->subject->name ?? '-' }} &middot;
                    {{ \Carbon\Carbon::parse($attendance->date)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </p>
            </div>
            <a href="{{ route('absensi.pdf', $attendance->id) }}"
               class="inline-flex items-center gap-2 px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Ekspor PDF
            </a>
            <a href="{{ route('absensi.edit', $attendance->id) }}"
               class="inline-flex items-center gap-2 px-3 py-2 border border-gray-200 hover:bg-gray-50 text-gray-600 text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- Ringkasan --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
                <p class="text-2xl font-bold text-green-600">{{ $summary['hadir'] }}</p>
                <p class="text-xs text-gray-400 mt-0.5 font-medium">Hadir</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
                <p class="text-2xl font-bold text-blue-500">{{ $summary['izin'] }}</p>
                <p class="text-xs text-gray-400 mt-0.5 font-medium">Izin</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
                <p class="text-2xl font-bold text-yellow-500">{{ $summary['sakit'] }}</p>
                <p class="text-xs text-gray-400 mt-0.5 font-medium">Sakit</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
                <p class="text-2xl font-bold text-red-500">{{ $summary['alpa'] }}</p>
                <p class="text-xs text-gray-400 mt-0.5 font-medium">Alpa</p>
            </div>
        </div>

        {{-- Tabel Siswa --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-700">
                    Daftar Siswa
                    <span class="text-gray-400 font-normal">({{ $summary['total'] }} siswa)</span>
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">#</th>
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Nama</th>
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">NIS</th>
                            <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($attendance->details->sortBy('student.name') as $i => $detail)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 text-gray-400 text-sm">{{ $i + 1 }}</td>
                                <td class="px-5 py-3 text-gray-700 font-medium text-sm">{{ $detail->student->name }}</td>
                                <td class="px-5 py-3 text-gray-400 text-xs">{{ $detail->student->nis }}</td>
                                <td class="px-5 py-3">
                                    @php
                                        $badge = match($detail->status) {
                                            'Hadir' => 'bg-green-50 text-green-700 border-green-100',
                                            'Izin'  => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'Sakit' => 'bg-yellow-50 text-yellow-600 border-yellow-100',
                                            'Alpa'  => 'bg-red-50 text-red-600 border-red-100',
                                            default => 'bg-gray-50 text-gray-500 border-gray-100',
                                        };
                                    @endphp
                                    <span class="text-xs font-medium px-2.5 py-0.5 rounded border {{ $badge }}">
                                        {{ $detail->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-guru-layout>
