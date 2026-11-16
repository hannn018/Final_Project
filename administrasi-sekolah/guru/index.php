
<?php
require_once __DIR__ . '/../koneksi.php';

// Mengambil seluruh data guru
try {
    $stmt = $pdo->query(
        "SELECT * FROM guru ORDER BY id_guru DESC"
    );

    $dataGuru = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Gagal mengambil data guru: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru - SchoolCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#FAF7FC] text-gray-700">

<div class="min-h-screen md:flex">

    <!-- SIDEBAR -->
    <aside class="w-full md:w-64 bg-white border-r border-purple-100 p-6">

        <div class="flex items-center gap-3 mb-10">
            <div class="bg-purple-200 text-purple-700 w-12 h-12 rounded-2xl flex items-center justify-center text-2xl font-bold">
                S
            </div>

            <div>
                <h1 class="text-lg font-bold text-purple-800">SchoolCare</h1>
                <p class="text-xs text-gray-400">Sistem Administrasi</p>
            </div>
        </div>

        <p class="text-xs font-semibold text-gray-400 mb-4">
            MENU UTAMA
        </p>

        <nav class="space-y-2">

            <a href="../index.php"
               class="block p-3 rounded-xl hover:bg-pink-50">
                Dashboard
            </a>

            <a href="../siswa/index.php"
               class="block p-3 rounded-xl hover:bg-pink-50">
                Data Siswa
            </a>

            <a href="index.php"
               class="block p-3 rounded-xl bg-purple-50 text-purple-700 font-semibold">
                Data Guru
            </a>

            <a href="../mapel/index.php"
               class="block p-3 rounded-xl hover:bg-pink-50">
                Mata Pelajaran
            </a>

            <a href="../eskul/index.php"
               class="block p-3 rounded-xl hover:bg-pink-50">
                Ekstrakurikuler
            </a>

        </nav>

        <div class="mt-10 p-4 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl">
            <p class="font-semibold text-purple-800">
                Semangat belajar!
            </p>
            <p class="text-sm text-gray-500 mt-1">
                Kelola data sekolah dengan lebih mudah.
            </p>
        </div>

    </aside>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 p-5 md:p-8">

        <!-- HEADER -->
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

            <div>
                <p class="text-sm text-purple-500">Kelola Data</p>

                <h2 class="text-3xl font-bold text-gray-800 mt-1">
                    Data Guru
                </h2>

                <p class="text-gray-400 mt-2">
                    Daftar seluruh guru yang terdaftar dalam sekolah.
                </p>
            </div>

            <a href="tambah.php"
               class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-3 rounded-xl text-sm font-semibold text-center">
                + Tambah Guru
            </a>

        </header>

        <!-- TABEL DATA -->
        <section class="bg-white rounded-2xl border border-purple-100 shadow-sm overflow-hidden">

            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">
                    Daftar Guru
                </h3>

                <p class="text-sm text-gray-400 mt-1">
                    Total: <?= count($dataGuru) ?> Guru Terdaftar
                </p>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="bg-purple-50 text-purple-800">
                        <tr>
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">ID Guru</th>
                            <th class="px-6 py-4">Nama Guru</th>
                            <th class="px-6 py-4">Jenis Kelamin</th>
                            <th class="px-6 py-4">No. HP</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                    <?php if (count($dataGuru) > 0): ?>

                        <?php foreach ($dataGuru as $index => $guru): ?>

                            <tr class="hover:bg-purple-50/50">

                                <td class="px-6 py-4">
                                    <?= $index + 1 ?>
                                </td>

                                <td class="px-6 py-4">
                                    <?= htmlspecialchars($guru['id_guru']) ?>
                                </td>

                                <td class="px-6 py-4 font-semibold">
                                    <?= htmlspecialchars($guru['nama_guru']) ?>
                                </td>

                                <td class="px-6 py-4">
                                    <?= htmlspecialchars($guru['jenis_kelamin'] ?? '-') ?>
                                </td>

                                <td class="px-6 py-4">
                                    <?= htmlspecialchars($guru['no_hp'] ?? '-') ?>
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">

                                    <a href="edit.php?id=<?= $guru['id_guru'] ?>"
                                       class="inline-block bg-amber-100 text-amber-700 px-3 py-2 rounded-lg text-xs font-semibold">
                                        Edit
                                    </a>

                                    <form action="hapus.php" method="POST" class="inline-block"
                                          onsubmit="return confirm('Yakin ingin menghapus data guru ini?')">

                                        <input type="hidden" name="id"
                                               value="<?= $guru['id_guru'] ?>">

                                        <button type="submit"
                                                class="bg-pink-100 text-pink-700 px-3 py-2 rounded-lg text-xs font-semibold">
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                                Belum ada data guru.
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <div class="p-4 bg-gray-50 text-xs text-gray-400">
                SchoolCare - Sistem Administrasi Sekolah
            </div>

        </section>

    </main>

</div>

</body>
</html>
