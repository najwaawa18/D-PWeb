<?php
require_once __DIR__ . '/../config/database.php';

$sql = "
    SELECT
        p.kode_pesanan,
        p.tanggal_pesanan,
        COALESCE(pl.nama, '-') AS nama_pelanggan,
        COALESCE(m.nomor_meja, '-') AS nomor_meja,
        p.status,
        p.total
    FROM pesanan p
    LEFT JOIN pelanggan pl
        ON p.pelanggan_id = pl.id
    LEFT JOIN meja m
        ON p.meja_id = m.id
    ORDER BY p.tanggal_pesanan DESC
";

$stmt = $pdo->query($sql);
$data = $stmt->fetchAll();

$totalPenjualan = 0;

foreach ($data as $row) {
    $totalPenjualan += $row['total'];
}

require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/navbar.php';
?>

<div class="container">

    <section>

        <h2>Laporan Penjualan</h2>

        <p>
            Daftar transaksi penjualan Cafe_Najwa.
        </p>

        <div class="card">
            <strong>Total Penjualan</strong>

            <h2>
                Rp <?= number_format($totalPenjualan, 0, ',', '.') ?>
            </h2>
        </div>

        <br>

        <div class="table-responsive">

            <table>

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Pesanan</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Meja</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (empty($data)): ?>

                    <tr>
                        <td colspan="7">
                            Belum ada data penjualan.
                        </td>
                    </tr>

                <?php else: ?>

                    <?php foreach ($data as $i => $row): ?>

                        <tr>

                            <td>
                                <?= $i + 1 ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['kode_pesanan']) ?>
                            </td>

                            <td>
                                <?= date(
                                    'd-m-Y H:i',
                                    strtotime($row['tanggal_pesanan'])
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['nama_pelanggan']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['nomor_meja']) ?>
                            </td>

                            <td>
                                <span class="badge">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>

                            <td>
                                Rp <?= number_format(
                                    $row['total'],
                                    0,
                                    ',',
                                    '.'
                                ) ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </section>

</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>