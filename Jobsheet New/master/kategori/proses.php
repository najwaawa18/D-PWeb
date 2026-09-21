<?php

require __DIR__ . "/../../config/database.php";


// ==========================================
// CEK AKSI
// ==========================================

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';


// ==========================================
// TAMBAH DATA
// ==========================================

if ($aksi === 'tambah') {

    $nama_kategori = trim($_POST['nama_kategori'] ?? '');


    // Validasi kosong

    if ($nama_kategori === '') {

        header("Location: form.php");
        exit;

    }


    try {

        $stmt = $pdo->prepare("
            INSERT INTO kategori (nama_kategori)
            VALUES (:nama_kategori)
        ");

        $stmt->execute([
            ':nama_kategori' => $nama_kategori
        ]);


        header("Location: index.php?pesan=tambah");
        exit;


    } catch (PDOException $e) {

        header("Location: index.php?pesan=gagal");
        exit;

    }

}


// ==========================================
// EDIT DATA
// ==========================================

if ($aksi === 'edit') {

    $id = $_POST['id'] ?? '';

    $nama_kategori = trim(
        $_POST['nama_kategori'] ?? ''
    );


    // Validasi

    if ($id === '' || $nama_kategori === '') {

        header("Location: index.php?pesan=gagal");
        exit;

    }


    try {

        $stmt = $pdo->prepare("
            UPDATE kategori
            SET nama_kategori = :nama_kategori
            WHERE id = :id
        ");

        $stmt->execute([
            ':nama_kategori' => $nama_kategori,
            ':id' => $id
        ]);


        header("Location: index.php?pesan=edit");
        exit;


    } catch (PDOException $e) {

        header("Location: index.php?pesan=gagal");
        exit;

    }

}


// ==========================================
// HAPUS DATA
// ==========================================

if ($aksi === 'hapus') {

    $id = $_GET['id'] ?? '';


    if ($id === '') {

        header("Location: index.php?pesan=gagal");
        exit;

    }


    try {

        $stmt = $pdo->prepare("
            DELETE FROM kategori
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);


        header("Location: index.php?pesan=hapus");
        exit;


    } catch (PDOException $e) {

        /*
         * DELETE bisa gagal jika kategori
         * sudah digunakan oleh tabel menu.
         *
         * Karena foreign key menggunakan
         * ON DELETE RESTRICT.
         */

        header("Location: index.php?pesan=gagal");
        exit;

    }

}


// ==========================================
// JIKA AKSI TIDAK DIKENAL
// ==========================================

header("Location: index.php?pesan=gagal");
exit;