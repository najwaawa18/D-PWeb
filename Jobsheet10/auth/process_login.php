<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . "/../config/database.php";

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header("Location: login.php?pesan=gagal");
    exit;
}

$stmt = $pdo->prepare("
    SELECT id, nama, username, password, role
    FROM users
    WHERE username = :username
    LIMIT 1
");

$stmt->execute([
    ':username' => $username
]);

$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    header("Location: login.php?pesan=gagal");
    exit;
}

session_regenerate_id(true);

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['nama'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

header("Location: /Jobsheet10/");
exit;
