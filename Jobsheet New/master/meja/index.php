<?php

$page_title = "Meja";

require __DIR__ . "/../../config/database.php";


// ==========================================
// AMBIL DATA MEJA
// ==========================================

$query = $pdo->query("
    SELECT
        id,
        nomor_meja,
        kapasitas,
        status
    FROM meja
    ORDER BY id ASC
");

$meja = $query->fetchAll();


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
                Data Meja
            </h2>

            <p>
                Kelola data meja yang tersedia di KAFEIN.
            </p>

        </div>


        <a
            href="form.php"
            class="btn">
            + Tambah Meja
        </a>

    </div>

</section>


<?php if ($pesan === 'tambah'): ?>

    <section>

        <p>
            ✅ Meja berhasil ditambahkan.
        </p>

    </section>

<?php elseif ($pesan === 'edit'): ?>

    <section>

        <p>
            ✅ Data meja berhasil diperbarui.
        </p>

    </section>

<?php elseif ($pesan === 'hapus'): ?>

    <section>

        <p>
            ✅ Meja berhasil dihapus.
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
            placeholder="Cari nomor meja..."
            data-search="#tabelMeja">

    </div>


    <div class="table-responsive">

        <table id="tabelMeja">

            <thead>

                <tr>

                    <th>
                        No
                    </th>

                    <th>
                        Nomor Meja
                    </th>

                    <th>
                        Kapasitas
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                <?php if (count($meja) > 0): ?>

                    <?php foreach ($meja as $index => $data): ?>

                        <tr>

                            <td>
                                <?= $index + 1; ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($data['nomor_meja']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($data['kapasitas']); ?>
                                orang
                            </td>

                            <td>
                                <?= htmlspecialchars($data['status']); ?>
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

                        <td colspan="5">
                            Belum ada data meja.
                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</section>


<?php require __DIR__ . "/../../layout/footer.php"; ?>