import numpy as np
from model import build_model, LABELS

# Cache model agar tidak dilatih ulang terus-menerus setiap kali fungsi dipanggil
_trained_model = None

def get_model():
    global _trained_model
    if _trained_model is None:
        _trained_model = build_model()
    return _trained_model


def hitung_fitur(data_absensi: list) -> dict:
    """
    Hitung semua fitur dari list data absensi.

    data_absensi: list of dict, contoh:
    [
      {"status": "Hadir"},
      {"status": "Alpa"},
      {"status": "Sakit"},
      ...
    ]
    """

    total_pertemuan = len(data_absensi)
    if total_pertemuan == 0:
        return None

    # Normalisasi status absensi ke lowercase untuk dicocokkan
    # Dan ubah 'alpa' (DB Laravel) menjadi 'alpha' (agar sinkron dengan aturan model)
    normalized_statuses = []
    for a in data_absensi:
        status_raw = str(a.get('status', '')).lower().strip()
        if status_raw == 'alpa':
            status_raw = 'alpha'
        normalized_statuses.append(status_raw)

    # Hitung tiap status
    hadir  = sum(1 for s in normalized_statuses if s == 'hadir')
    alpha  = sum(1 for s in normalized_statuses if s == 'alpha')
    sakit  = sum(1 for s in normalized_statuses if s == 'sakit')
    izin   = sum(1 for s in normalized_statuses if s == 'izin')

    # Persentase kehadiran
    persen_hadir = round((hadir / total_pertemuan) * 100, 2)

    # Hitung alpha berturut-turut terpanjang
    alpha_berturut = 0
    current_streak = 0
    for s in normalized_statuses:
        if s == 'alpha':
            current_streak += 1
            alpha_berturut = max(alpha_berturut, current_streak)
        else:
            current_streak = 0

    return {
        'total_pertemuan': total_pertemuan,
        'hadir':           hadir,
        'alpha':           alpha,
        'sakit':           sakit,
        'izin':            izin,
        'persen_hadir':    persen_hadir,
        'alpha_berturut':  alpha_berturut,
    }


def prediksi(data_absensi: list) -> dict:
    """
    Prediksi tingkat kedisiplinan dari data absensi.
    Return dict berisi label, confidence, dan fitur.
    """

    fitur = hitung_fitur(data_absensi)
    if fitur is None:
        return {
            'label':      'Tidak Diketahui',
            'confidence': 0,
            'fitur':      {}
        }

    # Siapkan input untuk model
    X = np.array([[
        fitur['persen_hadir'],
        fitur['alpha'],
        fitur['alpha_berturut'],
    ]])

    # Ambil singleton model
    model = get_model()

    label_idx   = model.predict(X)[0]
    proba       = model.predict_proba(X)[0]
    confidence  = round(float(proba[label_idx]) * 100, 2)
    label       = LABELS[label_idx]

    return {
        'label':      label,
        'confidence': confidence,
        'fitur':      fitur
    }