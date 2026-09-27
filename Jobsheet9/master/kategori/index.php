<?php

$page_title = "Kategori";

require __DIR__ . "/../../config/database.php";


// ==========================================
// AMBIL DATA KATEGORI
// ==========================================

$keyword = trim($_GET['keyword'] ?? '');
$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 5;

$whereSql = '';
$params = [];

if ($keyword !== '') {
    $whereSql = "WHERE (nama_kategori ILIKE :keyword)";
    $params[':keyword'] = '%' . $keyword . '%';
}

$countStmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM kategori
    $whereSql
");
$countStmt->execute($params);
$totalData = (int) $countStmt->fetchColumn();
$totalPages = max(1, (int) ceil($totalData / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$query = $pdo->prepare("
    SELECT id, nama_kategori
    FROM kategori
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

$kategori = $query->fetchAll(PDO::FETCH_ASSOC);


// ==========================================
// PESAN DARI PROSES
// ==========================================

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
                Data Kategori
            </h2>

            <p>
                Kelola kategori menu yang tersedia di KAFEIN.
            </p>

        </div>


        <a
            href="form.php"
            class="btn">
            + Tambah Kategori
        </a>

    </div>

</section>


<?php if ($pesan === 'tambah'): ?>

    <section>

        <p>
            ✅ Kategori berhasil ditambahkan.
        </p>

    </section>

<?php elseif ($pesan === 'edit'): ?>

    <section>

        <p>
            ✅ Kategori berhasil diperbarui.
        </p>

    </section>

<?php elseif ($pesan === 'hapus'): ?>

    <section>

        <p>
            ✅ Kategori berhasil dihapus.
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
            placeholder="Cari kategori..."
        >

        <button type="submit" class="btn">
            Cari
        </button>

        <?php if ($keyword !== ''): ?>
            <a href="index.php" class="btn">Reset</a>
        <?php endif; ?>

    </form>


    <div class="table-responsive">

        <table id="tabelKategori">

            <thead>

                <tr>

                    <th>
                        No
                    </th>

                    <th>
                        Nama Kategori
                    </th>

                    <th>
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                <?php if (count($kategori) > 0): ?>

                    <?php foreach ($kategori as $index => $data): ?>

                        <tr>

                            <td>
                                <?= $offset + $index + 1; ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($data['nama_kategori']); ?>
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

                        <td colspan="3">
                            Belum ada data kategori.
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