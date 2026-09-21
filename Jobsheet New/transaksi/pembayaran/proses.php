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

        header(
            "Location: index.php?pesan=gagal"
        );

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

if (
    $_SERVER['REQUEST_METHOD'] !== 'POST'
) {

    header(
        "Location: index.php"
    );

    exit;

}


/*
|--------------------------------------------------------------------------
| AMBIL DATA
|--------------------------------------------------------------------------
*/

$aksi =
    $_POST['aksi'] ?? '';

$id =
    $_POST['id'] ?? null;


$pesanan_id =
    !empty($_POST['pesanan_id'])
        ? (int) $_POST['pesanan_id']
        : 0;


$tanggal_bayar =
    $_POST['tanggal_bayar'] ?? '';


$total_bayar =
    isset($_POST['total_bayar'])
        ? (float) $_POST['total_bayar']
        : 0;


$metode_pembayaran =
    $_POST['metode_pembayaran'] ?? '';


$status =
    $_POST['status'] ?? 'Lunas';


/*
|--------------------------------------------------------------------------
| VALIDASI METODE DAN STATUS
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


/*
|--------------------------------------------------------------------------
| VALIDASI PESANAN
|--------------------------------------------------------------------------
*/

if ($pesanan_id <= 0) {

    header(
        "Location: index.php?pesan=gagal"
    );

    exit;

}


/*
|--------------------------------------------------------------------------
| VALIDASI TANGGAL
|--------------------------------------------------------------------------
*/

if ($tanggal_bayar === '') {

    header(
        "Location: index.php?pesan=gagal"
    );

    exit;

}


/*
|--------------------------------------------------------------------------
| KONVERSI TANGGAL
|--------------------------------------------------------------------------
*/

$timestamp =
    strtotime($tanggal_bayar);


if ($timestamp === false) {

    header(
        "Location: index.php?pesan=gagal"
    );

    exit;

}


$tanggal_bayar_db =
    date(
        'Y-m-d H:i:s',
        $timestamp
    );


/*
|--------------------------------------------------------------------------
| VALIDASI TOTAL
|--------------------------------------------------------------------------
*/

if ($total_bayar < 0) {

    header(
        "Location: index.php?pesan=gagal"
    );

    exit;

}


/*
|--------------------------------------------------------------------------
| VALIDASI METODE
|--------------------------------------------------------------------------
*/

if (!in_array(
    $metode_pembayaran,
    $metodeValid,
    true
)) {

    header(
        "Location: index.php?pesan=gagal"
    );

    exit;

}


/*
|--------------------------------------------------------------------------
| VALIDASI STATUS
|--------------------------------------------------------------------------
*/

if (!in_array(
    $status,
    $statusValid,
    true
)) {

    header(
        "Location: index.php?pesan=gagal"
    );

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


    $pesanan =
        $stmtPesanan->fetch();


    if (!$pesanan) {

        throw new Exception(
            "Pesanan tidak ditemukan."
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CEK TOTAL PEMBAYARAN
    |--------------------------------------------------------------------------
    |
    | Total pembayaran tidak boleh lebih
    | besar daripada total pesanan.
    |
    */

    if (
        $total_bayar >
        (float) $pesanan['total']
    ) {

        throw new Exception(
            "Total pembayaran melebihi total pesanan."
        );

    }


    /*
    |--------------------------------------------------------------------------
    | TAMBAH PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    if ($aksi === 'tambah') {


        /*
        | Satu pesanan hanya boleh
        | memiliki satu pembayaran.
        */

        $cekPembayaran =
            $pdo->prepare("
                SELECT id
                FROM pembayaran
                WHERE pesanan_id = :pesanan_id
            ");


        $cekPembayaran->execute([
            ':pesanan_id' =>
                $pesanan_id
        ]);


        if ($cekPembayaran->fetch()) {

            throw new Exception(
                "Pesanan sudah memiliki pembayaran."
            );

        }


        /*
        | INSERT
        */

        $stmt = $pdo->prepare("
            INSERT INTO pembayaran (
                pesanan_id,
                tanggal_bayar,
                total_bayar,
                metode_pembayaran,
                status
            )
            VALUES (
                :pesanan_id,
                :tanggal_bayar,
                :total_bayar,
                :metode_pembayaran,
                :status
            )
        ");


        $stmt->execute([

            ':pesanan_id' =>
                $pesanan_id,

            ':tanggal_bayar' =>
                $tanggal_bayar_db,

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
    | EDIT PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    elseif ($aksi === 'edit') {


        if (!$id) {

            throw new Exception(
                "ID pembayaran tidak ditemukan."
            );

        }


        /*
        | Cek pembayaran yang sedang diedit.
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
        | Cek apakah pesanan tersebut
        | sudah digunakan pembayaran lain.
        */

        $cekPesanan = $pdo->prepare("
            SELECT id
            FROM pembayaran
            WHERE pesanan_id = :pesanan_id
            AND id != :id
        ");


        $cekPesanan->execute([

            ':pesanan_id' =>
                $pesanan_id,

            ':id' =>
                $id

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
                tanggal_bayar = :tanggal_bayar,
                total_bayar = :total_bayar,
                metode_pembayaran = :metode_pembayaran,
                status = :status
            WHERE id = :id
        ");


        $stmt->execute([

            ':pesanan_id' =>
                $pesanan_id,

            ':tanggal_bayar' =>
                $tanggal_bayar_db,

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