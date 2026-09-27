<?php

$page_title = "Dashboard — Jobsheet 10";

require __DIR__ . "/config/database.php";
require __DIR__ . "/layout/header.php";

?>

<section>

    <h2>
        Selamat Datang di Jobsheet 9
    </h2>

    <p>
        Jobsheet 10 — Autentikasi & Manajemen Sesi Pengguna
    </p>

    <p>
        Silakan gunakan menu navigasi
        untuk mengelola data.
    </p>

</section>


<section>

    <h2>
        Modul Jobsheet 9
    </h2>

    <div class="actions">

        <a
            class="btn"
            href="/Jobsheet10/master/kategori/index.php">
            Kategori
        </a>

        <a
            class="btn"
            href="/Jobsheet10/master/menu/index.php">
            Menu
        </a>

        <a
            class="btn"
            href="/Jobsheet10/master/pelanggan/index.php">
            Pelanggan
        </a>

        <a
            class="btn"
            href="/Jobsheet10/master/meja/index.php">
            Meja
        </a>

        <a
            class="btn"
            href="/Jobsheet10/transaksi/pesanan/index.php">
            Pesanan
        </a>

        <a
            class="btn"
            href="/Jobsheet10/transaksi/pembayaran/index.php">
            Pembayaran
        </a>

        <a
            class="btn"
            href="/Jobsheet10/laporan/index.php">
            Laporan
        </a>

    </div>

</section>


<?php

require __DIR__ . "/layout/footer.php";

?>