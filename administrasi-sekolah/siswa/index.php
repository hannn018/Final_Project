<?php
require_once __DIR__ . '/../koneksi.php';

// Ambil semua data siswa dari database
try {
    $stmt = $pdo->query("SELECT * FROM siswa ORDER BY id_siswa DESC");
    $dataSiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Gagal mengambil data siswa: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - Administrasi Sekolah</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }
    </style>
</head>
<body class="bg-[#FAF7FC] text-gray-700">

<div class="min-h-screen md:flex">

    <!-- SIDEBAR NAVIGASI -->
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

        <p class="text-xs font-semibold text-gray-400 mb-4">MENU UTAMA</p>

        <nav class="space-y-2">
            <!-- Link ke Dashboard utama -->
            <a href="../index.php" class="flex items-center gap-3 p-3 rounded-xl hover:bg-pink-50 transition">
                <span>🏠</span> Dashboard
            </a>

            <!-- Menu Aktif: Data Siswa -->
            <a href="index.php" class="flex items-center gap-3 p-3 rounded-xl bg-purple-50 text-purple-700 font-semibold transition">
                <span>♙</span> Data Siswa
            </a>

            <!-- Link ke menu lain -->
            <a href="../guru/index.php" class="flex items-center gap-3 p-3 rounded-xl hover:bg-pink-50 transition">
                <span>♧</span> Data Guru
            </a>

            <a href="../mapel/index.php" class="flex items-center gap-3 p-3 rounded-xl hover:bg-pink-50 transition">
                <span>▤</span> Mata Pelajaran
            </a>

            <a href="../eskul/index.php" class="flex items-center gap-3 p-3 rounded-xl hover:bg-pink-50 transition">
                <span>☆</span> Ekstrakurikuler
            </a>
        </nav>

        <div class="mt-10 p-4 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl">
            <p class="font-semibold text-purple-800">Semangat belajar!</p>
            <p class="text-sm text-gray-500 mt-1">Kelola data sekolah dengan lebih mudah.</p>
        </div>

    </aside>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 p-5 md:p-8">

        <!-- HEADER HALAMAN -->
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <p class="text-sm text-purple-500">Kelola Data</p>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mt-1">Data Siswa</h2>
                <p class="text-gray-400 mt-2">Daftar seluruh siswa yang terdaftar dalam sistem.</p>
            </div>

            <!-- Tombol Tambah Data Siswa -->
            <a href="tambah.php" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold text-center transition flex items-center justify-center gap-2 shadow-sm">
                <span>+</span> Tambah Siswa Baru
            </a>
        </header>

        <!-- TABEL DATA SISWA -->
        <section class="bg-white rounded-2xl border border-purple-100 shadow-sm overflow-hidden">

            <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Daftar Siswa</h3>
                    <p class="text-sm text-gray-400 mt-1">Total: <?= count($dataSiswa) ?> Siswa Terdaftar</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-purple-50 text-purple-800">
                        <tr>
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">NIS</th>
                            <th class="px-6 py-4">Nama Siswa</th>
                            <th class="px-6 py-4">Jenis Kelamin</th>
                            <th class="px-6 py-4">Kelas</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                    <?php if (count($dataSiswa) > 0): ?>
                        <?php foreach ($dataSiswa as $index => $siswa): ?>
                            <tr class="hover:bg-purple-50/50 transition">
                                <td class="px-6 py-4"><?= $index + 1 ?></td>
                                <td class="px-6 py-4 font-medium"><?= htmlspecialchars($siswa['nis']) ?></td>
                                <td class="px-6 py-4 font-semibold text-gray-700"><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($siswa['jenis_kelamin'] ?? '-') ?></td>
                                <td class="px-6 py-4">
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        <?= htmlspecialchars($siswa['kelas']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center space-x-2">
                                    <a href="edit.php?id=<?= $siswa['id_siswa'] ?>" class="inline-block bg-amber-100 hover:bg-amber-200 text-amber-700 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                        Edit
                                    </a>
                                    <a href="hapus.php?id=<?= $siswa['id_siswa'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')" class="inline-block bg-pink-100 hover:bg-pink-200 text-pink-700 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                                Belum ada data siswa terdaftar.
                            </td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>

            <div class="p-4 bg-gray-50 text-xs text-gray-400">
                Sistem Administrasi Sekolah · PHP Native & MySQL
            </div>

        </section>

        <footer class="text-center text-xs text-gray-400 mt-8">
            Dibuat untuk mempermudah pengelolaan data sekolah.
        </footer>

    </main>

</div>

</body>
</html>