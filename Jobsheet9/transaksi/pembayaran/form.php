<?php

require __DIR__ . "/../../config/database.php";

$id = $_GET['id'] ?? null;

$edit = false;

$pesanan_id = '';
$tanggal_bayar = date('Y-m-d\TH:i');
$total_bayar = '';
$metode_pembayaran = 'Cash';
$status = 'Lunas';


/*
|--------------------------------------------------------------------------
| DATA PESANAN
|--------------------------------------------------------------------------
| Hanya mengambil pesanan yang belum memiliki pembayaran.
| Saat edit, pembayaran yang sedang diedit tetap dapat ditampilkan.
|--------------------------------------------------------------------------
*/

$queryPesanan = $pdo->query("
    SELECT
        pesanan.id,
        pesanan.kode_pesanan,
        pesanan.total,
        pelanggan.nama AS nama_pelanggan
    FROM pesanan
    LEFT JOIN pelanggan
        ON pesanan.pelanggan_id = pelanggan.id
    LEFT JOIN pembayaran
        ON pembayaran.pesanan_id = pesanan.id
    WHERE pembayaran.id IS NULL
    ORDER BY pesanan.id DESC
");

$pesanan = $queryPesanan->fetchAll();


/*
|--------------------------------------------------------------------------
| MODE EDIT
|--------------------------------------------------------------------------
*/

if ($id !== null) {

    $stmt = $pdo->prepare("
        SELECT
            pembayaran.id,
            pembayaran.pesanan_id,
            pembayaran.tanggal_bayar,
            pembayaran.total_bayar,
            pembayaran.metode_pembayaran,
            pembayaran.status,
            pesanan.kode_pesanan,
            pesanan.total,
            pelanggan.nama AS nama_pelanggan
        FROM pembayaran
        INNER JOIN pesanan
            ON pembayaran.pesanan_id = pesanan.id
        LEFT JOIN pelanggan
            ON pesanan.pelanggan_id = pelanggan.id
        WHERE pembayaran.id = :id
    ");

    $stmt->execute([
        ':id' => $id
    ]);

    $data = $stmt->fetch();

    if (!$data) {

        header("Location: index.php?pesan=gagal");
        exit;

    }

    $edit = true;

    $pesanan_id = $data['pesanan_id'];

    /*
    | Ubah format timestamp database
    | menjadi format yang dapat dibaca
    | oleh input datetime-local.
    */

    $tanggal_bayar = date(
        'Y-m-d\TH:i',
        strtotime($data['tanggal_bayar'])
    );

    $total_bayar = $data['total_bayar'];

    $metode_pembayaran =
        $data['metode_pembayaran'];

    $status =
        $data['status'];


    /*
    | Tambahkan pesanan yang sedang diedit
    | ke daftar pilihan jika belum ada.
    */

    $sudahAda = false;

    foreach ($pesanan as $item) {

        if (
            (int) $item['id'] ===
            (int) $pesanan_id
        ) {

            $sudahAda = true;
            break;

        }

    }


    if (!$sudahAda) {

        $pesanan[] = [

            'id' =>
                $data['pesanan_id'],

            'kode_pesanan' =>
                $data['kode_pesanan'],

            'total' =>
                $data['total'],

            'nama_pelanggan' =>
                $data['nama_pelanggan']

        ];

    }

}


$page_title = $edit
    ? "Edit Pembayaran"
    : "Tambah Pembayaran";

?>

<?php require __DIR__ . "/../../layout/header.php"; ?>


<!-- =====================================================
     JUDUL
===================================================== -->

<section>

    <h2>
        <?= $edit
            ? 'Edit Pembayaran'
            : 'Tambah Pembayaran';
        ?>
    </h2>

    <p>
        <?= $edit
            ? 'Perbarui data pembayaran Cafe_Najwa.'
            : 'Catat pembayaran dari pesanan yang sudah dibuat.';
        ?>
    </p>

</section>


<!-- =====================================================
     FORM PEMBAYARAN
===================================================== -->

<section>

    <form
        action="proses.php"
        method="POST"
        id="formPembayaran">


        <!-- ID SAAT EDIT -->

        <?php if ($edit): ?>

            <input
                type="hidden"
                name="id"
                value="<?= htmlspecialchars($id); ?>">

        <?php endif; ?>


        <!-- AKSI -->

        <input
            type="hidden"
            name="aksi"
            value="<?= $edit ? 'edit' : 'tambah'; ?>">


        <!-- =================================================
             PESANAN
        ================================================== -->

        <div>

            <label for="pesanan_id">
                Pesanan
            </label>

            <select
                id="pesanan_id"
                name="pesanan_id"
                required>

                <option value="">
                    -- Pilih Pesanan --
                </option>


                <?php foreach ($pesanan as $dataPesanan): ?>

                    <option
                        value="<?= $dataPesanan['id']; ?>"
                        data-total="<?= $dataPesanan['total']; ?>"
                        <?= (string) $pesanan_id ===
                            (string) $dataPesanan['id']
                            ? 'selected'
                            : '';
                        ?>>

                        <?= htmlspecialchars(
                            $dataPesanan['kode_pesanan']
                        ); ?>

                        -

                        <?= htmlspecialchars(
                            $dataPesanan['nama_pelanggan'] ?? '-'
                        ); ?>

                        -

                        Rp

                        <?= number_format(
                            $dataPesanan['total'],
                            0,
                            ',',
                            '.'
                        ); ?>

                    </option>

                <?php endforeach; ?>

            </select>


            <?php if (
                count($pesanan) === 0 &&
                !$edit
            ): ?>

                <small>
                    Belum ada pesanan yang dapat dibayar.
                </small>

            <?php endif; ?>

        </div>


        <!-- =================================================
             TANGGAL PEMBAYARAN
        ================================================== -->

        <div>

            <label for="tanggal_bayar">
                Tanggal Pembayaran
            </label>

            <input
                type="datetime-local"
                id="tanggal_bayar"
                name="tanggal_bayar"
                value="<?= htmlspecialchars(
                    $tanggal_bayar
                ); ?>"
                required>

        </div>


        <!-- =================================================
             TOTAL BAYAR
        ================================================== -->

        <div>

            <label for="total_bayar">
                Total Bayar
            </label>

            <input
                type="number"
                id="total_bayar"
                name="total_bayar"
                value="<?= htmlspecialchars(
                    $total_bayar
                ); ?>"
                min="0"
                step="0.01"
                placeholder="Masukkan total pembayaran"
                required>

        </div>


        <!-- =================================================
             METODE PEMBAYARAN
        ================================================== -->

        <div>

            <label for="metode_pembayaran">
                Metode Pembayaran
            </label>

            <select
                id="metode_pembayaran"
                name="metode_pembayaran"
                required>

                <option
                    value="Cash"
                    <?= $metode_pembayaran === 'Cash'
                        ? 'selected'
                        : '';
                    ?>>
                    Cash
                </option>

                <option
                    value="QRIS"
                    <?= $metode_pembayaran === 'QRIS'
                        ? 'selected'
                        : '';
                    ?>>
                    QRIS
                </option>

                <option
                    value="Debit"
                    <?= $metode_pembayaran === 'Debit'
                        ? 'selected'
                        : '';
                    ?>>
                    Debit
                </option>

                <option
                    value="E-Wallet"
                    <?= $metode_pembayaran === 'E-Wallet'
                        ? 'selected'
                        : '';
                    ?>>
                    E-Wallet
                </option>

            </select>

        </div>


        <!-- =================================================
             STATUS PEMBAYARAN
        ================================================== -->

        <div>

            <label for="status">
                Status Pembayaran
            </label>

            <select
                id="status"
                name="status"
                required>

                <option
                    value="Lunas"
                    <?= $status === 'Lunas'
                        ? 'selected'
                        : '';
                    ?>>
                    Lunas
                </option>

                <option
                    value="Belum Lunas"
                    <?= $status === 'Belum Lunas'
                        ? 'selected'
                        : '';
                    ?>>
                    Belum Lunas
                </option>

            </select>

        </div>


        <!-- =================================================
             TOMBOL
        ================================================== -->

        <div class="actions">

            <button type="submit">

                <?= $edit
                    ? 'Simpan Perubahan'
                    : 'Simpan Pembayaran';
                ?>

            </button>


            <a
                href="index.php"
                class="btn">

                Batal

            </a>

        </div>

    </form>

</section>


<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const pesananSelect =
            document.getElementById(
                "pesanan_id"
            );

        const totalBayar =
            document.getElementById(
                "total_bayar"
            );


        pesananSelect.addEventListener(
            "change",
            function () {

                const option =
                    pesananSelect.options[
                        pesananSelect.selectedIndex
                    ];


                if (!option) {
                    return;
                }


                const total =
                    option.getAttribute(
                        "data-total"
                    );


                if (total !== null) {

                    totalBayar.value =
                        Number(total);

                }

            }
        );

    }
);

</script>


<?php require __DIR__ . "/../../layout/footer.php"; ?>