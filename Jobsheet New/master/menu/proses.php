<?php

require __DIR__ . "/../../config/database.php";

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';


/*
|--------------------------------------------------------------------------
| TAMBAH MENU
|--------------------------------------------------------------------------
*/

if ($aksi === 'tambah') {

    $kode_menu = trim(
        $_POST['kode_menu'] ?? ''
    );

    $nama_menu = trim(
        $_POST['nama_menu'] ?? ''
    );

    $kategori_id = $_POST['kategori_id'] ?? '';

    $harga = $_POST['harga'] ?? '';

    $stok = $_POST['stok'] ?? '';

    $status = $_POST['status'] ?? 'Tersedia';


    if (
        $kode_menu === '' ||
        $nama_menu === '' ||
        $kategori_id === '' ||
        $harga === '' ||
        $stok === ''
    ) {

        header("Location: form.php");
        exit;

    }


    if (
        !is_numeric($harga) ||
        (float)$harga < 0
    ) {

        header("Location: form.php");
        exit;

    }


    if (
        !is_numeric($stok) ||
        (int)$stok < 0
    ) {

        header("Location: form.php");
        exit;

    }


    $status_valid = [
        'Tersedia',
        'Tidak Tersedia'
    ];


    if (!in_array(
        $status,
        $status_valid,
        true
    )) {

        header("Location: form.php");
        exit;

    }


    try {

        $stmt = $pdo->prepare("
            INSERT INTO menu (
                kode_menu,
                nama_menu,
                kategori_id,
                harga,
                stok,
                status
            )
            VALUES (
                :kode_menu,
                :nama_menu,
                :kategori_id,
                :harga,
                :stok,
                :status
            )
        ");


        $stmt->execute([

            ':kode_menu' => $kode_menu,

            ':nama_menu' => $nama_menu,

            ':kategori_id' => (int)$kategori_id,

            ':harga' => (float)$harga,

            ':stok' => (int)$stok,

            ':status' => $status

        ]);


        header(
            "Location: index.php?pesan=tambah"
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
| EDIT MENU
|--------------------------------------------------------------------------
*/

if ($aksi === 'edit') {

    $id = $_POST['id'] ?? '';

    $kode_menu = trim(
        $_POST['kode_menu'] ?? ''
    );

    $nama_menu = trim(
        $_POST['nama_menu'] ?? ''
    );

    $kategori_id = $_POST['kategori_id'] ?? '';

    $harga = $_POST['harga'] ?? '';

    $stok = $_POST['stok'] ?? '';

    $status = $_POST['status'] ?? 'Tersedia';


    if (
        $id === '' ||
        $kode_menu === '' ||
        $nama_menu === '' ||
        $kategori_id === '' ||
        $harga === '' ||
        $stok === ''
    ) {

        header(
            "Location: index.php?pesan=gagal"
        );

        exit;

    }


    if (
        !is_numeric($harga) ||
        (float)$harga < 0
    ) {

        header(
            "Location: index.php?pesan=gagal"
        );

        exit;

    }


    if (
        !is_numeric($stok) ||
        (int)$stok < 0
    ) {

        header(
            "Location: index.php?pesan=gagal"
        );

        exit;

    }


    $status_valid = [
        'Tersedia',
        'Tidak Tersedia'
    ];


    if (!in_array(
        $status,
        $status_valid,
        true
    )) {

        header(
            "Location: index.php?pesan=gagal"
        );

        exit;

    }


    try {

        $stmt = $pdo->prepare("
            UPDATE menu

            SET
                kode_menu = :kode_menu,
                nama_menu = :nama_menu,
                kategori_id = :kategori_id,
                harga = :harga,
                stok = :stok,
                status = :status

            WHERE id = :id
        ");


        $stmt->execute([

            ':kode_menu' => $kode_menu,

            ':nama_menu' => $nama_menu,

            ':kategori_id' => (int)$kategori_id,

            ':harga' => (float)$harga,

            ':stok' => (int)$stok,

            ':status' => $status,

            ':id' => $id

        ]);


        header(
            "Location: index.php?pesan=edit"
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
| HAPUS MENU
|--------------------------------------------------------------------------
*/

if ($aksi === 'hapus') {

    $id = $_GET['id'] ?? '';


    if ($id === '') {

        header(
            "Location: index.php?pesan=gagal"
        );

        exit;

    }


    try {

        $stmt = $pdo->prepare("
            DELETE FROM menu
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
| AKSI TIDAK DIKENAL
|--------------------------------------------------------------------------
*/

header(
    "Location: index.php?pesan=gagal"
);

exit;