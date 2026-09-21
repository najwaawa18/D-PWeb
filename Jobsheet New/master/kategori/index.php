<?php

$page_title = "Kategori";

require __DIR__ . "/../../config/database.php";


// ==========================================
// AMBIL DATA KATEGORI
// ==========================================

$query = $pdo->query("
    SELECT id, nama_kategori
    FROM kategori
    ORDER BY id ASC
");

$kategori = $query->fetchAll();


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

    <div style="margin-bottom: 15px;">

        <input
            type="text"
            placeholder="Cari kategori..."
            data-search="#tabelKategori">

    </div>


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
                                <?= $index + 1; ?>
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

                        <td colspan="3">
                            Belum ada data kategori.
                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</section>


<?php require __DIR__ . "/../../layout/footer.php"; ?>