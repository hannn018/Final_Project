
<?php
require_once __DIR__ . '/../koneksi.php';

try {
    $stmt = $pdo->query("
        SELECT
            mata_pelajaran.id_mapel,
            mata_pelajaran.nama_mapel,
            guru.nama_guru
        FROM mata_pelajaran
        LEFT JOIN guru
            ON mata_pelajaran.id_guru = guru.id_guru
        ORDER BY mata_pelajaran.id_mapel DESC
    ");

    $dataMapel = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Gagal mengambil data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Pelajaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-purple-50 text-gray-700 p-6">

<div class="max-w-6xl mx-auto">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-purple-800">
                Data Mata Pelajaran
            </h1>
            <p class="text-gray-500 mt-2">
                Kelola mata pelajaran dan guru pengajar.
            </p>
        </div>

        <a href="tambah.php"
           class="bg-purple-600 text-white px-5 py-3 rounded-xl">
            + Tambah Mapel
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-x-auto">

        <table class="w-full text-left text-sm">
            <thead class="bg-purple-100 text-purple-800">
                <tr>
                    <th class="p-4">No</th>
                    <th class="p-4">Nama Mata Pelajaran</th>
                    <th class="p-4">Guru Pengajar</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">

            <?php if (count($dataMapel) > 0): ?>

                <?php foreach ($dataMapel as $i => $mapel): ?>
                    <tr>
                        <td class="p-4"><?= $i + 1 ?></td>

                        <td class="p-4 font-semibold">
                            <?= htmlspecialchars($mapel['nama_mapel']) ?>
                        </td>

                        <td class="p-4">
                            <?= htmlspecialchars($mapel['nama_guru'] ?? '-') ?>
                        </td>

                        <td class="p-4 text-center">
                            <a href="edit.php?id=<?= $mapel['id_mapel'] ?>"
                               class="bg-amber-100 text-amber-700 px-3 py-2 rounded-lg">
                                Edit
                            </a>

                            <a href="hapus.php?id=<?= $mapel['id_mapel'] ?>"
                               onclick="return confirm('Yakin ingin menghapus mata pelajaran ini?')"
                               class="bg-pink-100 text-pink-700 px-3 py-2 rounded-lg">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-400">
                        Belum ada data mata pelajaran.
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>
        </table>

    </div>

</div>

</body>
</html>
