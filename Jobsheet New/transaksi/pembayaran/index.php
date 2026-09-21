<?php

$page_title = "Pembayaran";

require __DIR__ . "/../../config/database.php";

$query = $pdo->query("
    SELECT
        pembayaran.id,
        pesanan.kode_pesanan,
        pelanggan.nama AS nama_pelanggan,
        pembayaran.tanggal_bayar,
        pembayaran.total_bayar,
        pembayaran.metode_pembayaran,
        pembayaran.status
    FROM pembayaran
    INNER JOIN pesanan
        ON pembayaran.pesanan_id = pesanan.id
    LEFT JOIN pelanggan
        ON pesanan.pelanggan_id = pelanggan.id
    ORDER BY pembayaran.id DESC
");

$pembayaran = $query->fetchAll();

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

    <div style="margin-bottom: 15px;">

        <input
            type="text"
            placeholder="Cari kode pesanan, pelanggan, metode, atau status..."
            data-search="#tabelPembayaran">

    </div>


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

                            Belum ada data pembayaran.

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</section>


<?php require __DIR__ . "/../../layout/footer.php"; ?>