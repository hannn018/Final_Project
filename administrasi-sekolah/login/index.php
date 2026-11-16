
<?php
// ======================================
// KONFIGURASI AWAL
// ======================================

session_start();
require_once "../koneksi.php";

$error = "";

// ======================================
// CEK SESSION PENGGUNA
// ======================================

if (isset($_SESSION["id_user"])) {

    if ($_SESSION["role"] === "admin") {
        header("Location: ../index.php");
        exit;
    }

    if ($_SESSION["role"] === "guru") {
        header("Location: ../dashboard_guru/index.php");
        exit;
    }
}

// ======================================
// PROSES LOGIN
// ======================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // Validasi input
    if ($email === "" || $password === "") {

        $error = "Email dan password wajib diisi.";

    } else {

        // Mencari akun berdasarkan email
        $stmt = $pdo->prepare(
            "SELECT * FROM users WHERE email = ?"
        );

        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Memeriksa password
        if (
            $user &&
            password_verify($password, $user["password"])
        ) {

            // Membuat session baru
            session_regenerate_id(true);

            $_SESSION["id_user"] = $user["id_user"];
            $_SESSION["nama"] = $user["nama"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["role"] = $user["role"];

            // Mengarahkan berdasarkan role
            if ($user["role"] === "admin") {

                header("Location: ../index.php");
                exit;

            } elseif ($user["role"] === "guru") {

                header("Location: ../dashboard_guru/index.php");
                exit;

            } else {

                $_SESSION = [];
                session_destroy();

                session_start();
                $error = "Role akun tidak dikenali.";
            }

        } else {

            $error = "Email atau password salah.";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SchoolCare</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-purple-50 flex items-center justify-center p-5">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-lg p-8">

        <!-- HEADER LOGIN -->
        <div class="text-center mb-8">

            <div class="w-16 h-16 bg-purple-100 text-purple-700
                        rounded-2xl flex items-center justify-center
                        mx-auto text-3xl font-bold">
                S
            </div>

            <h1 class="text-2xl font-bold text-purple-800 mt-4">
                SchoolCare
            </h1>

            <p class="text-gray-500 text-sm mt-2">
                Sistem Administrasi Sekolah
            </p>

            <p class="text-purple-600 text-sm mt-5">
                Silakan login menggunakan akun Anda
            </p>

        </div>

        <!-- PESAN ERROR -->
        <?php if ($error !== ""): ?>

            <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-4 text-sm">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>

        <!-- FORM LOGIN -->
        <form method="POST">

            <!-- EMAIL -->
            <div class="mb-5">

                <label class="block text-sm font-medium mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    required
                    placeholder="Masukkan email"
                    value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"
                    class="w-full border border-gray-200 rounded-xl
                           px-4 py-3 outline-none focus:ring-2
                           focus:ring-purple-300"
                >

            </div>

            <!-- PASSWORD -->
            <div class="mb-6">

                <label class="block text-sm font-medium mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    required
                    placeholder="Masukkan password"
                    class="w-full border border-gray-200 rounded-xl
                           px-4 py-3 outline-none focus:ring-2
                           focus:ring-purple-300"
                >

            </div>

            <!-- TOMBOL LOGIN -->
            <button
                type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700
                       text-white font-semibold py-3 rounded-xl
                       transition"
            >
                Login
            </button>

        </form>

        <!-- FOOTER -->
        <p class="text-center text-xs text-gray-400 mt-7">
            SchoolCare - Sistem Administrasi Sekolah
        </p>

    </div>

</body>
</html>
