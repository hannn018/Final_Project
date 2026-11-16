
<?php
require_once __DIR__ . '/../koneksi.php';

$error = "";

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
                "INSERT INTO guru (nama_guru, jenis_kelamin, no_hp)
                 VALUES (?, ?, ?)"
            );

            $stmt->execute([
                $nama,
                $jenisKelamin,
                $noHp
            ]);

            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            $error = "Gagal menambahkan guru: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Guru - SchoolCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-purple-50 min-h-screen p-5">

<div class="max-w-xl mx-auto bg-white rounded-3xl shadow-sm p-8">

    <h1 class="text-2xl font-bold text-purple-800">
        Tambah Data Guru
    </h1>

    <p class="text-gray-400 text-sm mt-2 mb-7">
        Masukkan informasi guru yang akan didaftarkan.
    </p>

    <?php if ($error !== ""): ?>
        <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-5 text-sm">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-5">
            <label class="block text-sm font-semibold mb-2">
                Nama Guru
            </label>

            <input type="text"
                   name="nama_guru"
                   required
                   maxlength="100"
                   value="<?= htmlspecialchars($_POST['nama_guru'] ?? '') ?>"
                   placeholder="Masukkan nama guru"
                   class="w-full border rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-purple-300">
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold mb-2">
                Jenis Kelamin
            </label>

            <select name="jenis_kelamin"
                    required
                    class="w-full border rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-purple-300">

                <option value="">Pilih jenis kelamin</option>

                <option value="Laki-laki"
                    <?= ($_POST['jenis_kelamin'] ?? '') === 'Laki-laki' ? 'selected' : '' ?>>
                    Laki-laki
                </option>

                <option value="Perempuan"
                    <?= ($_POST['jenis_kelamin'] ?? '') === 'Perempuan' ? 'selected' : '' ?>>
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
                   value="<?= htmlspecialchars($_POST['no_hp'] ?? '') ?>"
                   placeholder="Masukkan nomor HP"
                   class="w-full border rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-purple-300">
        </div>

        <div class="flex gap-3">

            <a href="index.php"
               class="flex-1 text-center bg-gray-100 hover:bg-gray-200 py-3 rounded-xl font-semibold">
                Kembali
            </a>

            <button type="submit"
                    class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-xl font-semibold">
                Simpan Data
            </button>

        </div>

    </form>

</div>

</body>
</html>
