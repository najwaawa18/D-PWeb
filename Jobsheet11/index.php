<?php

$page_title = "Dashboard — Jobsheet 11";

require __DIR__ . "/includes/auth.php";
require __DIR__ . "/config/database.php";
require __DIR__ . "/layout/header.php";

?>

<section>

    <h2>
        Selamat Datang di Cafe_Najwa
    </h2>

    <p>
        Jobsheet 11 — Security Aplikasi Web
    </p>

    <p>
        Jobsheet ini menerapkan dan menguji beberapa
        mekanisme keamanan pada aplikasi Cafe_Najwa,
        seperti CSRF, XSS, Session Fixation,
        dan SQL Injection.
    </p>

</section>


<section>

    <h2>
        Modul Cafe_Najwa
    </h2>

    <div class="actions">

        <a
            class="btn"
            href="/Jobsheet11/master/kategori/index.php">
            Kategori
        </a>

        <a
            class="btn"
            href="/Jobsheet11/master/menu/index.php">
            Menu
        </a>

        <a
            class="btn"
            href="/Jobsheet11/master/pelanggan/index.php">
            Pelanggan
        </a>

        <a
            class="btn"
            href="/Jobsheet11/master/meja/index.php">
            Meja
        </a>

        <a
            class="btn"
            href="/Jobsheet11/transaksi/pesanan/index.php">
            Pesanan
        </a>

        <a
            class="btn"
            href="/Jobsheet11/transaksi/pembayaran/index.php">
            Pembayaran
        </a>

        <a
            class="btn"
            href="/Jobsheet11/laporan/index.php">
            Laporan
        </a>

    </div>

</section>


<?php

require __DIR__ . "/layout/footer.php";

?>