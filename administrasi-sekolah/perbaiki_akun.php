<?php
require_once "koneksi.php";

try {
    $pdo->beginTransaction();

    // Hapus akun Admin duplikat yang password-nya salah
    $hapus = $pdo->prepare(
        "DELETE FROM users
         WHERE id_user = 3
         AND email = 'admin@schoolcare.com'"
    );
    $hapus->execute();

    // Perbaiki akun Admin
    $admin = $pdo->prepare(
        "UPDATE users
         SET nama = ?,
             email = ?,
             password = ?,
             role = ?
         WHERE id_user = 1"
    );

    $admin->execute([
        "Administrator",
        "admin@schoolcare.com",
        password_hash("admin123", PASSWORD_DEFAULT),
        "admin"
    ]);

    // Perbaiki akun Guru
    $guru = $pdo->prepare(
        "UPDATE users
         SET nama = ?,
             email = ?,
             password = ?,
             role = ?
         WHERE id_user = 2"
    );

    $guru->execute([
        "Guru Sekolah",
        "guru@schoolcare.com",
        password_hash("guru123", PASSWORD_DEFAULT),
        "guru"
    ]);

    $pdo->commit();

    echo "Berhasil! Akun Admin dan Guru sudah diperbaiki.";

} catch (PDOException $e) {
    $pdo->rollBack();
    die("Gagal memperbaiki akun: " . $e->getMessage());
}
?>