<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ClassificationController extends Controller
{
    private function getTeacher()
    {
        return Auth::user()->teacher;
    }

    public function index(Request $request)
    {
        $teacher = $this->getTeacher();

        // 1. Ambil daftar kelas
        $classrooms = Classroom::whereHas('attendances', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->orderBy('name')->get();

        if ($classrooms->isEmpty()) {
            $classrooms = Classroom::orderBy('name')->get();
        }

        $selectedClassroom = $request->input('classroom_id');
        $classificationResults = collect();
        $flaskConnected = true;
        $errorMessage = '';

        // 2. Jika kelas dipilih, ambil data absensi & klasifikasikan lewat Flask API
        if ($selectedClassroom) {
            $students = Student::where('classroom_id', $selectedClassroom)
                ->orderBy('name')
                ->get();

            $studentData = [];
            foreach ($students as $student) {
                // Ambil daftar status absensi historis dari siswa ini
                $attendances = DB::table('attendance_details')
                    ->join('attendances', 'attendance_details.attendance_id', '=', 'attendances.id')
                    ->where('attendance_details.student_id', $student->id)
                    ->where('attendances.teacher_id', $teacher->id)
                    ->select('attendance_details.status')
                    ->get()
                    ->map(function ($detail) {
                        return ['status' => $detail->status];
                    })
                    ->toArray();

                $studentData[] = [
                    'student_id'   => $student->id,
                    'student_name' => $student->name,
                    'nis'          => $student->nis,
                    'attendances'  => $attendances,
                ];
            }

            // Kirim request ke Flask API
            try {
                $response = Http::timeout(10)->post('http://127.0.0.1:5000/api/analyze-batch', [
                    'students' => $studentData
                ]);

                if ($response->successful()) {
                    $predictions = collect($response->json()['results'] ?? []);
                    
                    // Gabungkan hasil prediksi dengan data siswa
                    foreach ($studentData as $data) {
                        $pred = $predictions->firstWhere('student_id', $data['student_id']);
                        
                        $fitur = $pred['fitur'] ?? [];
                        
                        $classificationResults->push((object)[
                            'student_name' => $data['student_name'],
                            'nis'          => $data['nis'],
                            'hadir'        => $fitur['hadir'] ?? 0,
                            'izin'         => $fitur['izin'] ?? 0,
                            'sakit'        => $fitur['sakit'] ?? 0,
                            'alpa'         => $fitur['alpha'] ?? 0,
                            'alpha_berturut' => $fitur['alpha_berturut'] ?? 0,
                            'total_sesi'   => $fitur['total_pertemuan'] ?? 0,
                            'percentage'   => $fitur['persen_hadir'] ?? 0,
                            'result'       => $pred['label'] ?? 'Belum Diklasifikasi',
                            'confidence'   => $pred['confidence'] ?? 0
                        ]);
                    }
                } else {
                    $flaskConnected = false;
                    $errorMessage = $response->json()['error'] ?? 'Flask API mengembalikan error.';
                }
            } catch (\Exception $e) {
                $flaskConnected = false;
                $errorMessage = 'Gagal terhubung ke service Machine Learning (Flask Server). Pastikan python-ml server sudah dijalankan di port 5000.';
            }
        }

        return view('guru.klasifikasi.index', compact(
            'classrooms',
            'classificationResults',
            'selectedClassroom',
            'flaskConnected',
            'errorMessage'
        ));
    }

    /**
     * Memanggil endpoint Flask /api/tree-image untuk men-generate gambar pohon keputusan terbaru
     */
    public function train()
    {
        try {
            $response = Http::timeout(15)->get('http://127.0.0.1:5000/api/tree-image');
            if ($response->successful()) {
                return back()->with('success', 'Model Decision Tree berhasil divisualisasi ulang! Gambar pohon keputusan telah diperbarui.');
            }
            return back()->with('error', 'Gagal memproses visualisasi model: ' . ($response->json()['error'] ?? 'Error tidak dikenal'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghubungi server ML: ' . $e->getMessage());
        }
    }
}
