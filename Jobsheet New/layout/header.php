<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = $page_title ?? "Dashboard";

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Cafe_Najwa
        <?php echo $page_title ? " | " . htmlspecialchars($page_title) : ""; ?>
    </title>

    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

<header class="site-header">

    <div class="brand">
        <h1>Cafe_Najwa</h1>

        <span>
            Sistem Informasi Manajemen Cafe
        </span>
    </div>

    <?php include __DIR__ . "/navbar.php"; ?>

</header>

<main class="container">