<x-guru-layout>
    <x-slot name="title">Edit Absensi</x-slot>

    <div class="p-5 lg:p-6 space-y-5">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('absensi.show', $attendance->id) }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-gray-900 font-semibold text-lg">Edit Absensi</h1>
                <p class="text-gray-400 text-sm">
                    {{ $attendance->classroom->name ?? '-' }} &middot;
                    {{ $attendance->subject->name ?? '-' }} &middot;
                    {{ \Carbon\Carbon::parse($attendance->date)->locale('id')->isoFormat('D MMMM Y') }}
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('absensi.update', $attendance->id) }}">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-700">Status Kehadiran Siswa</h2>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-400">Isi semua:</span>
                        <button type="button" onclick="fillAll('Hadir')"
                                class="text-xs px-2.5 py-1 bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 rounded transition-colors">
                            Hadir
                        </button>
                        <button type="button" onclick="fillAll('Alpa')"
                                class="text-xs px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded transition-colors">
                            Alpa
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide w-8">#</th>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Nama Siswa</th>
                                <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">NIS</th>
                                <th class="text-center px-3 py-3 text-xs font-medium text-green-600 uppercase tracking-wide">Hadir</th>
                                <th class="text-center px-3 py-3 text-xs font-medium text-blue-600 uppercase tracking-wide">Izin</th>
                                <th class="text-center px-3 py-3 text-xs font-medium text-yellow-600 uppercase tracking-wide">Sakit</th>
                                <th class="text-center px-3 py-3 text-xs font-medium text-red-500 uppercase tracking-wide">Alpa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($attendance->details->sortBy('student.name') as $i => $detail)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-3 text-gray-400 text-sm">{{ $i + 1 }}</td>
                                    <td class="px-5 py-3 text-gray-700 font-medium text-sm">{{ $detail->student->name }}</td>
                                    <td class="px-5 py-3 text-gray-400 text-xs">{{ $detail->student->nis }}</td>
                                    @foreach(['Hadir', 'Izin', 'Sakit', 'Alpa'] as $status)
                                        <td class="text-center px-3 py-3">
                                            <input type="radio"
                                                   name="statuses[{{ $detail->student_id }}]"
                                                   value="{{ $status }}"
                                                   {{ $existingDetails[$detail->student_id] === $status ? 'checked' : '' }}
                                                   class="w-4 h-4 accent-amber-500 cursor-pointer"
                                                   required>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-5 py-4 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('absensi.show', $attendance->id) }}"
                       class="px-4 py-2 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>

    </div>

    @push('scripts')
    <script>
        function fillAll(status) {
            document.querySelectorAll(`input[type="radio"][value="${status}"]`).forEach(r => r.checked = true);
        }
    </script>
    @endpush

</x-guru-layout>
