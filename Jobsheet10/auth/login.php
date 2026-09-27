<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header("Location: /Jobsheet10/");
    exit;
}

$page_title = "Login";

require __DIR__ . "/../config/database.php";
require __DIR__ . "/../layout/header.php";

$pesan = $_GET['pesan'] ?? '';
?>

<section style="max-width: 520px; margin: 0 auto;">

    <h2>Login</h2>

    <?php if ($pesan === 'gagal'): ?>
        <p class="alert alert-error">
            Username atau password salah.
        </p>
    <?php elseif ($pesan === 'daftar'): ?>
        <p class="alert alert-success">
            Registrasi berhasil. Silakan login.
        </p>
    <?php elseif ($pesan === 'logout'): ?>
        <p class="alert alert-success">
            Kamu berhasil logout.
        </p>
    <?php endif; ?>

    <form action="process_login.php" method="POST">

        <div>
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                required
                autocomplete="username">
        </div>

        <div>
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="current-password">
        </div>

        <button type="submit" class="btn">
            Login
        </button>

    </form>

    <p style="margin-top: 18px;">
        Belum punya akun?
        <a href="register.php" style="color: var(--burgundy); font-weight: 600;">
            Register
        </a>
    </p>

</section>

<?php require __DIR__ . "/../layout/footer.php"; ?>
