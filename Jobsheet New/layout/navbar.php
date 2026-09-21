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
    <a href="/index.php">
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

            <a href="/master/kategori/index.php">
                Kategori
            </a>

            <a href="/master/menu/index.php">
                Menu
            </a>

            <a href="/master/pelanggan/index.php">
                Pelanggan
            </a>

            <a href="/master/meja/index.php">
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

            <a href="/transaksi/pesanan/index.php">
                Pesanan
            </a>

            <a href="/transaksi/pembayaran/index.php">
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

            <a href="/laporan/penjualan.php">
                Penjualan
            </a>

            <a href="/laporan/menu_terlaris.php">
                Menu Terlaris
            </a>

            <a href="/laporan/pelanggan.php">
                Pelanggan
            </a>

        </div>

    </div>

</nav>