
<?php
require_once __DIR__ . '/../koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: index.php");
    exit;
}

// Mengambil data berdasarkan ID
$stmt = $pdo->prepare(
    "SELECT * FROM eskul WHERE id_eskul = ?"
);

$stmt->execute([$id]);

$eskul = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$eskul) {
    die("Data ekstrakurikuler tidak ditemukan.");
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nama_eskul = trim($_POST["nama_eskul"] ?? "");
    $pembina = trim($_POST["pembina"] ?? "");
    $hari = trim($_POST["hari"] ?? "");

    if ($nama_eskul === "" || $pembina === "" || $hari === "") {

        $error = "Semua data wajib diisi.";

    } else {

        try {
            $stmt = $pdo->prepare(
                "UPDATE eskul
                 SET nama_eskul = ?,
                     pembina = ?,
                     hari = ?
                 WHERE id_eskul = ?"
            );

            $stmt->execute([
                $nama_eskul,
                $pembina,
                $hari,
                $id
            ]);

            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            $error = "Gagal mengubah data: " . $e->getMessage();
        }
    }
}

$nama_eskul = $_POST['nama_eskul'] ?? $eskul['nama_eskul'];
$pembina = $_POST['pembina'] ?? $eskul['pembina'];
$hari = $_POST['hari'] ?? $eskul['hari'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ekstrakurikuler - SchoolCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-purple-50 min-h-screen p-5">

<div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded-3xl shadow-sm">

    <h1 class="text-2xl font-bold text-purple-800">
        Edit Ekstrakurikuler
    </h1>

    <p class="text-sm text-gray-400 mt-2 mb-7">
        Perbarui informasi kegiatan ekstrakurikuler.
    </p>

    <?php if ($error !== ""): ?>
        <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-5 text-sm">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-5">
            <label class="block text-sm font-semibold mb-2">
                Nama Ekstrakurikuler
            </label>

            <input type="text"
                   name="nama_eskul"
                   required
                   value="<?= htmlspecialchars($nama_eskul) ?>"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3">
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold mb-2">
                Guru Pembina
            </label>

            <input type="text"
                   name="pembina"
                   required
                   value="<?= htmlspecialchars($pembina) ?>"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3">
        </div>

        <div class="mb-7">
            <label class="block text-sm font-semibold mb-2">
                Hari Kegiatan
            </label>

            <select name="hari" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-3">

                <option value="">Pilih Hari</option>

                <?php
                $daftarHari = [
                    "Senin", "Selasa", "Rabu",
                    "Kamis", "Jumat", "Sabtu"
                ];

                foreach ($daftarHari as $h):
                ?>

                    <option value="<?= $h ?>"
                        <?= $hari === $h ? 'selected' : '' ?>>
                        <?= $h ?>
                    </option>

                <?php endforeach; ?>

            </select>
        </div>

        <div class="flex gap-3">

            <a href="index.php"
               class="flex-1 text-center bg-gray-100 text-gray-600 py-3 rounded-xl font-semibold">
                Kembali
            </a>

            <button type="submit"
                    class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-xl font-semibold">
                Update Data
            </button>

        </div>

    </form>

</div>

</body>
</html>
