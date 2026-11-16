
<?php
require_once __DIR__ . '/../koneksi.php';

// Mengambil ID mata pelajaran
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    die("ID mata pelajaran tidak valid.");
}

try {

    // Memastikan data tersedia
    $cek = $pdo->prepare("
        SELECT id_mapel
        FROM mata_pelajaran
        WHERE id_mapel = ?
    ");

    $cek->execute([$id]);

    if (!$cek->fetch()) {
        die("Data mata pelajaran tidak ditemukan.");
    }

    // Menghapus data
    $stmt = $pdo->prepare("
        DELETE FROM mata_pelajaran
        WHERE id_mapel = ?
    ");

    $stmt->execute([$id]);

    header("Location: index.php");
    exit;

} catch (PDOException $e) {

    die("Gagal menghapus data mata pelajaran. Periksa relasi database terlebih dahulu.");
}
?>
