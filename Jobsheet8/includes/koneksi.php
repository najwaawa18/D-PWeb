<?php

$host = getenv('SIMPS_DB_HOST');
$port = getenv('SIMPS_DB_PORT');
$db   = getenv('SIMPS_DB_NAME');
$user = getenv('SIMPS_DB_USER');
$pass = getenv('SIMPS_DB_PASSWORD');

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$db",
        $user,
        $pass
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}