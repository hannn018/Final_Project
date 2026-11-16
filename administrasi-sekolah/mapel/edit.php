
<?php
require_once __DIR__ . '/../koneksi.php';

$error = "";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    die("ID mata pelajaran tidak valid.");
}

// Mengambil data mata pelajaran
$stmt = $pdo->prepare("
    SELECT * FROM mata_pelajaran
    WHERE id_mapel = ?
");

$stmt->execute([$id]);

$mapel = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mapel) {
    die("Data mata pelajaran tidak ditemukan.");
}

// Mengambil daftar guru
$stmtGuru = $pdo->query("
    SELECT id_guru, nama_guru
    FROM guru
    ORDER BY nama_guru ASC
");

$dataGuru = $stmtGuru->fetchAll(PDO::FETCH_ASSOC);

// Memproses perubahan data
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nama_mapel = trim($_POST["nama_mapel"] ?? "");
    $id_guru = $_POST["id_guru"] ?? "";

    if ($nama_mapel === "" || $id_guru === "") {

        $error = "Semua data wajib diisi.";

    } else {

        $cekGuru = $pdo->prepare("
            SELECT id_guru FROM guru WHERE id_guru = ?
        ");

        $cekGuru->execute([$id_guru]);

        if (!$cekGuru->fetch()) {

            $error = "Guru yang dipilih tidak ditemukan.";

        } else {

            try {

                $stmt = $pdo->prepare("
                    UPDATE mata_pelajaran
                    SET nama_mapel = ?, id_guru = ?
                    WHERE id_mapel = ?
                ");

                $stmt->execute([
                    $nama_mapel,
                    $id_guru,
                    $id
                ]);

                header("Location: index.php");
                exit;

            } catch (PDOException $e) {

                $error = "Gagal memperbarui data mata pelajaran.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Pelajaran - SchoolCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#FAF7FC] min-h-screen flex items-center justify-center p-5">

<div class="bg-white w-full max-w-xl p-8 rounded-3xl shadow-sm border border-purple-100">

    <h1 class="text-2xl font-bold text-purple-800">
        Edit Mata Pelajaran
    </h1>

    <p class="text-gray-400 text-sm mt-2 mb-7">
        Perbarui informasi mata pelajaran.
    </p>

    <?php if ($error !== ""): ?>

        <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-5 text-sm">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="mb-5">

            <label class="block text-sm font-semibold mb-2">
                Nama Mata Pelajaran
            </label>

            <input
                type="text"
                name="nama_mapel"
                required
                maxlength="100"
                value="<?= htmlspecialchars($_POST['nama_mapel'] ?? $mapel['nama_mapel']) ?>"
                class="w-full border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-purple-300"
            >

        </div>

        <div class="mb-7">

            <label class="block text-sm font-semibold mb-2">
                Guru Pengajar
            </label>

            <select
                name="id_guru"
                required
                class="w-full border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-purple-300"
            >

                <option value="">-- Pilih Guru --</option>

                <?php foreach ($dataGuru as $guru): ?>

                    <option
                        value="<?= $guru['id_guru'] ?>"
                        <?= (($_POST['id_guru'] ?? $mapel['id_guru']) == $guru['id_guru']) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($guru['nama_guru']) ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="flex gap-3">

            <a href="index.php"
               class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold py-3 rounded-xl">
                Kembali
            </a>

            <button
                type="submit"
                class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-xl"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

</body>
</html>
