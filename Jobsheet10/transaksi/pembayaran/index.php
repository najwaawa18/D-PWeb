<?php

require_once __DIR__ . "/../../includes/auth.php";


$page_title = "Pembayaran";

require __DIR__ . "/../../config/database.php";

$keyword = trim($_GET['keyword'] ?? '');
$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 5;

$whereSql = '';
$params = [];

if ($keyword !== '') {
    $whereSql = "WHERE (pesanan.kode_pesanan ILIKE :keyword OR pelanggan.nama ILIKE :keyword OR pembayaran.metode_pembayaran ILIKE :keyword OR pembayaran.status ILIKE :keyword)";
    $params[':keyword'] = '%' . $keyword . '%';
}

$countStmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM pembayaran INNER JOIN pesanan ON pembayaran.pesanan_id = pesanan.id LEFT JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.id
    $whereSql
");
$countStmt->execute($params);
$totalData = (int) $countStmt->fetchColumn();
$totalPages = max(1, (int) ceil($totalData / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$query = $pdo->prepare("
    SELECT
        pembayaran.id,
        pesanan.kode_pesanan,
        pelanggan.nama AS nama_pelanggan,
        pembayaran.tanggal_bayar,
        pembayaran.total_bayar,
        pembayaran.metode_pembayaran,
        pembayaran.status
    FROM pembayaran INNER JOIN pesanan ON pembayaran.pesanan_id = pesanan.id LEFT JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.id
    $whereSql
    ORDER BY pembayaran.id DESC
    LIMIT :limit OFFSET :offset
");

foreach ($params as $name => $value) {
    $query->bindValue($name, $value, PDO::PARAM_STR);
}
$query->bindValue(':limit', $perPage, PDO::PARAM_INT);
$query->bindValue(':offset', $offset, PDO::PARAM_INT);
$query->execute();

$pembayaran = $query->fetchAll(PDO::FETCH_ASSOC);

$pesan = $_GET['pesan'] ?? '';

?>

<?php require __DIR__ . "/../../layout/header.php"; ?>

<section>

    <div style="
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    ">

        <div>

            <h2>
                Data Pembayaran
            </h2>

            <p>
                Kelola pembayaran transaksi Cafe_Najwa.
            </p>

        </div>

        <a
            href="form.php"
            class="btn">

            + Tambah Pembayaran

        </a>

    </div>

</section>


<?php if ($pesan === 'tambah'): ?>

    <section>
        <p>
            ✅ Pembayaran berhasil ditambahkan.
        </p>
    </section>

<?php elseif ($pesan === 'edit'): ?>

    <section>
        <p>
            ✅ Pembayaran berhasil diperbarui.
        </p>
    </section>

<?php elseif ($pesan === 'hapus'): ?>

    <section>
        <p>
            ✅ Pembayaran berhasil dihapus.
        </p>
    </section>

<?php elseif ($pesan === 'gagal'): ?>

    <section>
        <p>
            ❌ Proses pembayaran gagal dilakukan.
        </p>
    </section>

<?php endif; ?>


<section>

    <form method="GET" class="search-form" style="margin-bottom: 15px;">

        <input
            type="text"
            name="keyword"
            value="<?= htmlspecialchars($keyword); ?>"
            placeholder="Cari kode pesanan, pelanggan, metode, atau status..."
        >

        <button type="submit" class="btn">
            Cari
        </button>

        <?php if ($keyword !== ''): ?>
            <a href="index.php" class="btn">Reset</a>
        <?php endif; ?>

    </form>


    <div class="table-responsive">

        <table id="tabelPembayaran">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Kode Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Tanggal Bayar</th>
                    <th>Total Bayar</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Aksi</th>

                </tr>

            </thead>


            <tbody>

                <?php if (count($pembayaran) > 0): ?>

                    <?php foreach (
                        $pembayaran as $index => $data
                    ): ?>

                        <tr>

                            <td>
                                <?= $offset + $index + 1; ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $data['kode_pesanan']
                                ); ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $data['nama_pelanggan'] ?? '-'
                                ); ?>
                            </td>


                            <td>
                                <?= date(
                                    'd-m-Y H:i',
                                    strtotime(
                                        $data['tanggal_bayar']
                                    )
                                ); ?>
                            </td>


                            <td>

                                Rp
                                <?= number_format(
                                    $data['total_bayar'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>

                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $data['metode_pembayaran']
                                ); ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $data['status']
                                ); ?>
                            </td>


                            <td>

                                <div class="actions">

                                    <a
                                        href="form.php?id=<?= $data['id']; ?>"
                                        class="btn">

                                        Edit

                                    </a>


                                    <form action="hapus.php" method="POST" class="form-hapus">
                                        <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                        <button type="submit" class="btn btn-hapus">
                                            Hapus
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>


                <?php else: ?>

                    <tr>

                        <td colspan="8">

                            Belum ada data pembayaran.

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</section>


<div class="pagination-wrapper">

    <?php if ($totalPages > 1): ?>

        <div class="pagination">

            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1; ?>&keyword=<?= urlencode($keyword); ?>">
                    ← Sebelumnya
                </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i; ?>&keyword=<?= urlencode($keyword); ?>" class="<?= $i === $page ? 'active' : ''; ?>">
                    <?= $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1; ?>&keyword=<?= urlencode($keyword); ?>">
                    Berikutnya →
                </a>
            <?php endif; ?>

        </div>

    <?php endif; ?>

</div>


<?php require __DIR__ . "/../../layout/footer.php"; ?>