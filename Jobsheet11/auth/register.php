<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header("Location: /Jobsheet11/");
    exit;
}

$page_title = "Register";

require __DIR__ . "/../config/database.php";
require __DIR__ . "/../includes/csrf.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    csrf_verify();

    $nama = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $konfirmasi = $_POST['konfirmasi_password'] ?? '';

    if ($nama === '') {
        $errors[] = "Nama wajib diisi.";
    }

    if ($username === '') {
        $errors[] = "Username wajib diisi.";
    }

    if ($password === '') {
        $errors[] = "Password wajib diisi.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password minimal 6 karakter.";
    }

    if ($password !== $konfirmasi) {
        $errors[] = "Konfirmasi password tidak sama.";
    }

    if (!$errors) {

        $cek = $pdo->prepare("
            SELECT id
            FROM users
            WHERE username = :username
            LIMIT 1
        ");

        $cek->execute([
            ':username' => $username
        ]);

        if ($cek->fetch()) {
            $errors[] = "Username sudah digunakan.";
        }
    }

    if (!$errors) {

        $stmt = $pdo->prepare("
            INSERT INTO users (
                nama,
                username,
                password,
                role
            )
            VALUES (
                :nama,
                :username,
                :password,
                'petugas'
            )
        ");

        $stmt->execute([
            ':nama' => $nama,
            ':username' => $username,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':role' => $role
        ]);

        header("Location: login.php?pesan=daftar");
        exit;
    }
}

require __DIR__ . "/../layout/header.php";
?>

<section style="max-width: 560px; margin: 0 auto;">

    <h2>Register</h2>

    <?php if ($errors): ?>

        <div class="alert alert-error">

            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error); ?></p>
            <?php endforeach; ?>

        </div>

    <?php endif; ?>

    <form method="POST">

        <?= csrf_field(); ?>

        <div>
            <label for="nama">Nama</label>
            <input
                type="text"
                id="nama"
                name="nama"
                value="<?= htmlspecialchars($_POST['nama'] ?? ''); ?>"
                required>
        </div>

        <div>
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                value="<?= htmlspecialchars($_POST['username'] ?? ''); ?>"
                required>
        </div>

        <div>
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                minlength="6">
        </div>

        <div>
            <label for="konfirmasi_password">Konfirmasi Password</label>
            <input
                type="password"
                id="konfirmasi_password"
                name="konfirmasi_password"
                required
                minlength="6">
        </div>
        <button type="submit" class="btn">
            Register
        </button>

    </form>

    <p style="margin-top: 18px;">
        Sudah punya akun?
        <a href="login.php" style="color: var(--burgundy); font-weight: 600;">
            Login
        </a>
    </p>

</section>

<?php require __DIR__ . "/../layout/footer.php"; ?>
