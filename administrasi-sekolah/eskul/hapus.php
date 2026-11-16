
<?php
require_once __DIR__ . '/../koneksi.php';

// Memastikan permintaan menggunakan POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// Mengambil ID data
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: index.php");
    exit;
}

try {

    $stmt = $pdo->prepare(
        "DELETE FROM eskul WHERE id_eskul = ?"
    );

    $stmt->execute([$id]);

    header("Location: index.php");
    exit;

} catch (PDOException $e) {

    die("Gagal menghapus data ekstrakurikuler: " . $e->getMessage());

}
