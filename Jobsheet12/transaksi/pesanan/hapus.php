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

    $stmt = $pdo->prepare("SELECT menu_id, jumlah FROM detail_pesanan WHERE pesanan_id = :pesanan_id");
    $stmt->execute([':pesanan_id' => $id]);
    $details = $stmt->fetchAll();

    if ($pesanan['status'] !== 'Dibatalkan') {
        $restore = $pdo->prepare("UPDATE menu SET stok = stok + :jumlah WHERE id = :id");
        foreach ($details as $detail) {
            $restore->execute([
                ':jumlah' => (int) $detail['jumlah'],
                ':id' => (int) $detail['menu_id']
            ]);
        }
    }

    if ($pesanan['meja_id'] !== null) {
        $stmt = $pdo->prepare("UPDATE meja SET status = 'Kosong' WHERE id = :id");
        $stmt->execute([':id' => (int) $pesanan['meja_id']]);
    }

    $stmt = $pdo->prepare("DELETE FROM pesanan WHERE id = :id");
    $stmt->execute([':id' => $id]);

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
