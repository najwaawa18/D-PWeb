<?php

require_once __DIR__ . "/../../includes/auth.php";


require __DIR__ . "/../../config/database.php";

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
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("DELETE FROM detail_pesanan WHERE pesanan_id = :id");
    $stmt->execute([':id' => $id]);

    $stmt = $pdo->prepare("DELETE FROM pesanan WHERE id = :id");
    $stmt->execute([':id' => $id]);

    $pdo->commit();

    header("Location: index.php?pesan=hapus");
    exit;
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    header("Location: index.php?pesan=gagal");
    exit;
}
