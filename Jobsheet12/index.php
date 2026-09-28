<?php

require_once __DIR__ . "/includes/auth.php";
require __DIR__ . "/config/database.php";

$page_title = "Dashboard — Jobsheet 12";

$jumlahMenu = (int) $pdo->query("SELECT COUNT(*) FROM menu")->fetchColumn();
$jumlahPelanggan = (int) $pdo->query("SELECT COUNT(*) FROM pelanggan")->fetchColumn();
$jumlahPesanan = (int) $pdo->query("SELECT COUNT(*) FROM pesanan")->fetchColumn();
$sedangProses = (int) $pdo->query("SELECT COUNT(*) FROM pesanan WHERE status = 'Proses'")->fetchColumn();
$jumlahPembayaran = (int) $pdo->query("SELECT COUNT(*) FROM pembayaran")->fetchColumn();
$pendapatan = (float) $pdo->query("SELECT COALESCE(SUM(total_bayar), 0) FROM pembayaran WHERE status = 'Lunas'")->fetchColumn();

$pesananTerbaru = $pdo->query("
    SELECT
        pesanan.kode_pesanan,
        pelanggan.nama AS nama_pelanggan,
        pesanan.status,
        pesanan.total,
        pesanan.tanggal_pesanan
    FROM pesanan
    LEFT JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.id
    ORDER BY pesanan.id DESC
    LIMIT 5
")->fetchAll();

require __DIR__ . "/layout/header.php";

?>

<section>

    <h2>Selamat Datang di Cafe_Najwa</h2>

    <p>
        Jobsheet 12 — Integrasi Transaksi Cafe_Najwa
    </p>

    <p>
        Jobsheet ini melanjutkan Jobsheet 11 dengan mengintegrasikan
        data menu, pelanggan, pesanan, detail pesanan, meja, dan pembayaran
        dalam satu alur transaksi yang utuh.
    </p>

</section>

<section>

    <h2>Ringkasan Cafe_Najwa</h2>

    <div class="stats">

        <div class="card">
            <strong><?= $jumlahMenu; ?></strong>
            <span>Total Menu</span>
        </div>

        <div class="card">
            <strong><?= $jumlahPelanggan; ?></strong>
            <span>Total Pelanggan</span>
        </div>

        <div class="card">
            <strong><?= $jumlahPesanan; ?></strong>
            <span>Total Pesanan</span>
        </div>

        <div class="card">
            <strong><?= $sedangProses; ?></strong>
            <span>Sedang Diproses</span>
        </div>

        <div class="card">
            <strong><?= $jumlahPembayaran; ?></strong>
            <span>Total Pembayaran</span>
        </div>

        <div class="card">
            <strong>Rp <?= number_format($pendapatan, 0, ',', '.'); ?></strong>
            <span>Pendapatan Lunas</span>
        </div>

    </div>

</section>

<section>

    <div style="display:flex; justify-content:space-between; align-items:center; gap:15px; flex-wrap:wrap;">
        <div>
            <h2>Pesanan Terbaru</h2>
            <p>Data transaksi terbaru yang terhubung dengan pelanggan dan pembayaran.</p>
        </div>

        <a href="/Jobsheet12/transaksi/pesanan/form.php" class="btn">
            + Tambah Pesanan
        </a>
    </div>

    <div class="table-responsive">

        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($pesananTerbaru): ?>
                    <?php foreach ($pesananTerbaru as $pesanan): ?>
                        <tr>
                            <td><?= htmlspecialchars($pesanan['kode_pesanan']); ?></td>
                            <td><?= htmlspecialchars($pesanan['nama_pelanggan'] ?? '-'); ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($pesanan['tanggal_pesanan'])); ?></td>
                            <td><?= htmlspecialchars($pesanan['status']); ?></td>
                            <td>Rp <?= number_format($pesanan['total'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Belum ada data pesanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

</section>

<section>

    <h2>Alur Integrasi</h2>

    <div class="actions">
        <a class="btn" href="/Jobsheet12/master/menu/index.php">Menu</a>
        <a class="btn" href="/Jobsheet12/master/pelanggan/index.php">Pelanggan</a>
        <a class="btn" href="/Jobsheet12/master/meja/index.php">Meja</a>
        <a class="btn" href="/Jobsheet12/transaksi/pesanan/index.php">Pesanan</a>
        <a class="btn" href="/Jobsheet12/transaksi/pembayaran/index.php">Pembayaran</a>
        <a class="btn" href="/Jobsheet12/laporan/penjualan.php">Laporan Penjualan</a>
    </div>

</section>

<?php require __DIR__ . "/layout/footer.php"; ?>
