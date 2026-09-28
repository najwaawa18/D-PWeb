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
$kode_pesanan = trim($_POST['kode_pesanan'] ?? '');
$pelanggan_id = !empty($_POST['pelanggan_id']) ? (int) $_POST['pelanggan_id'] : null;
$meja_id = !empty($_POST['meja_id']) ? (int) $_POST['meja_id'] : null;
$tanggal_pesanan = $_POST['tanggal_pesanan'] ?? '';
$status = $_POST['status'] ?? 'Proses';
$menu_id = $_POST['menu_id'] ?? [];
$jumlah = $_POST['jumlah'] ?? [];

if ($kode_pesanan === '' || $tanggal_pesanan === '') {
    header("Location: index.php?pesan=gagal");
    exit;
}

$timestamp = strtotime($tanggal_pesanan);
if ($timestamp === false) {
    header("Location: index.php?pesan=gagal");
    exit;
}

$statusValid = ['Proses', 'Selesai', 'Dibatalkan'];
if (!in_array($status, $statusValid, true)) {
    header("Location: index.php?pesan=gagal");
    exit;
}

if (!is_array($menu_id) || !is_array($jumlah) || count($menu_id) === 0) {
    header("Location: index.php?pesan=gagal");
    exit;
}

// Gabungkan menu yang sama agar stok selalu dihitung secara akurat.
$items = [];
foreach ($menu_id as $i => $rawMenuId) {
    $menuId = (int) $rawMenuId;
    $qty = (int) ($jumlah[$i] ?? 0);

    if ($menuId <= 0 || $qty <= 0) {
        header("Location: index.php?pesan=gagal");
        exit;
    }

    $items[$menuId] = ($items[$menuId] ?? 0) + $qty;
}

try {
    $pdo->beginTransaction();

    $tanggalDb = date('Y-m-d H:i:s', $timestamp);
    $pesananId = $id;
    $oldStatus = null;
    $oldDetails = [];

    // EDIT: ambil data lama dan kembalikan stok pesanan lama terlebih dahulu.
    if ($aksi === 'edit') {
        if ($id <= 0) {
            throw new Exception('ID pesanan tidak valid.');
        }

        $stmt = $pdo->prepare("SELECT id, status FROM pesanan WHERE id = :id FOR UPDATE");
        $stmt->execute([':id' => $id]);
        $oldOrder = $stmt->fetch();

        if (!$oldOrder) {
            throw new Exception('Pesanan tidak ditemukan.');
        }

        $oldStatus = $oldOrder['status'];

        $stmt = $pdo->prepare("SELECT menu_id, jumlah FROM detail_pesanan WHERE pesanan_id = :pesanan_id");
        $stmt->execute([':pesanan_id' => $id]);
        $oldDetails = $stmt->fetchAll();

        // Hanya pesanan yang sebelumnya aktif yang sudah mengambil stok.
        if ($oldStatus !== 'Dibatalkan') {
            $restore = $pdo->prepare("UPDATE menu SET stok = stok + :jumlah WHERE id = :id");
            foreach ($oldDetails as $detail) {
                $restore->execute([
                    ':jumlah' => (int) $detail['jumlah'],
                    ':id' => (int) $detail['menu_id']
                ]);
            }
        }

        $stmt = $pdo->prepare("DELETE FROM detail_pesanan WHERE pesanan_id = :pesanan_id");
        $stmt->execute([':pesanan_id' => $id]);

        $stmt = $pdo->prepare("UPDATE pesanan SET kode_pesanan = :kode_pesanan, pelanggan_id = :pelanggan_id, meja_id = :meja_id, tanggal_pesanan = :tanggal_pesanan, status = :status WHERE id = :id");
        $stmt->execute([
            ':kode_pesanan' => $kode_pesanan,
            ':pelanggan_id' => $pelanggan_id,
            ':meja_id' => $meja_id,
            ':tanggal_pesanan' => $tanggalDb,
            ':status' => $status,
            ':id' => $id
        ]);
    } elseif ($aksi === 'tambah') {
        $stmt = $pdo->prepare("INSERT INTO pesanan (kode_pesanan, pelanggan_id, meja_id, tanggal_pesanan, status, total) VALUES (:kode_pesanan, :pelanggan_id, :meja_id, :tanggal_pesanan, :status, 0) RETURNING id");
        $stmt->execute([
            ':kode_pesanan' => $kode_pesanan,
            ':pelanggan_id' => $pelanggan_id,
            ':meja_id' => $meja_id,
            ':tanggal_pesanan' => $tanggalDb,
            ':status' => $status
        ]);
        $pesananId = (int) $stmt->fetchColumn();
    } else {
        throw new Exception('Aksi tidak valid.');
    }

    $total = 0;

    foreach ($items as $menuId => $qty) {
        // Lock baris menu agar dua transaksi tidak bisa memakai stok yang sama secara bersamaan.
        $stmtMenu = $pdo->prepare("SELECT id, nama_menu, harga, stok, status FROM menu WHERE id = :id FOR UPDATE");
        $stmtMenu->execute([':id' => $menuId]);
        $dataMenu = $stmtMenu->fetch();

        if (!$dataMenu) {
            throw new Exception('Menu tidak ditemukan.');
        }

        // Pesanan yang dibatalkan tidak mengambil stok.
        if ($status !== 'Dibatalkan') {
            if ($dataMenu['status'] !== 'Tersedia') {
                throw new Exception('Menu ' . $dataMenu['nama_menu'] . ' tidak tersedia.');
            }

            if ($qty > (int) $dataMenu['stok']) {
                throw new Exception('Stok menu ' . $dataMenu['nama_menu'] . ' tidak mencukupi.');
            }
        }

        $harga = (float) $dataMenu['harga'];
        $subtotal = $harga * $qty;
        $total += $subtotal;

        $stmtDetail = $pdo->prepare("INSERT INTO detail_pesanan (pesanan_id, menu_id, jumlah, harga, subtotal) VALUES (:pesanan_id, :menu_id, :jumlah, :harga, :subtotal)");
        $stmtDetail->execute([
            ':pesanan_id' => $pesananId,
            ':menu_id' => $menuId,
            ':jumlah' => $qty,
            ':harga' => $harga,
            ':subtotal' => $subtotal
        ]);

        if ($status !== 'Dibatalkan') {
            $stmtStock = $pdo->prepare("UPDATE menu SET stok = stok - :jumlah WHERE id = :id AND stok >= :jumlah");
            $stmtStock->execute([
                ':jumlah' => $qty,
                ':id' => $menuId
            ]);

            if ($stmtStock->rowCount() !== 1) {
                throw new Exception('Stok menu berubah. Silakan coba lagi.');
            }
        }
    }

    $stmtTotal = $pdo->prepare("UPDATE pesanan SET total = :total WHERE id = :id");
    $stmtTotal->execute([
        ':total' => $total,
        ':id' => $pesananId
    ]);

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
