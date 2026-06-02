<x-guru-layout>
    <x-slot name="title">Input Absensi</x-slot>

    <div class="p-5 lg:p-6 space-y-5">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('absensi.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-gray-900 font-semibold text-lg">Input Absensi</h1>
                <p class="text-gray-400 text-sm">Pilih kelas, mata pelajaran, dan tanggal terlebih dahulu</p>
            </div>
        </div>

        {{-- Step 1: Pilih Sesi --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="text-sm font-semibold text-gray-700 mb-4">1. Pilih Sesi Absensi</h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5" for="classroom_id">Kelas</label>
                    <select id="classroom_id"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classrooms as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5" for="subject_id">Mata Pelajaran</label>
                    <select id="subject_id"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5" for="date">Tanggal</label>
                    <input type="date" id="date"
                           value="{{ date('Y-m-d') }}"
                           max="{{ date('Y-m-d') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
                </div>
            </div>

            <button id="btn-load"
                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors disabled:opacity-50"
                    onclick="loadStudents()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Tampilkan Siswa
            </button>
        </div>

        {{-- Step 2: Daftar Siswa (hidden, muncul via JS) --}}
        <div id="attendance-section" class="hidden">

            {{-- Alert duplikat --}}
            <div id="alert-duplicate" class="hidden bg-amber-50 border border-amber-200 text-amber-700 text-sm rounded-lg px-4 py-3 mb-4">
                Absensi untuk sesi ini sudah pernah diinput.
                <a id="link-edit" href="#" class="font-semibold underline ml-1">Klik di sini untuk mengeditnya.</a>
            </div>

            <form id="form-absensi" method="POST" action="{{ route('absensi.store') }}">
                @csrf
                <input type="hidden" name="classroom_id" id="input_classroom">
                <input type="hidden" name="subject_id" id="input_subject">
                <input type="hidden" name="date" id="input_date">

                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                        <h2 class="text-sm font-semibold text-gray-700">2. Isi Status Kehadiran</h2>
                        {{-- Quick fill buttons --}}
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
                            <tbody id="student-list" class="divide-y divide-gray-50">
                                {{-- Diisi via JavaScript --}}
                            </tbody>
                        </table>
                    </div>

                    <div class="px-5 py-4 border-t border-gray-100 flex items-center justify-between">
                        <p id="summary-text" class="text-xs text-gray-400"></p>
                        <button type="submit" id="btn-submit"
                                class="inline-flex items-center gap-2 px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Absensi
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Loading state --}}
        <div id="loading-state" class="hidden flex items-center justify-center py-10">
            <svg class="animate-spin w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
            </svg>
            <span class="ml-2 text-sm text-gray-500">Memuat data siswa...</span>
        </div>

    </div>

    @push('scripts')
    <script>
        const STATUS_COLORS = {
            'Hadir': 'text-green-600',
            'Izin':  'text-blue-600',
            'Sakit': 'text-yellow-600',
            'Alpa':  'text-red-500',
        };

        function loadStudents() {
            const classroomId = document.getElementById('classroom_id').value;
            const subjectId   = document.getElementById('subject_id').value;
            const date        = document.getElementById('date').value;

            if (!classroomId || !subjectId || !date) {
                alert('Mohon pilih kelas, mata pelajaran, dan tanggal terlebih dahulu.');
                return;
            }

            document.getElementById('attendance-section').classList.add('hidden');
            document.getElementById('loading-state').classList.remove('hidden');

            const params = new URLSearchParams({ classroom_id: classroomId, subject_id: subjectId, date });

            fetch(`{{ route('absensi.students') }}?${params}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(r => r.json())
            .then(data => {
                document.getElementById('loading-state').classList.add('hidden');

                // Set hidden inputs
                document.getElementById('input_classroom').value = classroomId;
                document.getElementById('input_subject').value   = subjectId;
                document.getElementById('input_date').value      = date;

                // Duplikat alert
                if (data.existing_id) {
                    document.getElementById('alert-duplicate').classList.remove('hidden');
                    document.getElementById('link-edit').href = `/absensi/${data.existing_id}/edit`;
                } else {
                    document.getElementById('alert-duplicate').classList.add('hidden');
                }

                // Render siswa
                const tbody = document.getElementById('student-list');
                tbody.innerHTML = '';

                if (data.students.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7" class="text-center py-8 text-gray-400 text-sm">Tidak ada siswa di kelas ini.</td></tr>`;
                } else {
                    data.students.forEach((s, i) => {
                        const defaultStatus = data.existing_details[s.id] ?? 'Hadir';
                        tbody.innerHTML += renderRow(s, i + 1, defaultStatus);
                    });
                    updateSummary();
                }

                document.getElementById('attendance-section').classList.remove('hidden');
            })
            .catch(() => {
                document.getElementById('loading-state').classList.add('hidden');
                alert('Gagal memuat data siswa. Silakan coba lagi.');
            });
        }

        function renderRow(student, no, selectedStatus) {
            const statuses = ['Hadir', 'Izin', 'Sakit', 'Alpa'];
            const radios = statuses.map(s => `
                <td class="text-center px-3 py-3">
                    <input type="radio" name="statuses[${student.id}]"
                           value="${s}" ${selectedStatus === s ? 'checked' : ''}
                           onchange="updateSummary()"
                           class="w-4 h-4 accent-amber-500 cursor-pointer"
                           required>
                </td>
            `).join('');

            return `
                <tr class="hover:bg-gray-50 transition-colors" id="row-${student.id}">
                    <td class="px-5 py-3 text-gray-400 text-sm">${no}</td>
                    <td class="px-5 py-3 text-gray-700 font-medium text-sm">${student.name}</td>
                    <td class="px-5 py-3 text-gray-400 text-xs">${student.nis}</td>
                    ${radios}
                </tr>
            `;
        }

        function fillAll(status) {
            document.querySelectorAll(`input[type="radio"][value="${status}"]`).forEach(r => r.checked = true);
            updateSummary();
        }

        function updateSummary() {
            const counts = { Hadir: 0, Izin: 0, Sakit: 0, Alpa: 0 };
            document.querySelectorAll('input[type="radio"]:checked').forEach(r => {
                if (counts[r.value] !== undefined) counts[r.value]++;
            });
            const total = Object.values(counts).reduce((a, b) => a + b, 0);
            document.getElementById('summary-text').textContent =
                `${total} siswa — Hadir: ${counts.Hadir}, Izin: ${counts.Izin}, Sakit: ${counts.Sakit}, Alpa: ${counts.Alpa}`;
        }
    </script>
    @endpush

</x-guru-layout>
