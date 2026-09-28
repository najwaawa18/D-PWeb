<?php

require_once __DIR__ . "/../../includes/auth.php";
require __DIR__ . "/../../includes/csrf.php";
require __DIR__ . "/../../config/database.php";

csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$aksi = $_POST['aksi'] ?? '';
$id = !empty($_POST['id']) ? (int) $_POST['id'] : 0;
$pesanan_id = !empty($_POST['pesanan_id']) ? (int) $_POST['pesanan_id'] : 0;
$tanggal_bayar = $_POST['tanggal_bayar'] ?? '';
$total_bayar = isset($_POST['total_bayar']) ? (float) $_POST['total_bayar'] : 0;
$metode = $_POST['metode_pembayaran'] ?? '';
$status = $_POST['status'] ?? 'Lunas';

$metodeValid = ['Cash', 'QRIS', 'Debit', 'E-Wallet'];
$statusValid = ['Lunas', 'Belum Lunas'];

if ($pesanan_id <= 0 || $tanggal_bayar === '' || $total_bayar < 0 || !in_array($metode, $metodeValid, true) || !in_array($status, $statusValid, true)) {
    header("Location: index.php?pesan=gagal");
    exit;
}

$timestamp = strtotime($tanggal_bayar);
if ($timestamp === false) {
    header("Location: index.php?pesan=gagal");
    exit;
}

try {
    $pdo->beginTransaction();

    $stmtPesanan = $pdo->prepare("SELECT id, total, status FROM pesanan WHERE id = :id FOR UPDATE");
    $stmtPesanan->execute([':id' => $pesanan_id]);
    $pesanan = $stmtPesanan->fetch();

    if (!$pesanan) {
        throw new Exception('Pesanan tidak ditemukan.');
    }

    if ($pesanan['status'] === 'Dibatalkan') {
        throw new Exception('Pesanan yang dibatalkan tidak dapat dibayar.');
    }

    $totalPesanan = (float) $pesanan['total'];

    if ($status === 'Lunas' && abs($total_bayar - $totalPesanan) > 0.009) {
        throw new Exception('Pembayaran berstatus Lunas harus sama dengan total pesanan.');
    }

    if ($status === 'Belum Lunas' && $total_bayar > $totalPesanan) {
        throw new Exception('Total pembayaran melebihi total pesanan.');
    }

    if ($aksi === 'tambah') {
        $cek = $pdo->prepare("SELECT id FROM pembayaran WHERE pesanan_id = :pesanan_id FOR UPDATE");
        $cek->execute([':pesanan_id' => $pesanan_id]);
        if ($cek->fetch()) {
            throw new Exception('Pesanan sudah memiliki pembayaran.');
        }

        $stmt = $pdo->prepare("INSERT INTO pembayaran (pesanan_id, tanggal_bayar, total_bayar, metode_pembayaran, status) VALUES (:pesanan_id, :tanggal_bayar, :total_bayar, :metode_pembayaran, :status)");
        $stmt->execute([
            ':pesanan_id' => $pesanan_id,
            ':tanggal_bayar' => date('Y-m-d H:i:s', $timestamp),
            ':total_bayar' => $total_bayar,
            ':metode_pembayaran' => $metode,
            ':status' => $status
        ]);
    } elseif ($aksi === 'edit') {
        if ($id <= 0) {
            throw new Exception('ID pembayaran tidak valid.');
        }

        $stmt = $pdo->prepare("SELECT id FROM pembayaran WHERE id = :id FOR UPDATE");
        $stmt->execute([':id' => $id]);
        if (!$stmt->fetch()) {
            throw new Exception('Pembayaran tidak ditemukan.');
        }

        $stmt = $pdo->prepare("SELECT id FROM pembayaran WHERE pesanan_id = :pesanan_id AND id <> :id");
        $stmt->execute([':pesanan_id' => $pesanan_id, ':id' => $id]);
        if ($stmt->fetch()) {
            throw new Exception('Pesanan sudah memiliki pembayaran lain.');
        }

        $stmt = $pdo->prepare("UPDATE pembayaran SET pesanan_id = :pesanan_id, tanggal_bayar = :tanggal_bayar, total_bayar = :total_bayar, metode_pembayaran = :metode_pembayaran, status = :status WHERE id = :id");
        $stmt->execute([
            ':pesanan_id' => $pesanan_id,
            ':tanggal_bayar' => date('Y-m-d H:i:s', $timestamp),
            ':total_bayar' => $total_bayar,
            ':metode_pembayaran' => $metode,
            ':status' => $status,
            ':id' => $id
        ]);
    } else {
        throw new Exception('Aksi tidak valid.');
    }

    // Integrasi status: pembayaran lunas menyelesaikan pesanan.
    $statusPesanan = $status === 'Lunas' ? 'Selesai' : 'Proses';
    $stmtStatus = $pdo->prepare("UPDATE pesanan SET status = :status WHERE id = :id AND status <> 'Dibatalkan'");
    $stmtStatus->execute([':status' => $statusPesanan, ':id' => $pesanan_id]);

    $pdo->commit();

    header("Location: index.php?pesan=" . ($aksi === 'tambah' ? 'tambah' : 'edit'));
    exit;

} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    header("Location: index.php?pesan=gagal");
    exit;
}
