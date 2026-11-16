
<?php
session_start();

// =====================================
// CEK LOGIN DAN ROLE PENGGUNA
// =====================================

// Jika belum login, arahkan ke halaman login
if (!isset($_SESSION['id_user'])) {
    header("Location: login/index.php");
    exit;
}

// Jika login sebagai guru
if ($_SESSION['role'] === 'guru') {
    header("Location: dashboard_guru/index.php");
    exit;
}

// Jika bukan admin, tolak akses
if ($_SESSION['role'] !== 'admin') {
    header("Location: login/index.php");
    exit;
}

// =====================================
// KONEKSI DATABASE
// =====================================

require_once __DIR__ . '/koneksi.php';

// =====================================
// MENGAMBIL DATA STATISTIK
// =====================================

// Total siswa
$totalSiswa = $pdo->query(
    "SELECT COUNT(*) FROM siswa"
)->fetchColumn();

// Total guru
$totalGuru = $pdo->query(
    "SELECT COUNT(*) FROM guru"
)->fetchColumn();

// Total mata pelajaran
$totalMapel = $pdo->query(
    "SELECT COUNT(*) FROM mata_pelajaran"
)->fetchColumn();

// Total ekstrakurikuler
$totalEskul = $pdo->query(
    "SELECT COUNT(*) FROM eskul"
)->fetchColumn();

// =====================================
// MENGAMBIL 5 SISWA TERBARU
// =====================================

