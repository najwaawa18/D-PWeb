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
$meja_id = !empty($_POST['meja_id']) ? (int) $_POST['meja_id'] : 0;
$tanggal_pesanan = $_POST['tanggal_pesanan'] ?? '';
$status = $_POST['status'] ?? 'Proses';
$menu_id = $_POST['menu_id'] ?? [];
$jumlah = $_POST['jumlah'] ?? [];

if ($kode_pesanan === '' || $tanggal_pesanan === '' || $meja_id <= 0) {
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
    $oldTableId = null;
    $oldDetails = [];

    if ($aksi === 'edit') {
        if ($id <= 0) {
            throw new Exception('ID pesanan tidak valid.');
        }

        $stmt = $pdo->prepare("SELECT id, status, meja_id FROM pesanan WHERE id = :id FOR UPDATE");
        $stmt->execute([':id' => $id]);
        $oldOrder = $stmt->fetch();

        if (!$oldOrder) {
            throw new Exception('Pesanan tidak ditemukan.');
        }

        $oldStatus = $oldOrder['status'];
        $oldTableId = $oldOrder['meja_id'] !== null ? (int) $oldOrder['meja_id'] : null;

        $stmt = $pdo->prepare("SELECT menu_id, jumlah FROM detail_pesanan WHERE pesanan_id = :pesanan_id");
        $stmt->execute([':pesanan_id' => $id]);
        $oldDetails = $stmt->fetchAll();

        if ($oldStatus !== 'Dibatalkan') {
            $restore = $pdo->prepare("UPDATE menu SET stok = stok + :jumlah WHERE id = :id");
            foreach ($oldDetails as $detail) {
                $restore->execute([
                    ':jumlah' => (int) $detail['jumlah'],
                    ':id' => (int) $detail['menu_id']
                ]);
            }
        }

        // Kunci meja baru sebelum memastikan meja tersebut masih tersedia.
        $stmt = $pdo->prepare("SELECT id, status FROM meja WHERE id = :id FOR UPDATE");
        $stmt->execute([':id' => $meja_id]);
        $newTable = $stmt->fetch();

        if (!$newTable) {
            throw new Exception('Meja tidak ditemukan.');
        }

        if ($oldTableId !== $meja_id && $newTable['status'] !== 'Kosong') {
            throw new Exception('Meja yang dipilih sedang digunakan.');
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
        // Satu meja hanya boleh memiliki satu pesanan aktif pada satu waktu.
        $stmt = $pdo->prepare("SELECT id, status FROM meja WHERE id = :id FOR UPDATE");
        $stmt->execute([':id' => $meja_id]);
        $table = $stmt->fetch();

        if (!$table) {
            throw new Exception('Meja tidak ditemukan.');
        }

        if ($table['status'] !== 'Kosong') {
            throw new Exception('Meja yang dipilih sedang digunakan.');
        }

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
        $stmtMenu = $pdo->prepare("SELECT id, nama_menu, harga, stok, status FROM menu WHERE id = :id FOR UPDATE");
        $stmtMenu->execute([':id' => $menuId]);
        $dataMenu = $stmtMenu->fetch();

        if (!$dataMenu) {
            throw new Exception('Menu tidak ditemukan.');
        }

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

    // Pesanan yang dibatalkan tidak lagi memegang meja.
    // Pesanan Proses/Selesai tetap membuat meja berstatus Terisi.
    if ($status === 'Dibatalkan') {
        if ($oldTableId !== null) {
            $stmt = $pdo->prepare("UPDATE meja SET status = 'Kosong' WHERE id = :id");
            $stmt->execute([':id' => $oldTableId]);
        } else {
            $stmt = $pdo->prepare("UPDATE meja SET status = 'Kosong' WHERE id = :id");
            $stmt->execute([':id' => $meja_id]);
        }
    } else {
        if ($oldTableId !== null && $oldTableId !== $meja_id) {
            $stmt = $pdo->prepare("UPDATE meja SET status = 'Kosong' WHERE id = :id");
            $stmt->execute([':id' => $oldTableId]);
        }

        $stmt = $pdo->prepare("UPDATE meja SET status = 'Terisi' WHERE id = :id");
        $stmt->execute([':id' => $meja_id]);
    }

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
