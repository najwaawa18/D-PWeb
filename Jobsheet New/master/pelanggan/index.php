<?php

$page_title = "Pelanggan";

require __DIR__ . "/../../config/database.php";

$query = $pdo->query("
    SELECT
        id,
        kode_pelanggan,
        nama,
        no_hp,
        email
    FROM pelanggan
    ORDER BY id ASC
");

$pelanggan = $query->fetchAll();

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

    <div style="margin-bottom: 15px;">

        <input
            type="text"
            placeholder="Cari kode, nama, nomor HP, atau email..."
            data-search="#tabelPelanggan">

    </div>


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
                                <?= $index + 1; ?>
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

                        <td colspan="6">
                            Belum ada data pelanggan.
                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</section>


<?php require __DIR__ . "/../../layout/footer.php"; ?>