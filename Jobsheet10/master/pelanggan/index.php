<?php

require_once __DIR__ . "/../../includes/auth.php";


$page_title = "Pelanggan";

require __DIR__ . "/../../config/database.php";

$keyword = trim($_GET['keyword'] ?? '');
$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 5;

$whereSql = '';
$params = [];

if ($keyword !== '') {
    $whereSql = "WHERE (kode_pelanggan ILIKE :keyword OR nama ILIKE :keyword OR no_hp ILIKE :keyword OR email ILIKE :keyword)";
    $params[':keyword'] = '%' . $keyword . '%';
}

$countStmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM pelanggan
    $whereSql
");
$countStmt->execute($params);
$totalData = (int) $countStmt->fetchColumn();
$totalPages = max(1, (int) ceil($totalData / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$query = $pdo->prepare("
    SELECT
        id,
        kode_pelanggan,
        nama,
        no_hp,
        email
    FROM pelanggan
    $whereSql
    ORDER BY id ASC
    LIMIT :limit OFFSET :offset
");

foreach ($params as $name => $value) {
    $query->bindValue($name, $value, PDO::PARAM_STR);
}
$query->bindValue(':limit', $perPage, PDO::PARAM_INT);
$query->bindValue(':offset', $offset, PDO::PARAM_INT);
$query->execute();

$pelanggan = $query->fetchAll(PDO::FETCH_ASSOC);

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
                Data Pelanggan
            </h2>

            <p>
                Kelola data pelanggan Cafe_Najwa.
            </p>

        </div>

        <a
            href="form.php"
            class="btn">
            + Tambah Pelanggan
        </a>

    </div>

</section>


<?php if ($pesan === 'tambah'): ?>

    <section>
        <p>✅ Pelanggan berhasil ditambahkan.</p>
    </section>

<?php elseif ($pesan === 'edit'): ?>

    <section>
        <p>✅ Data pelanggan berhasil diperbarui.</p>
    </section>

<?php elseif ($pesan === 'hapus'): ?>

    <section>
        <p>✅ Pelanggan berhasil dihapus.</p>
    </section>

<?php elseif ($pesan === 'gagal'): ?>

    <section>
        <p>❌ Proses gagal dilakukan.</p>
    </section>

<?php endif; ?>


<section>

    <form method="GET" class="search-form" style="margin-bottom: 15px;">

        <input
            type="text"
            name="keyword"
            value="<?= htmlspecialchars($keyword); ?>"
            placeholder="Cari kode, nama, nomor HP, atau email..."
        >

        <button type="submit" class="btn">
            Cari
        </button>

        <?php if ($keyword !== ''): ?>
            <a href="index.php" class="btn">Reset</a>
        <?php endif; ?>

    </form>


    <div class="table-responsive">

        <table id="tabelPelanggan">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Kode Pelanggan</th>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>

            </thead>


            <tbody>

                <?php if (count($pelanggan) > 0): ?>

                    <?php foreach ($pelanggan as $index => $data): ?>

                        <tr>

                            <td>
                                <?= $offset + $index + 1; ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $data['kode_pelanggan']
                                ); ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $data['nama']
                                ); ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $data['no_hp'] ?? '-'
                                ); ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $data['email'] ?? '-'
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

                        <td colspan="6">
                            Belum ada data pelanggan.
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