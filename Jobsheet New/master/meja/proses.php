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

    $nomor_meja = trim(
        $_POST['nomor_meja'] ?? ''
    );

    $kapasitas = $_POST['kapasitas'] ?? '';

    $status = $_POST['status'] ?? 'Kosong';


    // ======================================
    // VALIDASI
    // ======================================

    if (
        $nomor_meja === '' ||
        $kapasitas === '' ||
        !is_numeric($kapasitas) ||
        (int)$kapasitas < 1
    ) {

        header("Location: form.php");
        exit;

    }


    // ======================================
    // VALIDASI STATUS
    // ======================================

    $status_valid = [
        'Kosong',
        'Terisi',
        'Dipesan'
    ];

    if (!in_array($status, $status_valid, true)) {

        header("Location: form.php");
        exit;

    }


    try {

        $stmt = $pdo->prepare("
            INSERT INTO meja (
                nomor_meja,
                kapasitas,
                status
            )
            VALUES (
                :nomor_meja,
                :kapasitas,
                :status
            )
        ");

        $stmt->execute([
            ':nomor_meja' => $nomor_meja,
            ':kapasitas' => (int)$kapasitas,
            ':status' => $status
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

    $nomor_meja = trim(
        $_POST['nomor_meja'] ?? ''
    );

    $kapasitas = $_POST['kapasitas'] ?? '';

    $status = $_POST['status'] ?? 'Kosong';


    // ======================================
    // VALIDASI
    // ======================================

    if (
        $id === '' ||
        $nomor_meja === '' ||
        $kapasitas === '' ||
        !is_numeric($kapasitas) ||
        (int)$kapasitas < 1
    ) {

        header("Location: index.php?pesan=gagal");
        exit;

    }


    // ======================================
    // VALIDASI STATUS
    // ======================================

    $status_valid = [
        'Kosong',
        'Terisi',
        'Dipesan'
    ];

    if (!in_array($status, $status_valid, true)) {

        header("Location: index.php?pesan=gagal");
        exit;

    }


    try {

        $stmt = $pdo->prepare("
            UPDATE meja
            SET
                nomor_meja = :nomor_meja,
                kapasitas = :kapasitas,
                status = :status
            WHERE id = :id
        ");

        $stmt->execute([
            ':nomor_meja' => $nomor_meja,
            ':kapasitas' => (int)$kapasitas,
            ':status' => $status,
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
            DELETE FROM meja
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);


        header("Location: index.php?pesan=hapus");
        exit;


    } catch (PDOException $e) {

        /*
         * Jika meja sudah digunakan oleh
         * data pesanan, PostgreSQL akan
         * menangani relasi sesuai foreign key.
         */

        header("Location: index.php?pesan=gagal");
        exit;

    }

}


// ==========================================
// AKSI TIDAK DIKENAL
// ==========================================

header("Location: index.php?pesan=gagal");
exit;