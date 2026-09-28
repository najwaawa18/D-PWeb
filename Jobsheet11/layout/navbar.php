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
    <a href="/Jobsheet11/index.php">
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

            <a href="/Jobsheet11/master/kategori/index.php">
                Kategori
            </a>

            <a href="/Jobsheet11/master/menu/index.php">
                Menu
            </a>

            <a href="/Jobsheet11/master/pelanggan/index.php">
                Pelanggan
            </a>

            <a href="/Jobsheet11/master/meja/index.php">
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

            <a href="/Jobsheet11/transaksi/pesanan/index.php">
                Pesanan
            </a>

            <a href="/Jobsheet11/transaksi/pembayaran/index.php">
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

            <a href="/Jobsheet11/laporan/penjualan.php">
                Penjualan
            </a>

            <a href="/Jobsheet11/laporan/menu_terlaris.php">
                Menu Terlaris
            </a>

            <a href="/Jobsheet11/laporan/pelanggan.php">
                Pelanggan
            </a>

        </div>

    </div>



    <?php if (isset($_SESSION['user_id'])): ?>

        <div class="nav-group">

            <button
                type="button"
                class="nav-dropdown-toggle"
                aria-expanded="false">

                <span>
                    <?= htmlspecialchars($_SESSION['user_name'] ?? $_SESSION['username'] ?? 'User'); ?>
                </span>
                <span class="arrow">⌄</span>

            </button>

            <div class="dropdown">

                <a href="/Jobsheet11/auth/logout.php">
                    Logout
                </a>

            </div>

        </div>

    <?php else: ?>

        <a href="/Jobsheet11/auth/login.php">
            Login
        </a>

        <a href="/Jobsheet11/auth/register.php">
            Register
        </a>

    <?php endif; ?>

</nav>