<?php

$page_title = "Pesanan";

require __DIR__ . "/../../config/database.php";

$query = $pdo->query("
    SELECT
        pesanan.id,
        pesanan.kode_pesanan,
        pelanggan.nama AS nama_pelanggan,
        meja.nomor_meja,
        pesanan.tanggal_pesanan,
        pesanan.status,
        pesanan.total
    FROM pesanan
    LEFT JOIN pelanggan
        ON pesanan.pelanggan_id = pelanggan.id
    LEFT JOIN meja
        ON pesanan.meja_id = meja.id
    ORDER BY pesanan.id DESC
");

$pesanan = $query->fetchAll();

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
                Data Pesanan
            </h2>

            <p>
                Kelola transaksi pesanan Cafe_Najwa.
            </p>

        </div>


        <a
            href="form.php"
            class="btn">
            + Tambah Pesanan
        </a>

    </div>

</section>


<?php if ($pesan === 'tambah'): ?>

    <section>
        <p>
            ✅ Pesanan berhasil ditambahkan.
        </p>
    </section>

<?php elseif ($pesan === 'edit'): ?>

    <section>
        <p>
            ✅ Pesanan berhasil diperbarui.
        </p>
    </section>

<?php elseif ($pesan === 'hapus'): ?>

    <section>
        <p>
            ✅ Pesanan berhasil dihapus.
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
            placeholder="Cari kode, pelanggan, meja, atau status..."
            data-search="#tabelPesanan">

    </div>


    <div class="table-responsive">

        <table id="tabelPesanan">

            <thead>

                <tr>

                    <th>No</th>

                    <th>Kode Pesanan</th>

                    <th>Pelanggan</th>

                    <th>Meja</th>

                    <th>Tanggal</th>

                    <th>Status</th>

                    <th>Total</th>

                    <th>Aksi</th>

                </tr>

            </thead>


            <tbody>

                <?php if (count($pesanan) > 0): ?>


                    <?php foreach ($pesanan as $index => $data): ?>

                        <tr>

                            <td>
                                <?= $index + 1; ?>
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
                                <?= htmlspecialchars(
                                    $data['nomor_meja'] ?? '-'
                                ); ?>
                            </td>


                            <td>
                                <?= date(
                                    'd-m-Y H:i',
                                    strtotime(
                                        $data['tanggal_pesanan']
                                    )
                                ); ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $data['status']
                                ); ?>
                            </td>


                            <td>
                                Rp
                                <?= number_format(
                                    $data['total'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>
                            </td>


                            <td>

                                <div class="actions">

                                    <a
                                        href="form.php?id=<?= $data['id']; ?>"
                                        class="btn">
                                        Detail
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
                            Belum ada data pesanan.
                        </td>

                    </tr>


                <?php endif; ?>

            </tbody>

        </table>

    </div>

</section>


<?php require __DIR__ . "/../../layout/footer.php"; ?>