<?php

require_once __DIR__ . "/../../includes/auth.php";
require __DIR__ . "/../../includes/csrf.php";


require __DIR__ . "/../../config/database.php";

csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$id = $_POST['id'] ?? null;

if (!$id) {
    header("Location: index.php?pesan=gagal");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM pembayaran WHERE id = :id");
    $stmt->execute([':id' => $id]);

    header("Location: index.php?pesan=hapus");
    exit;
} catch (PDOException $e) {
    header("Location: index.php?pesan=gagal");
    exit;
}
