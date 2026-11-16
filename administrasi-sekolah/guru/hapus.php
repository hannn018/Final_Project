
<?php
require_once __DIR__ . '/../koneksi.php';

// Mengambil ID dari form
$id = $_POST['id'] ?? '';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

if (!ctype_digit((string)$id) || (int)$id < 1) {
    die("ID guru tidak valid.");
}

try {

    // Menghapus data guru
    $stmt = $pdo->prepare(
        "DELETE FROM guru WHERE id_guru = ?"
    );

    $stmt->execute([$id]);

    header("Location: index.php");
    exit;

} catch (PDOException $e) {

    die("Gagal menghapus data guru. Pastikan guru tidak sedang digunakan pada data mata pelajaran.");

}
