<?php

require_once __DIR__ . '/../../config/database.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$aksi = $id > 0 ? 'edit' : 'tambah';

$kode_pesanan = '';
$tanggal_pesanan = date('Y-m-d\TH:i');
$pelanggan_id = '';
$meja_id = '';
$status = 'Proses';

$detail_lama = [];

/* =========================================================
   DATA MASTER
========================================================= */

$pelanggan = $pdo->query("
    SELECT id, kode_pelanggan, nama
    FROM pelanggan
    ORDER BY nama ASC
")->fetchAll(PDO::FETCH_ASSOC);

$meja = $pdo->query("
    SELECT id, nomor_meja, kapasitas, status
    FROM meja
    ORDER BY nomor_meja ASC
")->fetchAll(PDO::FETCH_ASSOC);

$menu = $pdo->query("
    SELECT
        menu.id,
        menu.kode_menu,
        menu.nama_menu,
        menu.harga,
        menu.stok,
        menu.status,
        kategori.nama_kategori
    FROM menu
    INNER JOIN kategori
        ON menu.kategori_id = kategori.id
    WHERE menu.status = 'Tersedia'
    ORDER BY menu.nama_menu ASC
")->fetchAll(PDO::FETCH_ASSOC);


/* =========================================================
   MODE EDIT
========================================================= */

if ($id > 0) {

    $stmt = $pdo->prepare("
        SELECT
            id,
            kode_pesanan,
            pelanggan_id,
            meja_id,
            tanggal_pesanan,
            status
        FROM pesanan
        WHERE id = :id
    ");

    $stmt->execute([
        ':id' => $id
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        header('Location: index.php');
        exit;
    }

    $kode_pesanan = $data['kode_pesanan'];
    $pelanggan_id = $data['pelanggan_id'];
    $meja_id = $data['meja_id'];
    $status = $data['status'];

    if (!empty($data['tanggal_pesanan'])) {
        $tanggal_pesanan = date(
            'Y-m-d\TH:i',
            strtotime($data['tanggal_pesanan'])
        );
    }

    /* Ambil detail pesanan */

    $stmtDetail = $pdo->prepare("
        SELECT
            detail_pesanan.id,
            detail_pesanan.menu_id,
            detail_pesanan.jumlah,
            detail_pesanan.harga,
            detail_pesanan.subtotal,
            menu.kode_menu,
            menu.nama_menu,
            menu.stok,
            menu.status
        FROM detail_pesanan
        INNER JOIN menu
            ON detail_pesanan.menu_id = menu.id
        WHERE detail_pesanan.pesanan_id = :pesanan_id
        ORDER BY detail_pesanan.id ASC
    ");

    $stmtDetail->execute([
        ':pesanan_id' => $id
    ]);

    $detail_lama = $stmtDetail->fetchAll(PDO::FETCH_ASSOC);
}

?>

<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="container">

    <!-- =====================================================
         HEADER HALAMAN
    ====================================================== -->

    <section>
        <h2>
            <?= $aksi === 'edit' ? 'Edit Pesanan' : 'Tambah Pesanan'; ?>
        </h2>

        <p>
            <?= $aksi === 'edit'
                ? 'Perbarui informasi pesanan dan detail menu.'
                : 'Tambahkan pesanan baru ke dalam sistem.'; ?>
        </p>
    </section>


    <!-- =====================================================
         FORM PESANAN
    ====================================================== -->

    <section>

        <form
            action="proses.php"
            method="POST"
            id="formPesanan"
        >

            <input
                type="hidden"
                name="aksi"
                value="<?= htmlspecialchars($aksi); ?>"
            >

            <?php if ($id > 0): ?>

                <input
                    type="hidden"
                    name="id"
                    value="<?= $id; ?>"
                >

            <?php endif; ?>


            <!-- INFORMASI PESANAN -->

            <div class="form-grid">

                <div>
                    <label for="kode_pesanan">
                        Kode Pesanan
                    </label>

                    <input
                        type="text"
                        id="kode_pesanan"
                        name="kode_pesanan"
                        value="<?= htmlspecialchars($kode_pesanan); ?>"
                        placeholder="Contoh: PSN-001"
                        required
                    >
                </div>


                <div>
                    <label for="tanggal_pesanan">
                        Tanggal Pemesanan
                    </label>

                    <input
                        type="datetime-local"
                        id="tanggal_pesanan"
                        name="tanggal_pesanan"
                        value="<?= htmlspecialchars($tanggal_pesanan); ?>"
                        required
                    >
                </div>


                <div>
                    <label for="pelanggan_id">
                        Pelanggan
                    </label>

                    <select
                        id="pelanggan_id"
                        name="pelanggan_id"
                        required
                    >

                        <option value="">
                            -- Pilih Pelanggan --
                        </option>

                        <?php foreach ($pelanggan as $p): ?>

                            <option
                                value="<?= $p['id']; ?>"
                                <?= (string)$pelanggan_id === (string)$p['id']
                                    ? 'selected'
                                    : ''; ?>
                            >
                                <?= htmlspecialchars(
                                    $p['kode_pelanggan'] . ' - ' . $p['nama']
                                ); ?>
                            </option>

                        <?php endforeach; ?>

                    </select>
                </div>


                <div>
                    <label for="meja_id">
                        Meja
                    </label>

                    <select
                        id="meja_id"
                        name="meja_id"
                        required
                    >

                        <option value="">
                            -- Pilih Meja --
                        </option>

                        <?php foreach ($meja as $m): ?>

                            <option
                                value="<?= $m['id']; ?>"
                                <?= (string)$meja_id === (string)$m['id']
                                    ? 'selected'
                                    : ''; ?>
                            >
                                <?= htmlspecialchars(
                                    'Meja ' . $m['nomor_meja']
                                    . ' - Kapasitas '
                                    . $m['kapasitas']
                                ); ?>
                            </option>

                        <?php endforeach; ?>

                    </select>
                </div>


                <div>
                    <label for="status">
                        Status Pesanan
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                    >

                        <option
                            value="Proses"
                            <?= $status === 'Proses' ? 'selected' : ''; ?>
                        >
                            Proses
                        </option>

                        <option
                            value="Selesai"
                            <?= $status === 'Selesai' ? 'selected' : ''; ?>
                        >
                            Selesai
                        </option>

                        <option
                            value="Dibatalkan"
                            <?= $status === 'Dibatalkan' ? 'selected' : ''; ?>
                        >
                            Dibatalkan
                        </option>

                    </select>
                </div>

            </div>


            <hr>


            <!-- =================================================
                 DETAIL PESANAN
            ================================================== -->

            <div>

                <h3>Detail Pesanan</h3>

                <p>
                    Pilih menu dan tentukan jumlah pesanan.
                </p>

            </div>


            <div class="table-wrapper">

                <table id="tabelDetailPesanan">

                    <thead>

                        <tr>
                            <th>Menu</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody id="detailContainer">

                        <?php if (!empty($detail_lama)): ?>

                            <?php foreach ($detail_lama as $detail): ?>

                                <tr class="detail-row">

                                    <td>

                                        <select
                                            name="menu_id[]"
                                            class="menu-select"
                                            required
                                        >

                                            <option value="">
                                                -- Pilih Menu --
                                            </option>

                                            <?php foreach ($menu as $m): ?>

                                                <option
                                                    value="<?= $m['id']; ?>"
                                                    data-harga="<?= $m['harga']; ?>"
                                                    <?= (string)$detail['menu_id'] === (string)$m['id']
                                                        ? 'selected'
                                                        : ''; ?>
                                                >
                                                    <?= htmlspecialchars(
                                                        $m['kode_menu']
                                                        . ' - '
                                                        . $m['nama_menu']
                                                    ); ?>
                                                </option>

                                            <?php endforeach; ?>

                                            <?php
                                            /*
                                             * Jika menu lama sudah tidak
                                             * berstatus Tersedia, tetap
                                             * tampilkan sebagai pilihan.
                                             */
                                            $menuLamaAda = false;

                                            foreach ($menu as $m) {
                                                if ((string)$m['id'] === (string)$detail['menu_id']) {
                                                    $menuLamaAda = true;
                                                    break;
                                                }
                                            }
                                            ?>

                                            <?php if (!$menuLamaAda): ?>

                                                <option
                                                    value="<?= $detail['menu_id']; ?>"
                                                    data-harga="<?= $detail['harga']; ?>"
                                                    selected
                                                >
                                                    <?= htmlspecialchars(
                                                        $detail['kode_menu']
                                                        . ' - '
                                                        . $detail['nama_menu']
                                                    ); ?>
                                                </option>

                                            <?php endif; ?>

                                        </select>

                                    </td>


                                    <td>

                                        <input
                                            type="number"
                                            class="harga-input"
                                            value="<?= htmlspecialchars($detail['harga']); ?>"
                                            readonly
                                        >

                                    </td>


                                    <td>

                                        <input
                                            type="number"
                                            name="jumlah[]"
                                            class="jumlah-input"
                                            value="<?= htmlspecialchars($detail['jumlah']); ?>"
                                            min="1"
                                            required
                                        >

                                    </td>


                                    <td>

                                        <input
                                            type="number"
                                            class="subtotal-input"
                                            value="<?= htmlspecialchars($detail['subtotal']); ?>"
                                            readonly
                                        >

                                    </td>


                                    <td>

                                        <button
                                            type="button"
                                            class="btn-danger btn-hapus-detail"
                                        >
                                            Hapus
                                        </button>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr class="detail-row">

                                <td>

                                    <select
                                        name="menu_id[]"
                                        class="menu-select"
                                        required
                                    >

                                        <option value="">
                                            -- Pilih Menu --
                                        </option>

                                        <?php foreach ($menu as $m): ?>

                                            <option
                                                value="<?= $m['id']; ?>"
                                                data-harga="<?= $m['harga']; ?>"
                                            >
                                                <?= htmlspecialchars(
                                                    $m['kode_menu']
                                                    . ' - '
                                                    . $m['nama_menu']
                                                ); ?>
                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </td>


                                <td>

                                    <input
                                        type="number"
                                        class="harga-input"
                                        readonly
                                    >

                                </td>


                                <td>

                                    <input
                                        type="number"
                                        name="jumlah[]"
                                        class="jumlah-input"
                                        value="1"
                                        min="1"
                                        required
                                    >

                                </td>


                                <td>

                                    <input
                                        type="number"
                                        class="subtotal-input"
                                        readonly
                                    >

                                </td>


                                <td>

                                    <button
                                        type="button"
                                        class="btn-danger btn-hapus-detail"
                                    >
                                        Hapus
                                    </button>

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>


            <!-- TAMBAH MENU -->

            <div style="margin-top: 15px;">

                <button
                    type="button"
                    id="btnTambahDetail"
                >
                    + Tambah Menu
                </button>

            </div>


            <!-- TOTAL -->

            <div style="
                margin-top: 22px;
                padding: 18px;
                background: #faf5ef;
                border-radius: 10px;
                text-align: right;
            ">

                <strong>Total Pesanan</strong>

                <div id="totalDisplay">
                    Rp 0
                </div>

            </div>


            <!-- ACTION -->

            <div class="actions">

                <button type="submit">
                    <?= $aksi === 'edit'
                        ? 'Simpan Perubahan'
                        : 'Simpan Pesanan'; ?>
                </button>

                <a
                    href="index.php"
                    class="btn btn-secondary"
                >
                    Batal
                </a>

            </div>

        </form>

    </section>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('detailContainer');
    const btnTambah = document.getElementById('btnTambahDetail');
    const totalDisplay = document.getElementById('totalDisplay');


    function formatRupiah(angka) {

        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);

    }


    function hitungBaris(row) {

        const select = row.querySelector('.menu-select');
        const hargaInput = row.querySelector('.harga-input');
        const jumlahInput = row.querySelector('.jumlah-input');
        const subtotalInput = row.querySelector('.subtotal-input');

        if (!select || !hargaInput || !jumlahInput || !subtotalInput) {
            return 0;
        }

        const option = select.options[select.selectedIndex];

        const harga = parseFloat(
            option?.dataset?.harga || 0
        );

        const jumlah = parseInt(
            jumlahInput.value || 0
        );

        const subtotal = harga * jumlah;

        hargaInput.value = harga;
        subtotalInput.value = subtotal;

        return subtotal;
    }


    function hitungTotal() {

        let total = 0;

        document
            .querySelectorAll('.detail-row')
            .forEach(function (row) {

                total += hitungBaris(row);

            });

        totalDisplay.textContent = formatRupiah(total);

    }


    function pasangEvent(row) {

        const select = row.querySelector('.menu-select');
        const jumlah = row.querySelector('.jumlah-input');
        const tombolHapus = row.querySelector('.btn-hapus-detail');

        if (select) {

            select.addEventListener('change', function () {
                hitungTotal();
            });

        }

        if (jumlah) {

            jumlah.addEventListener('input', function () {
                hitungTotal();
            });

        }

        if (tombolHapus) {

            tombolHapus.addEventListener('click', function () {

                const rows = document.querySelectorAll('.detail-row');

                if (rows.length <= 1) {

                    alert('Minimal harus ada satu menu.');

                    return;
                }

                row.remove();

                hitungTotal();

            });

        }

    }


    document
        .querySelectorAll('.detail-row')
        .forEach(function (row) {

            pasangEvent(row);

        });


    btnTambah.addEventListener('click', function () {

        const rowPertama =
            document.querySelector('.detail-row');

        const rowBaru =
            rowPertama.cloneNode(true);


        rowBaru
            .querySelector('.menu-select')
            .selectedIndex = 0;


        rowBaru
            .querySelector('.harga-input')
            .value = '';


        rowBaru
            .querySelector('.jumlah-input')
            .value = 1;


        rowBaru
            .querySelector('.subtotal-input')
            .value = '';


        container.appendChild(rowBaru);

        pasangEvent(rowBaru);

        hitungTotal();

    });


    hitungTotal();

});

</script>


<?php require_once __DIR__ . '/../../layout/footer.php'; ?>