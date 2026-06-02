# pyrefly: ignore [missing-import]
from flask import Flask, request, jsonify
from predict import prediksi
from visualize import generate_tree_image
import os

app = Flask(__name__)


@app.route('/health', methods=['GET'])
def health():
    """Cek apakah service jalan."""
    return jsonify({'status': 'ok', 'message': 'Python ML service is running'})


@app.route('/api/analyze', methods=['POST'])
def analyze():
    """
    Terima data absensi, return hasil klasifikasi.

    Request body:
    {
      "student_id": 1,
      "attendances": [
        {"status": "hadir"},
        {"status": "alpha"},
        ...
      ]
    }
    """
    try:
        data = request.get_json()

        if not data:
            return jsonify({'error': 'No data provided'}), 400

        student_id  = data.get('student_id')
        attendances = data.get('attendances', [])

        if not attendances:
            return jsonify({'error': 'No attendance data'}), 400

        # Jalankan prediksi
        hasil = prediksi(attendances)

        return jsonify({
            'student_id': student_id,
            'label':      hasil['label'],
            'confidence': hasil['confidence'],
            'fitur':      hasil['fitur'],
            'success':    True
        })

    except Exception as e:
        return jsonify({'error': str(e), 'success': False}), 500


@app.route('/api/analyze-batch', methods=['POST'])
def analyze_batch():
    """
    Terima daftar siswa dan data absensi mereka masing-masing, return hasil klasifikasi massal.

    Request body:
    {
      "students": [
        {
          "student_id": 1,
          "attendances": [{"status": "Hadir"}, {"status": "Alpa"}]
        },
        ...
      ]
    }
    """
    try:
        data = request.get_json()
        if not data or 'students' not in data:
            return jsonify({'error': 'Payload must contain "students" list'}), 400

        students_list = data['students']
        results = []

        for item in students_list:
            student_id = item.get('student_id')
            attendances = item.get('attendances', [])
            
            # Jika absen kosong, dilewati atau return default
            if not attendances:
                results.append({
                    'student_id': student_id,
                    'label': 'Tidak Diketahui',
                    'confidence': 0,
                    'fitur': {},
                    'success': False,
                    'message': 'No attendance data'
                })
                continue
                
            hasil = prediksi(attendances)
            results.append({
                'student_id': student_id,
                'label':      hasil['label'],
                'confidence': hasil['confidence'],
                'fitur':      hasil['fitur'],
                'success':    True
            })

        return jsonify({
            'success': True,
            'results': results
        })

    except Exception as e:
        return jsonify({'error': str(e), 'success': False}), 500



@app.route('/api/tree-image', methods=['GET'])
def tree_image():
    """Generate & return path gambar pohon keputusan."""
    try:
        path = generate_tree_image()
        return jsonify({
            'success': True,
            'path':    '/images/decision_tree.png',
            'message': 'Tree image generated successfully'
        })
    except Exception as e:
        return jsonify({'error': str(e), 'success': False}), 500


if __name__ == '__main__':
    app.run(debug=True, port=5000)