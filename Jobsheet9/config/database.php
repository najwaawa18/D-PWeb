<?php

// ======================================================
// LOAD .ENV UNTUK LOCALHOST
// ======================================================

$envFile = __DIR__ . '/../.env';

if (file_exists($envFile)) {

    $lines = file(
        $envFile,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );

    foreach ($lines as $line) {

        $line = trim($line);

        if (
            $line === '' ||
            str_starts_with($line, '#')
        ) {
            continue;
        }

        [$key, $value] = array_pad(
            explode('=', $line, 2),
            2,
            ''
        );

        $key = trim($key);
        $value = trim($value);

        if ($key !== '') {
            putenv("$key=$value");
        }
    }
}


// ======================================================
// AMBIL KONFIGURASI DATABASE
// ======================================================

$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: '5432';
$dbname = getenv('DB_NAME') ?: 'postgres';
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');


// ======================================================
// KONEKSI DATABASE
// ======================================================

try {

    if (
        !$host ||
        !$username ||
        !$password
    ) {

        throw new Exception(
            "Environment variable database belum lengkap."
        );
    }


    $pdo = new PDO(
        "pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require",
        $username,
        $password
    );


    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );


    $pdo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );


} catch (PDOException $e) {

    die(
        "Koneksi database gagal: " .
        $e->getMessage()
    );

} catch (Exception $e) {

    die(
        "Konfigurasi database gagal: " .
        $e->getMessage()
    );
}