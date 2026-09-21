<?php
require_once __DIR__ . '/../config/database.php';

$sql = "
    SELECT
        pl.kode_pelanggan,
        pl.nama,
        pl.no_hp,
        pl.email,
        COUNT(p.id) AS jumlah_pesanan,
        COALESCE(SUM(p.total), 0) AS total_transaksi
    FROM pelanggan pl
    LEFT JOIN pesanan p
        ON pl.id = p.pelanggan_id
    GROUP BY
        pl.id,
        pl.kode_pelanggan,
        pl.nama,
        pl.no_hp,
        pl.email
    ORDER BY total_transaksi DESC
";

$stmt = $pdo->query($sql);
$data = $stmt->fetchAll();

require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/navbar.php';
?>

<div class="container">

    <section>

        <h2>Laporan Pelanggan</h2>

        <p>
            Ringkasan aktivitas transaksi pelanggan Cafe_Najwa.
        </p>

        <div class="table-responsive">

            <table>

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Pelanggan</th>
                        <th>Nama</th>
                        <th>No. HP</th>
                        <th>Email</th>
                        <th>Jumlah Pesanan</th>
                        <th>Total Transaksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (empty($data)): ?>

                    <tr>
                        <td colspan="7">
                            Belum ada data pelanggan.
                        </td>
                    </tr>

                <?php else: ?>

                    <?php foreach ($data as $i => $row): ?>

                        <tr>

                            <td>
                                <?= $i + 1 ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $row['kode_pelanggan']
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $row['nama']
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $row['no_hp'] ?? '-'
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $row['email'] ?? '-'
                                ) ?>
                            </td>

                            <td>
                                <?= $row['jumlah_pesanan'] ?>
                            </td>

                            <td>
                                Rp <?= number_format(
                                    $row['total_transaksi'],
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