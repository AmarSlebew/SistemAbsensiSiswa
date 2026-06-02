<x-guru-layout>
    <x-slot name="title">Riwayat Absensi</x-slot>

    <div class="p-5 lg:p-6 space-y-4">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-gray-900 font-semibold text-lg">Riwayat Absensi</h1>
                <p class="text-gray-400 text-sm mt-0.5">Semua sesi absensi yang pernah Anda input</p>
            </div>
            <a href="{{ route('absensi.create') }}" id="btn-tambah-absensi"
               class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Input Absensi
            </a>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3">
                {{ session('success') }}
            </div>
        @endif
        @if(session('warning'))
            <div class="bg-amber-50 border border-amber-200 text-amber-700 text-sm rounded-lg px-4 py-3">
                {{ session('warning') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            @if($attendances->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Tanggal</th>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Kelas</th>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Mata Pelajaran</th>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Hadir</th>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Alpa</th>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Total</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($attendances as $att)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-3">
                                        <div class="text-gray-700 font-medium">{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</div>
                                        <div class="text-gray-400 text-xs">{{ \Carbon\Carbon::parse($att->date)->locale('id')->isoFormat('dddd') }}</div>
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="bg-amber-50 text-amber-700 border border-amber-100 text-xs font-medium px-2 py-0.5 rounded">
                                            {{ $att->classroom->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-gray-600">{{ $att->subject->name ?? '-' }}</td>
                                    <td class="px-5 py-3 text-green-600 font-medium">{{ $att->hadir_count }}</td>
                                    <td class="px-5 py-3">
                                        <span class="{{ $att->alpa_count > 0 ? 'text-red-500 font-medium' : 'text-gray-400' }}">
                                            {{ $att->alpa_count }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-gray-500">{{ $att->total_students }} siswa</td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('absensi.show', $att->id) }}"
                                               class="text-xs text-amber-600 hover:text-amber-700 font-medium">Detail</a>
                                            <span class="text-gray-200">|</span>
                                            <a href="{{ route('absensi.edit', $att->id) }}"
                                               class="text-xs text-gray-500 hover:text-gray-700 font-medium">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($attendances->hasPages())
                    <div class="px-5 py-4 border-t border-gray-100">
                        {{ $attendances->links() }}
                    </div>
                @endif
            @else
                <div class="flex flex-col items-center justify-center py-16 text-center text-gray-400">
                    <svg class="w-10 h-10 mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                    </svg>
                    <p class="text-sm font-medium text-gray-500">Belum ada absensi</p>
                    <p class="text-xs text-gray-400 mt-1">Klik tombol "Input Absensi" untuk memulai.</p>
                    <a href="{{ route('absensi.create') }}"
                       class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Input Absensi Sekarang
                    </a>
                </div>
            @endif
        </div>

    </div>
</x-guru-layout>
