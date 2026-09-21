<?php

$page_title = "Menu";

require __DIR__ . "/../../config/database.php";

$query = $pdo->query("
    SELECT
        menu.id,
        menu.kode_menu,
        menu.nama_menu,
        kategori.nama_kategori,
        menu.harga,
        menu.stok,
        menu.status
    FROM menu
    INNER JOIN kategori
        ON menu.kategori_id = kategori.id
    ORDER BY menu.id ASC
");

$menu = $query->fetchAll();

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


    <div style="margin-bottom: 15px;">

        <input
            type="text"
            placeholder="Cari kode, nama, kategori, atau status..."
            data-search="#tabelMenu">

    </div>


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
                                <?= $index + 1; ?>
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


                                    <a
                                        href="proses.php?aksi=hapus&id=<?= $data['id']; ?>"
                                        class="btn btn-hapus">
                                        Hapus
                                    </a>

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


<?php require __DIR__ . "/../../layout/footer.php"; ?>