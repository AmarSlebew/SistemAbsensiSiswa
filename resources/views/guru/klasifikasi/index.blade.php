<x-guru-layout>
    <x-slot name="title">Hasil Klasifikasi Kedisiplinan</x-slot>

    <div class="p-5 lg:p-6 space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-gray-900 font-semibold text-lg flex items-center gap-2">
                    <span class="px-2 py-0.5 bg-amber-100 text-amber-800 text-xs font-semibold rounded-md uppercase tracking-wider">Decision Tree</span>
                    Hasil Klasifikasi Kedisiplinan Siswa
                </h1>
                <p class="text-gray-400 text-sm">Analisis otomatis tingkat kedisiplinan berdasarkan riwayat kehadiran</p>
            </div>
        </div>

        {{-- Feedback Alert --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

        {{-- Jika Flask API offline/bermasalah --}}
        @if(!$flaskConnected)
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <h3 class="text-sm font-semibold text-amber-800">Koneksi Layanan ML Terputus</h3>
                    <p class="text-xs text-amber-700 mt-1 leading-relaxed">{{ $errorMessage }}</p>
                </div>
            </div>
        @endif

        {{-- Filter Panel --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <form method="GET" action="{{ route('klasifikasi.index') }}">
                <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-500 mb-1.5" for="classroom_id">Pilih Kelas untuk Klasifikasi</label>
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
                    <button type="submit"
                            class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">
                        Mulai Analisis
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabel Hasil --}}
        @if($selectedClassroom && $flaskConnected)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-gray-700 font-medium">Hasil Analisis Decision Tree</h2>
                </div>

                @if($classificationResults->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide w-8">#</th>
                                    <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Nama Siswa</th>
                                    <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">NIS</th>
                                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Persen Hadir</th>
                                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Jumlah Alpha</th>
                                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Alpha Berturut</th>
                                    <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Klasifikasi AI</th>
                                    <th class="text-left px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Confidence</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($classificationResults as $i => $row)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3 text-gray-400 text-sm">{{ $i + 1 }}</td>
                                        <td class="px-5 py-3 text-gray-700 font-medium text-sm">{{ $row->student_name }}</td>
                                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $row->nis }}</td>
                                        <td class="px-4 py-3 text-center text-gray-600 font-medium">{{ $row->percentage }}%</td>
                                        <td class="px-4 py-3 text-center text-red-500 font-semibold">{{ $row->alpa }}</td>
                                        <td class="px-4 py-3 text-center font-medium {{ $row->alpha_berturut >= 3 ? 'text-red-500' : 'text-gray-600' }}">
                                            {{ $row->alpha_berturut }} hari
                                        </td>
                                        <td class="px-5 py-3">
                                            @php
                                                $badge = match($row->result) {
                                                    'Sangat Disiplin' => 'bg-green-50 text-green-700 border-green-200',
                                                    'Disiplin'        => 'bg-blue-50 text-blue-700 border-blue-200',
                                                    'Kurang Disiplin' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                                    'Bermasalah'      => 'bg-red-50 text-red-700 border-red-200',
                                                    default => 'bg-gray-50 text-gray-500 border-gray-200',
                                                };
                                            @endphp
                                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full border {{ $badge }}">
                                                {{ $row->result }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3">
                                            <div class="flex items-center gap-2">
                                                <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                    <div class="h-full bg-amber-500 rounded-full" style="width: {{ $row->confidence }}%"></div>
                                                </div>
                                                <span class="text-xs text-gray-500 font-medium">{{ $row->confidence }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-16 text-center text-gray-400">
                        <p class="text-sm">Tidak ada data siswa ditemukan.</p>
                    </div>
                @endif
            </div>



        @elseif(!$selectedClassroom)
            {{-- Empty State --}}
            <div class="bg-white rounded-xl border border-gray-200 py-16 px-6 text-center text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                <p class="text-sm font-medium text-gray-500">Mulai Klasifikasi Cerdas</p>
                <p class="text-xs text-gray-400 mt-1">Pilih kelas di atas lalu klik "Mulai Analisis" untuk memproses data dengan Decision Tree.</p>
            </div>
        @endif

    </div>
</x-guru-layout>
