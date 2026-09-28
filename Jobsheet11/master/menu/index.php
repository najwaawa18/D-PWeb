<?php

$page_title = "Menu";

require __DIR__ . "/../../includes/csrf.php";
require __DIR__ . "/../../config/database.php";

$keyword = trim($_GET['keyword'] ?? '');
$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 5;

$whereSql = '';
$params = [];

if ($keyword !== '') {
    $whereSql = "WHERE (menu.kode_menu ILIKE :keyword OR menu.nama_menu ILIKE :keyword OR kategori.nama_kategori ILIKE :keyword OR menu.status ILIKE :keyword)";
    $params[':keyword'] = '%' . $keyword . '%';
}

$countStmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM menu INNER JOIN kategori ON menu.kategori_id = kategori.id
    $whereSql
");
$countStmt->execute($params);
$totalData = (int) $countStmt->fetchColumn();
$totalPages = max(1, (int) ceil($totalData / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$query = $pdo->prepare("
    SELECT
        menu.id,
        menu.kode_menu,
        menu.nama_menu,
        kategori.nama_kategori,
        menu.harga,
        menu.stok,
        menu.status
    FROM menu INNER JOIN kategori ON menu.kategori_id = kategori.id
    $whereSql
    ORDER BY menu.id ASC
    LIMIT :limit OFFSET :offset
");

foreach ($params as $name => $value) {
    $query->bindValue($name, $value, PDO::PARAM_STR);
}
$query->bindValue(':limit', $perPage, PDO::PARAM_INT);
$query->bindValue(':offset', $offset, PDO::PARAM_INT);
$query->execute();

$menu = $query->fetchAll(PDO::FETCH_ASSOC);

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
                Data Menu
            </h2>

            <p>
                Kelola daftar menu Cafe_Najwa.
            </p>

        </div>


        <a
            href="form.php"
            class="btn">
            + Tambah Menu
        </a>

    </div>

</section>


<?php if ($pesan === 'tambah'): ?>

    <section>

        <p>
            ✅ Menu berhasil ditambahkan.
        </p>

    </section>

<?php elseif ($pesan === 'edit'): ?>

    <section>

        <p>
            ✅ Data menu berhasil diperbarui.
        </p>

    </section>

<?php elseif ($pesan === 'hapus'): ?>

    <section>

        <p>
            ✅ Menu berhasil dihapus.
        </p>

    </section>

<?php elseif ($pesan === 'gagal'): ?>

    <section>

        <p>
            ❌ Proses gagal dilakukan.
        </p>

    </section>

<?php endif; ?>


<section>


    <form method="GET" class="search-form" style="margin-bottom: 15px;">

        <input
            type="text"
            name="keyword"
            value="<?= htmlspecialchars($keyword); ?>"
            placeholder="Cari kode, nama, kategori, atau status..."
        >

        <button type="submit" class="btn">
            Cari
        </button>

        <?php if ($keyword !== ''): ?>
            <a href="index.php" class="btn">Reset</a>
        <?php endif; ?>

    </form>


    <div class="table-responsive">

        <table id="tabelMenu">

            <thead>

                <tr>

                    <th>No</th>

                    <th>Kode Menu</th>

                    <th>Nama Menu</th>

                    <th>Kategori</th>

                    <th>Harga</th>

                    <th>Stok</th>

                    <th>Status</th>

                    <th>Aksi</th>

                </tr>

            </thead>


            <tbody>

                <?php if (count($menu) > 0): ?>


                    <?php foreach ($menu as $index => $data): ?>

                        <tr>

                            <td>
                                <?= $offset + $index + 1; ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $data['kode_menu']
                                ); ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $data['nama_menu']
                                ); ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $data['nama_kategori']
                                ); ?>
                            </td>


                            <td>
                                Rp
                                <?= number_format(
                                    $data['harga'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $data['stok']
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
                                        <?= csrf_field(); ?>
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
                            Belum ada data menu.
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