
<?php
require_once __DIR__ . '/../koneksi.php';

// Mengambil ID guru dari URL
$id = $_GET['id'] ?? '';

if (!ctype_digit((string)$id) || (int)$id < 1) {
    die("ID guru tidak valid.");
}

// Mengambil data guru berdasarkan ID
$stmt = $pdo->prepare(
    "SELECT * FROM guru WHERE id_guru = ?"
);
$stmt->execute([$id]);

$guru = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$guru) {
    die("Data guru tidak ditemukan.");
}

$error = "";

// Proses perubahan data
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nama = trim($_POST["nama_guru"] ?? "");
    $jenisKelamin = $_POST["jenis_kelamin"] ?? "";
    $noHp = trim($_POST["no_hp"] ?? "");

    if ($nama === "" || $jenisKelamin === "") {

        $error = "Nama dan jenis kelamin wajib diisi.";

    } elseif (!in_array($jenisKelamin, ["Laki-laki", "Perempuan"], true)) {

        $error = "Jenis kelamin tidak valid.";

    } else {

        try {

            $stmt = $pdo->prepare(
                "UPDATE guru
                 SET nama_guru = ?,
                     jenis_kelamin = ?,
                     no_hp = ?
                 WHERE id_guru = ?"
            );

            $stmt->execute([
                $nama,
                $jenisKelamin,
                $noHp,
                $id
            ]);

            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            $error = "Gagal mengubah data: " . $e->getMessage();
        }
    }

    // Menampilkan kembali input terakhir jika ada error
    $guru['nama_guru'] = $nama;
    $guru['jenis_kelamin'] = $jenisKelamin;
    $guru['no_hp'] = $noHp;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guru - SchoolCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-purple-50 min-h-screen p-5">

<div class="max-w-xl mx-auto bg-white rounded-3xl shadow-sm p-8">

    <h1 class="text-2xl font-bold text-purple-800">
        Edit Data Guru
    </h1>

    <p class="text-gray-400 text-sm mt-2 mb-7">
        Perbarui informasi guru yang sudah terdaftar.
    </p>

    <?php if ($error !== ""): ?>
        <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-5 text-sm">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-5">
            <label class="block text-sm font-semibold mb-2">
                ID Guru
            </label>

            <input type="text"
                   value="<?= htmlspecialchars($guru['id_guru']) ?>"
                   readonly
                   class="w-full border bg-gray-100 rounded-xl px-4 py-3">
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold mb-2">
                Nama Guru
            </label>

            <input type="text"
                   name="nama_guru"
                   maxlength="100"
                   required
                   value="<?= htmlspecialchars($guru['nama_guru']) ?>"
                   class="w-full border rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-purple-300">
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold mb-2">
                Jenis Kelamin
            </label>

            <select name="jenis_kelamin"
                    required
                    class="w-full border rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-purple-300">

                <option value="Laki-laki"
                    <?= $guru['jenis_kelamin'] === 'Laki-laki' ? 'selected' : '' ?>>
                    Laki-laki
                </option>

                <option value="Perempuan"
                    <?= $guru['jenis_kelamin'] === 'Perempuan' ? 'selected' : '' ?>>
                    Perempuan
                </option>

            </select>
        </div>

        <div class="mb-7">
            <label class="block text-sm font-semibold mb-2">
                Nomor HP
            </label>

            <input type="tel"
                   name="no_hp"
                   maxlength="15"
                   value="<?= htmlspecialchars($guru['no_hp'] ?? '') ?>"
                   class="w-full border rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-purple-300">
        </div>

        <div class="flex gap-3">

            <a href="index.php"
               class="flex-1 text-center bg-gray-100 hover:bg-gray-200 py-3 rounded-xl font-semibold">
                Kembali
            </a>

            <button type="submit"
                    class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-xl font-semibold">
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

</body>
</html>
