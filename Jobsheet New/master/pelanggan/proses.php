<?php

require __DIR__ . "/../../config/database.php";

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';


/*
|--------------------------------------------------------------------------
| TAMBAH PELANGGAN
|--------------------------------------------------------------------------
*/

if ($aksi === 'tambah') {

    $kode_pelanggan = trim(
        $_POST['kode_pelanggan'] ?? ''
    );

    $nama = trim(
        $_POST['nama'] ?? ''
    );

    $no_hp = trim(
        $_POST['no_hp'] ?? ''
    );

    $email = trim(
        $_POST['email'] ?? ''
    );


    if (
        $kode_pelanggan === '' ||
        $nama === ''
    ) {

        header("Location: form.php");
        exit;

    }


    try {

        $stmt = $pdo->prepare("
            INSERT INTO pelanggan (
                kode_pelanggan,
                nama,
                no_hp,
                email
            )
            VALUES (
                :kode_pelanggan,
                :nama,
                :no_hp,
                :email
            )
        ");


        $stmt->execute([

            ':kode_pelanggan' => $kode_pelanggan,

            ':nama' => $nama,

            ':no_hp' => $no_hp !== ''
                ? $no_hp
                : null,

            ':email' => $email !== ''
                ? $email
                : null

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
| EDIT PELANGGAN
|--------------------------------------------------------------------------
*/

if ($aksi === 'edit') {

    $id = $_POST['id'] ?? '';

    $kode_pelanggan = trim(
        $_POST['kode_pelanggan'] ?? ''
    );

    $nama = trim(
        $_POST['nama'] ?? ''
    );

    $no_hp = trim(
        $_POST['no_hp'] ?? ''
    );

    $email = trim(
        $_POST['email'] ?? ''
    );


    if (
        $id === '' ||
        $kode_pelanggan === '' ||
        $nama === ''
    ) {

        header(
            "Location: index.php?pesan=gagal"
        );

        exit;

    }


    try {

        $stmt = $pdo->prepare("
            UPDATE pelanggan

            SET
                kode_pelanggan = :kode_pelanggan,
                nama = :nama,
                no_hp = :no_hp,
                email = :email

            WHERE id = :id
        ");


        $stmt->execute([

            ':kode_pelanggan' => $kode_pelanggan,

            ':nama' => $nama,

            ':no_hp' => $no_hp !== ''
                ? $no_hp
                : null,

            ':email' => $email !== ''
                ? $email
                : null,

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
| HAPUS PELANGGAN
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
            DELETE FROM pelanggan
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