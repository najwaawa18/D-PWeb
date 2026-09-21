<?php

require __DIR__ . "/../../config/database.php";


/*
|--------------------------------------------------------------------------
| HAPUS DATA
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

        $stmt = $pdo->prepare("
            DELETE FROM pembayaran
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);


        header(
            "Location: index.php?pesan=hapus"
        );

        exit;

    } catch (PDOException $e) {

        header(
            "Location: index.php?pesan=gagal"
        );

        exit;

    }

}


/*
|--------------------------------------------------------------------------
| CEK METHOD
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: index.php");

    exit;

}


/*
|--------------------------------------------------------------------------
| AMBIL DATA
|--------------------------------------------------------------------------
*/

$aksi = $_POST['aksi'] ?? '';

$id = $_POST['id'] ?? null;

$pesanan_id =
    !empty($_POST['pesanan_id'])
        ? (int)$_POST['pesanan_id']
        : 0;

$total_bayar =
    isset($_POST['total_bayar'])
        ? (float)$_POST['total_bayar']
        : 0;

$metode_pembayaran =
    $_POST['metode_pembayaran'] ?? '';

$status =
    $_POST['status'] ?? 'Lunas';


/*
|--------------------------------------------------------------------------
| VALIDASI
|--------------------------------------------------------------------------
*/

$metodeValid = [
    'Cash',
    'QRIS',
    'Debit',
    'E-Wallet'
];

$statusValid = [
    'Lunas',
    'Belum Lunas'
];


if ($pesanan_id <= 0) {

    header("Location: index.php?pesan=gagal");

    exit;

}


if ($total_bayar < 0) {

    header("Location: index.php?pesan=gagal");

    exit;

}


if (!in_array(
    $metode_pembayaran,
    $metodeValid,
    true
)) {

    header("Location: index.php?pesan=gagal");

    exit;

}


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
| PROSES
|--------------------------------------------------------------------------
*/

try {

    $pdo->beginTransaction();


    /*
    |--------------------------------------------------------------------------
    | CEK PESANAN
    |--------------------------------------------------------------------------
    */

    $stmtPesanan = $pdo->prepare("
        SELECT
            id,
            total
        FROM pesanan
        WHERE id = :id
    ");

    $stmtPesanan->execute([
        ':id' => $pesanan_id
    ]);

    $pesanan = $stmtPesanan->fetch();


    if (!$pesanan) {

        throw new Exception(
            "Pesanan tidak ditemukan."
        );

    }


    /*
    |--------------------------------------------------------------------------
    | TOTAL BAYAR TIDAK BOLEH LEBIH DARI TOTAL PESANAN
    |--------------------------------------------------------------------------
    */

    if (
        $total_bayar >
        (float)$pesanan['total']
    ) {

        throw new Exception(
            "Total pembayaran melebihi total pesanan."
        );

    }


    /*
    |--------------------------------------------------------------------------
    | TAMBAH
    |--------------------------------------------------------------------------
    */

    if ($aksi === 'tambah') {


        /*
        | Satu pesanan hanya boleh
        | memiliki satu pembayaran.
        */

        $cekPembayaran = $pdo->prepare("
            SELECT id
            FROM pembayaran
            WHERE pesanan_id = :pesanan_id
        ");

        $cekPembayaran->execute([
            ':pesanan_id' => $pesanan_id
        ]);


        if ($cekPembayaran->fetch()) {

            throw new Exception(
                "Pesanan sudah memiliki pembayaran."
            );

        }


        $stmt = $pdo->prepare("
            INSERT INTO pembayaran (
                pesanan_id,
                total_bayar,
                metode_pembayaran,
                status
            )
            VALUES (
                :pesanan_id,
                :total_bayar,
                :metode_pembayaran,
                :status
            )
        ");


        $stmt->execute([

            ':pesanan_id' =>
                $pesanan_id,

            ':total_bayar' =>
                $total_bayar,

            ':metode_pembayaran' =>
                $metode_pembayaran,

            ':status' =>
                $status

        ]);


        $pdo->commit();


        header(
            "Location: index.php?pesan=tambah"
        );

        exit;

    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    elseif ($aksi === 'edit') {


        if (!$id) {

            throw new Exception(
                "ID pembayaran tidak ditemukan."
            );

        }


        /*
        | Cek pembayaran
        */

        $cek = $pdo->prepare("
            SELECT id
            FROM pembayaran
            WHERE id = :id
        ");

        $cek->execute([
            ':id' => $id
        ]);


        if (!$cek->fetch()) {

            throw new Exception(
                "Pembayaran tidak ditemukan."
            );

        }


        /*
        | Cek apakah pesanan lain
        | sudah memakai pembayaran ini.
        */

        $cekPesanan = $pdo->prepare("
            SELECT id
            FROM pembayaran
            WHERE pesanan_id = :pesanan_id
            AND id != :id
        ");

        $cekPesanan->execute([
            ':pesanan_id' => $pesanan_id,
            ':id' => $id
        ]);


        if ($cekPesanan->fetch()) {

            throw new Exception(
                "Pesanan sudah memiliki pembayaran."
            );

        }


        /*
        | UPDATE
        */

        $stmt = $pdo->prepare("
            UPDATE pembayaran
            SET
                pesanan_id = :pesanan_id,
                total_bayar = :total_bayar,
                metode_pembayaran = :metode_pembayaran,
                status = :status
            WHERE id = :id
        ");


        $stmt->execute([

            ':pesanan_id' =>
                $pesanan_id,

            ':total_bayar' =>
                $total_bayar,

            ':metode_pembayaran' =>
                $metode_pembayaran,

            ':status' =>
                $status,

            ':id' =>
                $id

        ]);


        $pdo->commit();


        header(
            "Location: index.php?pesan=edit"
        );

        exit;

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


} catch (Exception $e) {


    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }


    header(
        "Location: index.php?pesan=gagal"
    );

    exit;

}