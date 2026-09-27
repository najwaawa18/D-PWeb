<?php

$page_title = "Dashboard";

require __DIR__ . "/config/database.php";
require __DIR__ . "/layout/header.php";

?>

<section>

    <h2>
        Selamat Datang di Jobsheet 9
    </h2>

    <p>
        Sistem Informasi Manajemen dengan PostgreSQL
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
            href="/Jobsheet9/master/kategori/index.php">
            Kategori
        </a>

        <a
            class="btn"
            href="/Jobsheet9/master/menu/index.php">
            Menu
        </a>

        <a
            class="btn"
            href="/Jobsheet9/master/pelanggan/index.php">
            Pelanggan
        </a>

        <a
            class="btn"
            href="/Jobsheet9/master/meja/index.php">
            Meja
        </a>

        <a
            class="btn"
            href="/Jobsheet9/transaksi/pesanan/index.php">
            Pesanan
        </a>

        <a
            class="btn"
            href="/Jobsheet9/transaksi/pembayaran/index.php">
            Pembayaran
        </a>

        <a
            class="btn"
            href="/Jobsheet9/laporan/index.php">
            Laporan
        </a>

    </div>

</section>


<?php

require __DIR__ . "/layout/footer.php";

?>