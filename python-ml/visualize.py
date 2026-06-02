import os
import matplotlib
matplotlib.use('Agg')  # Penting! Supaya tidak butuh display
import matplotlib.pyplot as plt
from sklearn.tree import plot_tree
from model import build_model, LABELS

def generate_tree_image(output_path: str = None) -> str:
    """
    Generate gambar pohon keputusan dan simpan sebagai PNG.
    Return path file gambar.
    """

    if output_path is None:
        # Simpan ke folder public Laravel
        output_path = os.path.join(
            os.path.dirname(__file__),
            '..', 'public', 'images', 'decision_tree.png'
        )

    # Pastikan folder ada
    os.makedirs(os.path.dirname(output_path), exist_ok=True)

    model = build_model()

    fig, ax = plt.subplots(figsize=(20, 10))
    plot_tree(
        model,
        feature_names=['% Kehadiran', 'Jumlah Alpha', 'Alpha Berturut'],
        class_names=list(LABELS.values()),
        filled=True,
        rounded=True,
        fontsize=10,
        ax=ax
    )

    plt.title('Pohon Keputusan Kedisiplinan Siswa', fontsize=14, pad=20)
    plt.tight_layout()
    plt.savefig(output_path, dpi=150, bbox_inches='tight',
                facecolor='white', edgecolor='none')
    plt.close()

    return output_path