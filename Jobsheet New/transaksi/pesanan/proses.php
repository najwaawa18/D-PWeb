<?php

require __DIR__ . "/../../config/database.php";


/*
|--------------------------------------------------------------------------
| HAPUS PESANAN
|--------------------------------------------------------------------------
*/

if (
    isset($_GET['aksi']) &&
    $_GET['aksi'] === 'hapus'
) {

    $id = $_GET['id'] ?? null;

    if (!$id) {

        header("Location: index.php?pesan=gagal");
        exit;

    }


    try {

        $pdo->beginTransaction();


        $stmt = $pdo->prepare("
            DELETE FROM detail_pesanan
            WHERE pesanan_id = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);


        $stmt = $pdo->prepare("
            DELETE FROM pesanan
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);


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

}


/*
|--------------------------------------------------------------------------
| CEK METHOD
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] !== 'POST'
) {

    header("Location: index.php");
    exit;

}


/*
|--------------------------------------------------------------------------
| DATA UTAMA
|--------------------------------------------------------------------------
*/

$aksi =
    $_POST['aksi'] ?? '';

$id =
    $_POST['id'] ?? null;

$kode_pesanan =
    trim($_POST['kode_pesanan'] ?? '');

$pelanggan_id =
    !empty($_POST['pelanggan_id'])
        ? (int) $_POST['pelanggan_id']
        : null;

$meja_id =
    !empty($_POST['meja_id'])
        ? (int) $_POST['meja_id']
        : null;

$tanggal_pesanan =
    $_POST['tanggal_pesanan'] ?? '';

$status =
    $_POST['status'] ?? 'Proses';


$menu_id =
    $_POST['menu_id'] ?? [];

$jumlah =
    $_POST['jumlah'] ?? [];


/*
|--------------------------------------------------------------------------
| VALIDASI DATA DASAR
|--------------------------------------------------------------------------
*/

if ($kode_pesanan === '') {

    header("Location: index.php?pesan=gagal");
    exit;

}


if ($tanggal_pesanan === '') {

    header("Location: index.php?pesan=gagal");
    exit;

}


$timestamp =
    strtotime($tanggal_pesanan);


if ($timestamp === false) {

    header("Location: index.php?pesan=gagal");
    exit;

}


$tanggal_pesanan_db =
    date(
        'Y-m-d H:i:s',
        $timestamp
    );


/*
|--------------------------------------------------------------------------
| VALIDASI STATUS
|--------------------------------------------------------------------------
*/

$statusValid = [
    'Proses',
    'Selesai',
    'Dibatalkan'
];


if (!in_array(
    $status,
    $statusValid,
    true
)) {

    header("Location: index.php?pesan=gagal");
    exit;

}


/*
|--------------------------------------------------------------------------
| VALIDASI DETAIL
|--------------------------------------------------------------------------
*/

if (
    !is_array($menu_id) ||
    !is_array($jumlah) ||
    count($menu_id) === 0
) {

    header("Location: index.php?pesan=gagal");
    exit;

}


/*
|--------------------------------------------------------------------------
| PROSES DATABASE
|--------------------------------------------------------------------------
*/

try {

    $pdo->beginTransaction();


    /*
    |--------------------------------------------------------------------------
    | TAMBAH PESANAN
    |--------------------------------------------------------------------------
    */

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
                :tanggal_pesanan,
                :status,
                0
            )
            RETURNING id
        ");


        $stmt->execute([

            ':kode_pesanan' =>
                $kode_pesanan,

            ':pelanggan_id' =>
                $pelanggan_id,

            ':meja_id' =>
                $meja_id,

            ':tanggal_pesanan' =>
                $tanggal_pesanan_db,

            ':status' =>
                $status

        ]);


        $pesanan =
            $stmt->fetch();

        $pesanan_id =
            $pesanan['id'];

    }


    /*
    |--------------------------------------------------------------------------
    | EDIT PESANAN
    |--------------------------------------------------------------------------
    */

    elseif ($aksi === 'edit') {

        if (!$id) {

            throw new Exception(
                "ID pesanan tidak ditemukan."
            );

        }


        $pesanan_id =
            (int) $id;


        $stmt = $pdo->prepare("
            UPDATE pesanan
            SET
                kode_pesanan = :kode_pesanan,
                pelanggan_id = :pelanggan_id,
                meja_id = :meja_id,
                tanggal_pesanan = :tanggal_pesanan,
                status = :status
            WHERE id = :id
        ");


        $stmt->execute([

            ':kode_pesanan' =>
                $kode_pesanan,

            ':pelanggan_id' =>
                $pelanggan_id,

            ':meja_id' =>
                $meja_id,

            ':tanggal_pesanan' =>
                $tanggal_pesanan_db,

            ':status' =>
                $status,

            ':id' =>
                $pesanan_id

        ]);


        /*
        | Hapus detail lama.
        */

        $stmt =
            $pdo->prepare("
                DELETE FROM detail_pesanan
                WHERE pesanan_id = :pesanan_id
            ");


        $stmt->execute([
            ':pesanan_id' =>
                $pesanan_id
        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | AKSI TIDAK VALID
    |--------------------------------------------------------------------------
    */

    else {

        throw new Exception(
            "Aksi tidak valid."
        );

    }


    /*
    |--------------------------------------------------------------------------
    | INSERT DETAIL PESANAN
    |--------------------------------------------------------------------------
    */

    $total = 0;


    for (
        $i = 0;
        $i < count($menu_id);
        $i++
    ) {

        $menuId =
            (int) $menu_id[$i];

        $qty =
            (int) ($jumlah[$i] ?? 0);


        if (
            $menuId <= 0 ||
            $qty <= 0
        ) {

            throw new Exception(
                "Detail menu tidak valid."
            );

        }


        /*
        | Ambil harga menu dari database.
        */

        $stmtMenu = $pdo->prepare("
            SELECT
                id,
                harga,
                stok,
                status
            FROM menu
            WHERE id = :id
        ");


        $stmtMenu->execute([
            ':id' => $menuId
        ]);


        $dataMenu =
            $stmtMenu->fetch();


        if (!$dataMenu) {

            throw new Exception(
                "Menu tidak ditemukan."
            );

        }


        /*
        | Pastikan menu tersedia.
        */

        if (
            $dataMenu['status'] !==
            'Tersedia'
        ) {

            throw new Exception(
                "Menu tidak tersedia."
            );

        }


        /*
        | Pastikan stok mencukupi.
        */

        if (
            $qty >
            (int) $dataMenu['stok']
        ) {

            throw new Exception(
                "Stok menu tidak mencukupi."
            );

        }


        $harga =
            (float) $dataMenu['harga'];


        $subtotal =
            $harga * $qty;


        $total +=
            $subtotal;


        /*
        | Simpan detail.
        */

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


        $stmtDetail->execute([

            ':pesanan_id' =>
                $pesanan_id,

            ':menu_id' =>
                $menuId,

            ':jumlah' =>
                $qty,

            ':harga' =>
                $harga,

            ':subtotal' =>
                $subtotal

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE TOTAL PESANAN
    |--------------------------------------------------------------------------
    */

    $stmtTotal = $pdo->prepare("
        UPDATE pesanan
        SET total = :total
        WHERE id = :id
    ");


    $stmtTotal->execute([

        ':total' =>
            $total,

        ':id' =>
            $pesanan_id

    ]);


    /*
    |--------------------------------------------------------------------------
    | SELESAI
    |--------------------------------------------------------------------------
    */

    $pdo->commit();


    header(
        "Location: index.php?pesan=" .
        (
            $aksi === 'tambah'
                ? 'tambah'
                : 'edit'
        )
    );

    exit;


} catch (Exception $e) {

    if ($pdo->inTransaction()) {

        $pdo->rollBack();

    }


    header(
        "Location: index.php?pesan=gagal"
    );

    exit;

}