<?php
require_once __DIR__ . '/../config/database.php';

$sql = "
    SELECT
        m.kode_menu,
        m.nama_menu,
        k.nama_kategori,
        SUM(dp.jumlah) AS total_terjual,
        SUM(dp.subtotal) AS total_pendapatan
    FROM detail_pesanan dp
    INNER JOIN menu m
        ON dp.menu_id = m.id
    INNER JOIN kategori k
        ON m.kategori_id = k.id
    INNER JOIN pesanan p
        ON dp.pesanan_id = p.id
    GROUP BY
        m.id,
        m.kode_menu,
        m.nama_menu,
        k.nama_kategori
    ORDER BY total_terjual DESC
";

$stmt = $pdo->query($sql);
$data = $stmt->fetchAll();

require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/navbar.php';
?>

<div class="container">

    <section>

        <h2>Laporan Menu Terlaris</h2>

        <p>
            Daftar menu berdasarkan jumlah yang terjual.
        </p>

        <div class="table-responsive">

            <table>

                <thead>
                    <tr>
                        <th>Ranking</th>
                        <th>Kode Menu</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Jumlah Terjual</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (empty($data)): ?>

                    <tr>
                        <td colspan="6">
                            Belum ada data penjualan menu.
                        </td>
                    </tr>

                <?php else: ?>

                    <?php foreach ($data as $i => $row): ?>

                        <tr>

                            <td>
                                <strong>
                                    <?= $i + 1 ?>
                                </strong>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['kode_menu']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['nama_menu']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['nama_kategori']) ?>
                            </td>

                            <td>
                                <?= $row['total_terjual'] ?> porsi
                            </td>

                            <td>
                                Rp <?= number_format(
                                    $row['total_pendapatan'],
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