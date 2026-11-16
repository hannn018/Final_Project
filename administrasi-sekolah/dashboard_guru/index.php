<?php
session_start();

if (
    !isset($_SESSION["id_user"]) ||
    $_SESSION["role"] !== "guru"
) {
    header("Location: ../login/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-purple-50 min-h-screen p-8">

    <div class="bg-white max-w-3xl mx-auto p-8 rounded-2xl shadow">

        <h1 class="text-2xl font-bold text-purple-800">
            Dashboard Guru
        </h1>

        <p class="mt-4">
            Selamat datang,
            <strong><?= htmlspecialchars($_SESSION["nama"]) ?></strong>
        </p>

        <p class="text-gray-500 mt-2">
            Anda berhasil login sebagai Guru.
        </p>

        <a href="../logout.php"
           class="inline-block mt-6 bg-purple-600 text-white
                  px-5 py-2 rounded-xl">
            Logout
        </a>

    </div>

</body>
</html>