$dataSiswa = $pdo->query(
    "SELECT * FROM siswa ORDER BY id_siswa DESC LIMIT 5"
)->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Sekolah - SchoolCare</title>

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

    <!-- SIDEBAR -->
    <aside class="w-full md:w-64 bg-white border-r border-purple-100 p-6">

        <!-- LOGO -->
        <div class="flex items-center gap-3 mb-10">

            <div class="bg-purple-200 text-purple-700
                        w-12 h-12 rounded-2xl flex items-center
                        justify-center text-2xl">
                S
            </div>

            <div>
                <h1 class="text-lg font-bold text-purple-800">
                    SchoolCare
                </h1>

                <p class="text-xs text-gray-400">
                    Sistem Administrasi
                </p>
            </div>

        </div>

        <p class="text-xs font-semibold text-gray-400 mb-4">
            MENU UTAMA
        </p>

        <!-- NAVIGASI -->
        <nav class="space-y-2">

            <a href="index.php"
               class="flex items-center gap-3 p-3 rounded-xl
                      bg-purple-50 text-purple-700 font-semibold transition">
                <span>🏠</span>
                Dashboard
            </a>

            <a href="siswa/index.php"
               class="flex items-center gap-3 p-3 rounded-xl
                      hover:bg-pink-50 transition">
                <span>♙</span>
                Data Siswa
            </a>

            <a href="guru/index.php"
               class="flex items-center gap-3 p-3 rounded-xl
                      hover:bg-pink-50 transition">
                <span>♧</span>
                Data Guru
            </a>

            <a href="mapel/index.php"
               class="flex items-center gap-3 p-3 rounded-xl
                      hover:bg-pink-50 transition">
                <span>▤</span>
                Mata Pelajaran
            </a>

            <a href="eskul/index.php"
               class="flex items-center gap-3 p-3 rounded-xl
                      hover:bg-pink-50 transition">
                <span>☆</span>
                Ekstrakurikuler
            </a>

        </nav>

        <!-- INFORMASI SIDEBAR -->
        <div class="mt-10 p-4 bg-gradient-to-br
                    from-purple-100 to-pink-100 rounded-2xl">

            <p class="font-semibold text-purple-800">
                Semangat belajar!
            </p>

            <p class="text-sm text-gray-500 mt-1">
                Kelola data sekolah dengan lebih mudah.
            </p>

        </div>

        <!-- INFORMASI AKUN -->
        <div class="mt-8 border-t border-gray-100 pt-5">

            <p class="text-xs text-gray-400">
                Login sebagai
            </p>

            <p class="font-semibold text-purple-700 mt-1">
                <?= htmlspecialchars($_SESSION['nama']) ?>
            </p>

            <p class="text-xs text-gray-400">
                Administrator
            </p>

            <a href="logout.php"
               onclick="return confirm('Apakah Anda yakin ingin keluar?')"
               class="block mt-4 text-sm text-pink-600
                      hover:text-pink-800 font-semibold">
                Keluar dari akun
            </a>

        </div>

    </aside>


    <!-- KONTEN UTAMA -->
    <main class="flex-1 p-5 md:p-8">

        <!-- HEADER -->
        <header class="flex flex-col sm:flex-row
                       sm:items-center sm:justify-between
                       gap-4 mb-8">

            <div>

                <p class="text-sm text-purple-500">
                    Halaman Utama
                </p>

                <h2 class="text-2xl md:text-3xl font-bold
                           text-gray-800 mt-1">
                    Dashboard Sekolah
                </h2>

                <p class="text-gray-400 mt-2">
                    Selamat datang di sistem administrasi sekolah.
                </p>

            </div>

            <div class="bg-white rounded-2xl px-4 py-3
                        border border-purple-100 shadow-sm">

                <p class="text-sm text-gray-400">
                    Sistem Informasi
                </p>

                <p class="font-semibold text-purple-700">
                    Administrasi Sekolah
                </p>

            </div>

        </header>


        <!-- KARTU STATISTIK -->
        <section class="grid grid-cols-1 sm:grid-cols-2
                        xl:grid-cols-4 gap-5 mb-8">

            <!-- TOTAL SISWA -->
            <div class="bg-white p-6 rounded-2xl
                        border border-purple-100 shadow-sm">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="text-gray-400 text-sm">
                            Total Siswa
                        </p>

                        <h3 class="text-3xl font-bold
                                   text-purple-700 mt-2">
                            <?= $totalSiswa ?>
                        </h3>
                    </div>

                    <div class="w-12 h-12 rounded-2xl
                                bg-purple-100 flex items-center
                                justify-center text-2xl">
                        ♙
                    </div>

                </div>

                <p class="text-xs text-gray-400 mt-4">
                    Data siswa terdaftar
                </p>

            </div>


            <!-- TOTAL GURU -->
            <div class="bg-white p-6 rounded-2xl
                        border border-pink-100 shadow-sm">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="text-gray-400 text-sm">
                            Total Guru
                        </p>

                        <h3 class="text-3xl font-bold
                                   text-pink-600 mt-2">
                            <?= $totalGuru ?>
                        </h3>
                    </div>

                    <div class="w-12 h-12 rounded-2xl
                                bg-pink-100 flex items-center
                                justify-center text-2xl">
                        ♧
                    </div>

                </div>

                <p class="text-xs text-gray-400 mt-4">
                    Data pengajar
                </p>

            </div>


            <!-- TOTAL MAPEL -->
            <div class="bg-white p-6 rounded-2xl
                        border border-blue-100 shadow-sm">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="text-gray-400 text-sm">
                            Mata Pelajaran
                        </p>

                        <h3 class="text-3xl font-bold
                                   text-blue-600 mt-2">
                            <?= $totalMapel ?>
                        </h3>
                    </div>

                    <div class="w-12 h-12 rounded-2xl
                                bg-blue-100 flex items-center
                                justify-center text-2xl">
                        ▤
                    </div>

                </div>

                <p class="text-xs text-gray-400 mt-4">
                    Pelajaran terdaftar
                </p>

            </div>


            <!-- TOTAL ESKUL -->
            <div class="bg-white p-6 rounded-2xl
                        border border-amber-100 shadow-sm">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="text-gray-400 text-sm">
                            Ekstrakurikuler
                        </p>

                        <h3 class="text-3xl font-bold
                                   text-amber-600 mt-2">
                            <?= $totalEskul ?>
                        </h3>
                    </div>

                    <div class="w-12 h-12 rounded-2xl
                                bg-amber-100 flex items-center
                                justify-center text-2xl">
                        ☆
                    </div>

                </div>

                <p class="text-xs text-gray-400 mt-4">
                    Kegiatan sekolah
                </p>

            </div>

        </section>


        <!-- TABEL SISWA -->
        <section class="bg-white rounded-2xl
                        border border-purple-100
                        shadow-sm overflow-hidden">

            <div class="p-6 flex flex-col sm:flex-row
                        sm:items-center sm:justify-between gap-3">

                <div>

                    <h3 class="text-lg font-bold text-gray-800">
                        Data Siswa Terbaru
                    </h3>

                    <p class="text-sm text-gray-400 mt-1">
                        Menampilkan maksimal 5 data siswa.
                    </p>

                </div>

                <a href="siswa/index.php"
                   class="bg-purple-600 hover:bg-purple-700
                          text-white px-5 py-2.5 rounded-xl
                          text-sm font-semibold text-center
                          transition">
                    Kelola Siswa
                </a>

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
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                    <?php if (count($dataSiswa) > 0): ?>

                        <?php foreach ($dataSiswa as $index => $siswa): ?>

                            <tr class="hover:bg-purple-50/50 transition">

                                <td class="px-6 py-4">
                                    <?= $index + 1 ?>
                                </td>

                                <td class="px-6 py-4 font-medium">
                                    <?= htmlspecialchars($siswa['nis']) ?>
                                </td>

                                <td class="px-6 py-4 font-semibold text-gray-700">
                                    <?= htmlspecialchars($siswa['nama_siswa']) ?>
                                </td>

                                <td class="px-6 py-4">
                                    <?= htmlspecialchars($siswa['jenis_kelamin'] ?? '-') ?>
                                </td>

                                <td class="px-6 py-4">

                                    <span class="bg-purple-100
                                                 text-purple-700
                                                 px-3 py-1 rounded-full
                                                 text-xs font-semibold">

                                        <?= htmlspecialchars($siswa['kelas']) ?>

                                    </span>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="5"
                                class="px-6 py-10 text-center text-gray-400">

                                Belum ada data siswa.

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


        <!-- FOOTER -->
        <footer class="text-center text-xs
                       text-gray-400 mt-8">

            Dibuat untuk mempermudah pengelolaan data sekolah.

        </footer>

    </main>

</div>

</body>
</html>
