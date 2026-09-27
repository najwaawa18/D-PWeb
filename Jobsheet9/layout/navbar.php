<button
    type="button"
    class="nav-toggle"
    id="navToggle"
    aria-label="Buka menu"
    aria-expanded="false">
    ☰
</button>

<nav id="mainNav">

    <!-- DASHBOARD -->
    <a href="/Jobsheet9/index.php">
        Dashboard
    </a>


    <!-- MASTER DATA -->
    <div class="nav-group">

        <button
            type="button"
            class="nav-dropdown-toggle"
            aria-expanded="false">

            <span>Master Data</span>
            <span class="arrow">⌄</span>

        </button>

        <div class="dropdown">

            <a href="/Jobsheet9/master/kategori/index.php">
                Kategori
            </a>

            <a href="/Jobsheet9/master/menu/index.php">
                Menu
            </a>

            <a href="/Jobsheet9/master/pelanggan/index.php">
                Pelanggan
            </a>

            <a href="/Jobsheet9/master/meja/index.php">
                Meja
            </a>

        </div>

    </div>


    <!-- TRANSAKSI -->
    <div class="nav-group">

        <button
            type="button"
            class="nav-dropdown-toggle"
            aria-expanded="false">

            <span>Transaksi</span>
            <span class="arrow">⌄</span>

        </button>

        <div class="dropdown">

            <a href="/Jobsheet9/transaksi/pesanan/index.php">
                Pesanan
            </a>

            <a href="/Jobsheet9/transaksi/pembayaran/index.php">
                Pembayaran
            </a>

        </div>

    </div>


    <!-- LAPORAN -->
    <div class="nav-group">

        <button
            type="button"
            class="nav-dropdown-toggle"
            aria-expanded="false">

            <span>Laporan</span>
            <span class="arrow">⌄</span>

        </button>

        <div class="dropdown">

            <a href="/Jobsheet9/laporan/penjualan.php">
                Penjualan
            </a>

            <a href="/Jobsheet9/laporan/menu_terlaris.php">
                Menu Terlaris
            </a>

            <a href="/Jobsheet9/laporan/pelanggan.php">
                Pelanggan
            </a>

        </div>

    </div>

</nav>