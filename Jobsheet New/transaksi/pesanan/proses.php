<?php

require __DIR__ . "/../../config/database.php";

function kembali($pesan)
{
    header(
        "Location: index.php?pesan=" .
        urlencode($pesan)
    );
    exit;
}


// ======================================================
// HAPUS PESANAN
// ======================================================

if (
    $_SERVER['REQUEST_METHOD'] === 'GET' &&
    ($_GET['aksi'] ?? '') === 'hapus'
) {

    $id = filter_input(
        INPUT_GET,
        'id',
        FILTER_VALIDATE_INT
    );

    if (!$id) {
        kembali('gagal');
    }

    try {

        $pdo->beginTransaction();

        // Hapus detail pesanan terlebih dahulu
        $stmt = $pdo->prepare("
            DELETE FROM detail_pesanan
            WHERE pesanan_id = :pesanan_id
        ");

        $stmt->execute([
            ':pesanan_id' => $id
        ]);


        // Hapus data pesanan
        $stmt = $pdo->prepare("
            DELETE FROM pesanan
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);


        $pdo->commit();

        kembali('hapus');

    } catch (Exception $e) {

        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        kembali('gagal');
    }
}


// ======================================================
// CEK REQUEST
// ======================================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: index.php");
    exit;
}


// ======================================================
// AMBIL DATA FORM
// ======================================================

$aksi = $_POST['aksi'] ?? 'tambah';

$id = filter_input(
    INPUT_POST,
    'id',
    FILTER_VALIDATE_INT
);

$kode_pesanan = trim(
    $_POST['kode_pesanan'] ?? ''
);

$pelanggan_id = filter_input(
    INPUT_POST,
    'pelanggan_id',
    FILTER_VALIDATE_INT
);

$meja_id = filter_input(
    INPUT_POST,
    'meja_id',
    FILTER_VALIDATE_INT
);

$status = trim(
    $_POST['status'] ?? 'Proses'
);

$menu_id = $_POST['menu_id'] ?? [];
$jumlah = $_POST['jumlah'] ?? [];


// Pastikan menjadi array
if (!is_array($menu_id)) {
    $menu_id = [$menu_id];
}

if (!is_array($jumlah)) {
    $jumlah = [$jumlah];
}


// ======================================================
// VALIDASI DATA DASAR
// ======================================================

if (
    $kode_pesanan === '' ||
    !$pelanggan_id ||
    !$meja_id
) {
    kembali('gagal');
}


$statusValid = [
    'Proses',
    'Selesai',
    'Dibatalkan'
];

if (!in_array($status, $statusValid, true)) {
    kembali('gagal');
}

if (count($menu_id) === 0) {
    kembali('gagal');
}


// ======================================================
// PROSES DATABASE
// ======================================================

