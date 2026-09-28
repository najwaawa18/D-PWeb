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

    $stmt = $pdo->prepare("SELECT id, pesanan_id FROM pembayaran WHERE id = :id FOR UPDATE");
    $stmt->execute([':id' => $id]);
    $pembayaran = $stmt->fetch();

    if (!$pembayaran) {
        throw new Exception('Pembayaran tidak ditemukan.');
    }

    $stmt = $pdo->prepare("DELETE FROM pembayaran WHERE id = :id");
    $stmt->execute([':id' => $id]);

    $stmt = $pdo->prepare("UPDATE pesanan SET status = 'Proses' WHERE id = :id AND status <> 'Dibatalkan'");
    $stmt->execute([':id' => $pembayaran['pesanan_id']]);

    $pdo->commit();

    header("Location: index.php?pesan=hapus");
    exit;

} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    header("Location: index.php?pesan=gagal");
    exit;
}
