import numpy as np
from sklearn.tree import DecisionTreeClassifier

def build_model():
    """
    Buat dan train Decision Tree dengan data aturan manual.
    Karena data awal mungkin sedikit, kita gunakan rule-based
    training data yang mencerminkan logika bisnis sekolah.
    """

    # Training data berdasarkan aturan kedisiplinan sekolah
    # Fitur: [persen_hadir, jumlah_alpha, alpha_berturut]
    X_train = np.array([
        # Sangat Disiplin: hadir >= 90%, alpha <= 1
        [95, 0, 0],
        [92, 1, 0],
        [90, 1, 1],
        [96, 0, 0],
        [93, 1, 0],

        # Disiplin: hadir 75-89%, alpha <= 3
        [85, 2, 1],
        [80, 3, 1],
        [78, 2, 0],
        [82, 3, 2],
        [76, 2, 1],

        # Kurang Disiplin: hadir 60-74%, alpha 4-7
        [70, 5, 2],
        [65, 6, 3],
        [72, 4, 2],
        [68, 7, 3],
        [63, 5, 2],

        # Bermasalah: hadir < 60% atau alpha >= 8
        [55, 9, 4],
        [40, 12, 5],
        [50, 8, 4],
        [35, 15, 6],
        [58, 10, 5],
    ])

    # Label: 0=Sangat Disiplin, 1=Disiplin, 2=Kurang Disiplin, 3=Bermasalah
    y_train = np.array([
        0, 0, 0, 0, 0,  # Sangat Disiplin
        1, 1, 1, 1, 1,  # Disiplin
        2, 2, 2, 2, 2,  # Kurang Disiplin
        3, 3, 3, 3, 3,  # Bermasalah
    ])

    # Buat dan train model
    model = DecisionTreeClassifier(
        max_depth=5,
        min_samples_split=2,
        random_state=42
    )
    model.fit(X_train, y_train)

    return model

# Label mapping
LABELS = {
    0: 'Sangat Disiplin',
    1: 'Disiplin',
    2: 'Kurang Disiplin',
    3: 'Bermasalah'
}

# Warna untuk setiap label
LABEL_COLORS = {
    'Sangat Disiplin': '#16A34A',
    'Disiplin':        '#2563EB',
    'Kurang Disiplin': '#CA8A04',
    'Bermasalah':      '#DC2626'
}