try {

    $pdo->beginTransaction();


    // ==================================================
    // CEK PELANGGAN
    // ==================================================

    $stmt = $pdo->prepare("
        SELECT id
        FROM pelanggan
        WHERE id = :id
    ");

    $stmt->execute([
        ':id' => $pelanggan_id
    ]);

    if (!$stmt->fetch()) {
        throw new Exception(
            "Pelanggan tidak ditemukan."
        );
    }


    // ==================================================
    // CEK MEJA
    // ==================================================

    $stmt = $pdo->prepare("
        SELECT id
        FROM meja
        WHERE id = :id
    ");

    $stmt->execute([
        ':id' => $meja_id
    ]);

    if (!$stmt->fetch()) {
        throw new Exception(
            "Meja tidak ditemukan."
        );
    }


    // ==================================================
    // CEK KODE PESANAN SAAT TAMBAH
    // ==================================================

    if ($aksi === 'tambah') {

        $stmt = $pdo->prepare("
            SELECT id
            FROM pesanan
            WHERE kode_pesanan = :kode_pesanan
        ");

        $stmt->execute([
            ':kode_pesanan' => $kode_pesanan
        ]);

        if ($stmt->fetch()) {

            throw new Exception(
                "Kode pesanan sudah digunakan."
            );
        }
    }


    // ==================================================
    // CEK PESANAN SAAT EDIT
    // ==================================================

    if ($aksi === 'edit') {

        if (!$id) {
            throw new Exception(
                "ID pesanan tidak valid."
            );
        }


        $stmt = $pdo->prepare("
            SELECT id
            FROM pesanan
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        if (!$stmt->fetch()) {

            throw new Exception(
                "Pesanan tidak ditemukan."
            );
        }


        // Cek kode pesanan agar tidak sama dengan
        // pesanan lain
        $stmt = $pdo->prepare("
            SELECT id
            FROM pesanan
            WHERE kode_pesanan = :kode_pesanan
              AND id <> :id
        ");

        $stmt->execute([
            ':kode_pesanan' => $kode_pesanan,
            ':id' => $id
        ]);

        if ($stmt->fetch()) {

            throw new Exception(
                "Kode pesanan sudah digunakan."
            );
        }
    }


    // ==================================================
    // CEK MENU DAN HITUNG TOTAL
    // ==================================================

    $stmtMenu = $pdo->prepare("
        SELECT
            id,
            harga,
            stok,
            status
        FROM menu
        WHERE id = :id
    ");


    $total = 0;

    $detailData = [];


    foreach ($menu_id as $i => $id_menu) {

        $id_menu = filter_var(
            $id_menu,
            FILTER_VALIDATE_INT
        );

        $qty = isset($jumlah[$i])
            ? filter_var(
                $jumlah[$i],
                FILTER_VALIDATE_INT
            )
            : false;


        if (!$id_menu || !$qty || $qty < 1) {

            throw new Exception(
                "Data menu atau jumlah tidak valid."
            );
        }


        // Ambil data menu
        $stmtMenu->execute([
            ':id' => $id_menu
        ]);

        $dataMenu = $stmtMenu->fetch();


        if (!$dataMenu) {

            throw new Exception(
                "Menu tidak ditemukan."
            );
        }


        // Cek status menu
        if ($dataMenu['status'] !== 'Tersedia') {

            throw new Exception(
                "Ada menu yang sudah tidak tersedia."
            );
        }


        // Cek stok
        if (
            $dataMenu['stok'] !== null &&
            $qty > (int) $dataMenu['stok']
        ) {

            throw new Exception(
                "Jumlah pesanan melebihi stok menu."
            );
        }


        $harga = (float) $dataMenu['harga'];

        $subtotal = $harga * $qty;

        $total += $subtotal;


        $detailData[] = [
            'menu_id' => $id_menu,
            'jumlah' => $qty,
            'harga' => $harga,
            'subtotal' => $subtotal
        ];
    }


    if ($total <= 0) {

        throw new Exception(
            "Total pesanan tidak valid."
        );
    }


    // ==================================================
    // TAMBAH PESANAN
    // ==================================================

    if ($aksi === 'tambah') {

        $stmt = $pdo->prepare("
            INSERT INTO pesanan (
                kode_pesanan,
                pelanggan_id,
                meja_id,
                tanggal_pesanan,
                status,
                total
            )
            VALUES (
                :kode_pesanan,
                :pelanggan_id,
                :meja_id,
                NOW(),
                :status,
                :total
            )
            RETURNING id
        ");


        $stmt->execute([
            ':kode_pesanan' => $kode_pesanan,
            ':pelanggan_id' => $pelanggan_id,
            ':meja_id' => $meja_id,
            ':status' => $status,
            ':total' => $total
        ]);


        $pesanan_id = $stmt->fetchColumn();


        // Simpan detail pesanan
        $stmtDetail = $pdo->prepare("
            INSERT INTO detail_pesanan (
                pesanan_id,
                menu_id,
                jumlah,
                harga,
                subtotal
            )
            VALUES (
                :pesanan_id,
                :menu_id,
                :jumlah,
                :harga,
                :subtotal
            )
        ");


        foreach ($detailData as $detail) {

            $stmtDetail->execute([
                ':pesanan_id' => $pesanan_id,
                ':menu_id' => $detail['menu_id'],
                ':jumlah' => $detail['jumlah'],
                ':harga' => $detail['harga'],
                ':subtotal' => $detail['subtotal']
            ]);
        }


        $pdo->commit();

        kembali('tambah');
    }


    // ==================================================
    // EDIT PESANAN
    // ==================================================

    elseif ($aksi === 'edit') {

        $stmt = $pdo->prepare("
            UPDATE pesanan
            SET
                kode_pesanan = :kode_pesanan,
                pelanggan_id = :pelanggan_id,
                meja_id = :meja_id,
                status = :status,
                total = :total
            WHERE id = :id
        ");


        $stmt->execute([
            ':kode_pesanan' => $kode_pesanan,
            ':pelanggan_id' => $pelanggan_id,
            ':meja_id' => $meja_id,
            ':status' => $status,
            ':total' => $total,
            ':id' => $id
        ]);


        // Hapus detail lama
        $stmt = $pdo->prepare("
            DELETE FROM detail_pesanan
            WHERE pesanan_id = :pesanan_id
        ");

        $stmt->execute([
            ':pesanan_id' => $id
        ]);


        // Simpan detail baru
        $stmtDetail = $pdo->prepare("
            INSERT INTO detail_pesanan (
                pesanan_id,
                menu_id,
                jumlah,
                harga,
                subtotal
            )
            VALUES (
                :pesanan_id,
                :menu_id,
                :jumlah,
                :harga,
                :subtotal
            )
        ");


        foreach ($detailData as $detail) {

            $stmtDetail->execute([
                ':pesanan_id' => $id,
                ':menu_id' => $detail['menu_id'],
                ':jumlah' => $detail['jumlah'],
                ':harga' => $detail['harga'],
                ':subtotal' => $detail['subtotal']
            ]);
        }


        $pdo->commit();

        kembali('edit');
    }


    // ==================================================
    // AKSI TIDAK DIKENAL
    // ==================================================

    else {

        throw new Exception(
            "Aksi tidak dikenal."
        );
    }


} catch (Exception $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    kembali('gagal');
}