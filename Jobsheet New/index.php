<?php

$page_title = "Dashboard";

require __DIR__ . "/config/database.php";
require __DIR__ . "/layout/header.php";

?>

<section>

    <h2>
        Selamat Datang di Cafe_Najwa ☕
    </h2>

    <p>
        Sistem Informasi Manajemen Cafe
    </p>

    <p>
        Silakan gunakan menu navigasi
        untuk mengelola data cafe.
    </p>

</section>


<section>

    <h2>
        Modul Cafe_Najwa
    </h2>

    <div class="actions">

        <a
            class="btn"
            href="/master/kategori/index.php">
            Kategori
        </a>


        <a
            class="btn"
            href="/master/menu/index.php">
            Menu
        </a>


        <a
            class="btn"
            href="/master/pelanggan/index.php">
            Pelanggan
        </a>


        <a
            class="btn"
            href="/master/meja/index.php">
            Meja
        </a>


        <a
            class="btn"
            href="/transaksi/pesanan/index.php">
            Pesanan
        </a>


        <a
            class="btn"
            href="/transaksi/pembayaran/index.php">
            Pembayaran
        </a>

    </div>

</section>


<?php

require __DIR__ . "/layout/footer.php";

?>