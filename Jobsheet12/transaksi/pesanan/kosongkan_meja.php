<?php

require_once __DIR__ . "/../../includes/auth.php";
require __DIR__ . "/../../includes/csrf.php";
require __DIR__ . "/../../config/database.php";

csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$id = !empty($_POST['id']) ? (int) $_POST['id'] : 0;

if ($id <= 0) {
    header("Location: index.php?pesan=gagal");
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT id, status, meja_id FROM pesanan WHERE id = :id FOR UPDATE");
    $stmt->execute([':id' => $id]);
    $pesanan = $stmt->fetch();

    if (!$pesanan) {
        throw new Exception('Pesanan tidak ditemukan.');
    }

    if ($pesanan['status'] !== 'Selesai') {
        throw new Exception('Meja hanya dapat dikosongkan setelah pesanan selesai.');
    }

    if ($pesanan['meja_id'] === null) {
        throw new Exception('Pesanan tidak memiliki meja.');
    }

    $stmt = $pdo->prepare("UPDATE meja SET status = 'Kosong' WHERE id = :id");
    $stmt->execute([':id' => (int) $pesanan['meja_id']]);

    $pdo->commit();

    header("Location: index.php?pesan=meja_kosong");
    exit;

} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    header("Location: index.php?pesan=gagal");
    exit;
}
