<?php

require __DIR__ . "/../../config/database.php";

$id = $_GET['id'] ?? null;

$edit = false;

$kode_pesanan = '';
$pelanggan_id = '';
$meja_id = '';
$status = 'Proses';

$detail_pesanan = [];

/*
|--------------------------------------------------------------------------
| DATA PELANGGAN
|--------------------------------------------------------------------------
*/

$queryPelanggan = $pdo->query("
    SELECT
        id,
        kode_pelanggan,
        nama
    FROM pelanggan
    ORDER BY nama ASC
");

$pelanggan = $queryPelanggan->fetchAll();

/*
|--------------------------------------------------------------------------
| DATA MEJA
|--------------------------------------------------------------------------
*/

$queryMeja = $pdo->query("
    SELECT
        id,
        nomor_meja,
        kapasitas,
        status
    FROM meja
    ORDER BY nomor_meja ASC
");

$meja = $queryMeja->fetchAll();

/*
|--------------------------------------------------------------------------
| DATA MENU
|--------------------------------------------------------------------------
*/

$queryMenu = $pdo->query("
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
");

$menu = $queryMenu->fetchAll();

/*
|--------------------------------------------------------------------------
| MODE EDIT
|--------------------------------------------------------------------------
*/

if ($id !== null) {

    $stmt = $pdo->prepare("
        SELECT
            id,
            kode_pesanan,
            pelanggan_id,
            meja_id,
            status
        FROM pesanan
        WHERE id = :id
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

    $kode_pesanan = $data['kode_pesanan'];
    $pelanggan_id = $data['pelanggan_id'];
    $meja_id = $data['meja_id'];
    $status = $data['status'];

    /*
    |--------------------------------------------------------------------------
    | DETAIL PESANAN
    |--------------------------------------------------------------------------
    */

    $stmtDetail = $pdo->prepare("
        SELECT
            detail_pesanan.id,
            detail_pesanan.menu_id,
            detail_pesanan.jumlah,
            detail_pesanan.harga,
            detail_pesanan.subtotal,
            menu.nama_menu
        FROM detail_pesanan
        INNER JOIN menu
            ON detail_pesanan.menu_id = menu.id
        WHERE detail_pesanan.pesanan_id = :pesanan_id
        ORDER BY detail_pesanan.id ASC
    ");

    $stmtDetail->execute([
        ':pesanan_id' => $id
    ]);

    $detail_pesanan = $stmtDetail->fetchAll();
}

$page_title = $edit
    ? "Detail Pesanan"
    : "Tambah Pesanan";

?>

<?php require __DIR__ . "/../../layout/header.php"; ?>


<!-- =========================================================
     JUDUL
========================================================= -->

<section>

    <h2>
        <?= $edit ? 'Detail Pesanan' : 'Tambah Pesanan'; ?>
    </h2>

    <p>
        <?= $edit
            ? 'Lihat dan perbarui transaksi Cafe_Najwa.'
            : 'Buat transaksi pesanan baru.';
        ?>
    </p>

</section>


<!-- =========================================================
     FORM PESANAN
========================================================= -->

<section>

    <form
        action="proses.php"
        method="POST"
        id="formPesanan">

        <?php if ($edit): ?>

            <input
                type="hidden"
                name="id"
                value="<?= htmlspecialchars($id); ?>">

        <?php endif; ?>


        <input
            type="hidden"
            name="aksi"
            value="<?= $edit ? 'edit' : 'tambah'; ?>">


        <!-- =================================================
             KODE PESANAN
        ================================================== -->

        <div>

            <label for="kode_pesanan">
                Kode Pesanan
            </label>

            <input
                type="text"
                id="kode_pesanan"
                name="kode_pesanan"
                value="<?= htmlspecialchars($kode_pesanan); ?>"
                placeholder="Contoh: PS001"
                maxlength="20"
                required>

        </div>


        <!-- =================================================
             PELANGGAN
        ================================================== -->

        <div>

            <label for="pelanggan_id">
                Pelanggan
            </label>

            <select
                id="pelanggan_id"
                name="pelanggan_id">

                <option value="">
                    -- Pilih Pelanggan --
                </option>

                <?php if (count($pelanggan) > 0): ?>

                    <?php foreach ($pelanggan as $dataPelanggan): ?>

                        <option
                            value="<?= $dataPelanggan['id']; ?>"
                            <?= (string)$pelanggan_id ===
                                (string)$dataPelanggan['id']
                                ? 'selected'
                                : '';
                            ?>>

                            <?= htmlspecialchars(
                                $dataPelanggan['kode_pelanggan']
                            ); ?>

                            -
                            
                            <?= htmlspecialchars(
                                $dataPelanggan['nama']
                            ); ?>

                        </option>

                    <?php endforeach; ?>

                <?php endif; ?>

            </select>

            <?php if (count($pelanggan) === 0): ?>

                <small>
                    Belum ada data pelanggan.
                    Tambahkan pelanggan terlebih dahulu.
                </small>

            <?php endif; ?>

        </div>


        <!-- =================================================
             MEJA
        ================================================== -->

        <div>

            <label for="meja_id">
                Meja
            </label>

            <select
                id="meja_id"
                name="meja_id">

                <option value="">
                    -- Pilih Meja --
                </option>

                <?php foreach ($meja as $dataMeja): ?>

                    <option
                        value="<?= $dataMeja['id']; ?>"
                        <?= (string)$meja_id ===
                            (string)$dataMeja['id']
                            ? 'selected'
                            : '';
                        ?>>

                        <?= htmlspecialchars(
                            $dataMeja['nomor_meja']
                        ); ?>

                        -
                        kapasitas
                        <?= htmlspecialchars(
                            $dataMeja['kapasitas']
                        ); ?>
                        orang

                        (<?= htmlspecialchars(
                            $dataMeja['status']
                        ); ?>)

                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <!-- =================================================
             STATUS PESANAN
        ================================================== -->

        <div>

            <label for="status">
                Status Pesanan
            </label>

            <select
                id="status"
                name="status"
                required>

                <option
                    value="Proses"
                    <?= $status === 'Proses'
                        ? 'selected'
                        : '';
                    ?>>
                    Proses
                </option>

                <option
                    value="Selesai"
                    <?= $status === 'Selesai'
                        ? 'selected'
                        : '';
                    ?>>
                    Selesai
                </option>

                <option
                    value="Dibatalkan"
                    <?= $status === 'Dibatalkan'
                        ? 'selected'
                        : '';
                    ?>>
                    Dibatalkan
                </option>

            </select>

        </div>


        <hr>


        <!-- =================================================
             DETAIL PESANAN
        ================================================== -->

        <h3>
            Detail Pesanan
        </h3>

        <p>
            Pilih menu yang dipesan dan jumlahnya.
        </p>


        <div class="table-responsive">

            <table id="tabelDetailPesanan">

                <thead>

                    <tr>

                        <th>
                            Menu
                        </th>

                        <th>
                            Harga
                        </th>

                        <th>
                            Jumlah
                        </th>

                        <th>
                            Subtotal
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody id="detailContainer">


                    <?php if (
                        $edit &&
                        count($detail_pesanan) > 0
                    ): ?>


                        <!-- =================================
                             DETAIL SAAT EDIT
                        ================================== -->

                        <?php foreach (
                            $detail_pesanan as $detail
                        ): ?>

                            <tr class="detail-row">

                                <td>

                                    <select
                                        name="menu_id[]"
                                        class="menu-select"
                                        required>

                                        <option value="">
                                            -- Pilih Menu --
                                        </option>


                                        <?php foreach (
                                            $menu as $dataMenu
                                        ): ?>

                                            <option
                                                value="<?= $dataMenu['id']; ?>"
                                                data-harga="<?= $dataMenu['harga']; ?>"
                                                <?= (string)$detail['menu_id'] ===
                                                    (string)$dataMenu['id']
                                                    ? 'selected'
                                                    : '';
                                                ?>>

                                                <?= htmlspecialchars(
                                                    $dataMenu['nama_menu']
                                                ); ?>

                                                -
                                                Rp
                                                <?= number_format(
                                                    $dataMenu['harga'],
                                                    0,
                                                    ',',
                                                    '.'
                                                ); ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </td>


                                <td>

                                    <input
                                        type="text"
                                        class="harga-display"
                                        value="Rp <?= number_format(
                                            $detail['harga'],
                                            0,
                                            ',',
                                            '.'
                                        ); ?>"
                                        readonly>

                                </td>


                                <td>

                                    <input
                                        type="number"
                                        name="jumlah[]"
                                        class="jumlah-input"
                                        value="<?= $detail['jumlah']; ?>"
                                        min="1"
                                        required>

                                </td>


                                <td>

                                    <input
                                        type="text"
                                        class="subtotal-display"
                                        value="Rp <?= number_format(
                                            $detail['subtotal'],
                                            0,
                                            ',',
                                            '.'
                                        ); ?>"
                                        readonly>

                                </td>


                                <td>

                                    <button
                                        type="button"
                                        class="btn-hapus-detail">

                                        Hapus

                                    </button>

                                </td>

                            </tr>

                        <?php endforeach; ?>


                    <?php else: ?>


                        <!-- =================================
                             DETAIL SAAT TAMBAH
                        ================================== -->

                        <tr class="detail-row">

                            <td>

                                <select
                                    name="menu_id[]"
                                    class="menu-select"
                                    required>

                                    <option value="">
                                        -- Pilih Menu --
                                    </option>


                                    <?php foreach (
                                        $menu as $dataMenu
                                    ): ?>

                                        <option
                                            value="<?= $dataMenu['id']; ?>"
                                            data-harga="<?= $dataMenu['harga']; ?>">

                                            <?= htmlspecialchars(
                                                $dataMenu['nama_menu']
                                            ); ?>

                                            -
                                            Rp
                                            <?= number_format(
                                                $dataMenu['harga'],
                                                0,
                                                ',',
                                                '.'
                                            ); ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </td>


                            <td>

                                <input
                                    type="text"
                                    class="harga-display"
                                    value="Rp 0"
                                    readonly>

                            </td>


                            <td>

                                <input
                                    type="number"
                                    name="jumlah[]"
                                    class="jumlah-input"
                                    value="1"
                                    min="1"
                                    required>

                            </td>


                            <td>

                                <input
                                    type="text"
                                    class="subtotal-display"
                                    value="Rp 0"
                                    readonly>

                            </td>


                            <td>

                                <button
                                    type="button"
                                    class="btn-hapus-detail">

                                    Hapus

                                </button>

                            </td>

                        </tr>


                    <?php endif; ?>


                </tbody>

            </table>

        </div>


        <!-- =================================================
             TAMBAH MENU
        ================================================== -->

        <div style="margin-top: 15px;">

            <button
                type="button"
                id="tambahDetail">

                + Tambah Menu

            </button>

        </div>


        <!-- =================================================
             TOTAL
        ================================================== -->

        <div style="margin-top: 20px;">

            <h3>

                Total:

                <span id="totalDisplay">
                    Rp 0
                </span>

            </h3>

        </div>


        <!-- =================================================
             TOMBOL
        ================================================== -->

        <div class="actions">

            <button type="submit">

                <?= $edit
                    ? 'Simpan Perubahan'
                    : 'Simpan Pesanan';
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


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const container =
            document.getElementById(
                "detailContainer"
            );

        const tombolTambah =
            document.getElementById(
                "tambahDetail"
            );

        const totalDisplay =
            document.getElementById(
                "totalDisplay"
            );


        /*
        |--------------------------------------------------------------------------
        | FORMAT RUPIAH
        |--------------------------------------------------------------------------
        */

        function formatRupiah(angka) {

            return "Rp " +
                Number(angka || 0)
                    .toLocaleString("id-ID");

        }


        /*
        |--------------------------------------------------------------------------
        | HITUNG SATU BARIS
        |--------------------------------------------------------------------------
        */

        function hitungBaris(row) {

            const select =
                row.querySelector(
                    ".menu-select"
                );

            const jumlahInput =
                row.querySelector(
                    ".jumlah-input"
                );

            const hargaDisplay =
                row.querySelector(
                    ".harga-display"
                );

            const subtotalDisplay =
                row.querySelector(
                    ".subtotal-display"
                );


            if (
                !select ||
                !jumlahInput ||
                !hargaDisplay ||
                !subtotalDisplay
            ) {
                return 0;
            }


            const option =
                select.options[
                    select.selectedIndex
                ];


            let harga = 0;


            if (option) {

                harga = Number(
                    option.getAttribute(
                        "data-harga"
                    ) || 0
                );

            }


            const jumlah =
                Number(
                    jumlahInput.value || 0
                );


            const subtotal =
                harga * jumlah;


            hargaDisplay.value =
                formatRupiah(harga);


            subtotalDisplay.value =
                formatRupiah(subtotal);


            return subtotal;

        }


        /*
        |--------------------------------------------------------------------------
        | HITUNG TOTAL
        |--------------------------------------------------------------------------
        */

        function hitungTotal() {

            let total = 0;


            const rows =
                container.querySelectorAll(
                    ".detail-row"
                );


            rows.forEach(
                function (row) {

                    total +=
                        hitungBaris(row);

                }
            );


            totalDisplay.textContent =
                formatRupiah(total);

        }


        /*
        |--------------------------------------------------------------------------
        | PASANG EVENT KE BARIS
        |--------------------------------------------------------------------------
        */

        function pasangEvent(row) {

            const select =
                row.querySelector(
                    ".menu-select"
                );

            const jumlah =
                row.querySelector(
                    ".jumlah-input"
                );

            const tombolHapus =
                row.querySelector(
                    ".btn-hapus-detail"
                );


            if (select) {

                select.addEventListener(
                    "change",
                    function () {

                        hitungTotal();

                    }
                );

            }


            if (jumlah) {

                jumlah.addEventListener(
                    "input",
                    function () {

                        hitungTotal();

                    }
                );

            }


            if (tombolHapus) {

                tombolHapus.addEventListener(
                    "click",
                    function () {

                        const semuaBaris =
                            container.querySelectorAll(
                                ".detail-row"
                            );


                        /*
                        | Jangan sampai semua baris
                        | terhapus.
                        */

                        if (
                            semuaBaris.length <= 1
                        ) {

                            alert(
                                "Minimal harus ada satu menu."
                            );

                            return;

                        }


                        row.remove();

                        hitungTotal();

                    }
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | PASANG EVENT BARIS YANG SUDAH ADA
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                ".detail-row"
            )
            .forEach(
                function (row) {

                    pasangEvent(row);

                }
            );


        /*
        |--------------------------------------------------------------------------
        | TAMBAH BARIS MENU
        |--------------------------------------------------------------------------
        */

        tombolTambah.addEventListener(
            "click",
            function () {

                const row =
                    document.createElement(
                        "tr"
                    );


                row.classList.add(
                    "detail-row"
                );


                row.innerHTML = `

                    <td>

                        <select
                            name="menu_id[]"
                            class="menu-select"
                            required>

                            <option value="">
                                -- Pilih Menu --
                            </option>

                            <?php foreach ($menu as $dataMenu): ?>

                                <option
                                    value="<?= $dataMenu['id']; ?>"
                                    data-harga="<?= $dataMenu['harga']; ?>">

                                    <?= htmlspecialchars(
                                        $dataMenu['nama_menu']
                                    ); ?>

                                    -
                                    Rp
                                    <?= number_format(
                                        $dataMenu['harga'],
                                        0,
                                        ',',
                                        '.'
                                    ); ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </td>


                    <td>

                        <input
                            type="text"
                            class="harga-display"
                            value="Rp 0"
                            readonly>

                    </td>


                    <td>

                        <input
                            type="number"
                            name="jumlah[]"
                            class="jumlah-input"
                            value="1"
                            min="1"
                            required>

                    </td>


                    <td>

                        <input
                            type="text"
                            class="subtotal-display"
                            value="Rp 0"
                            readonly>

                    </td>


                    <td>

                        <button
                            type="button"
                            class="btn-hapus-detail">

                            Hapus

                        </button>

                    </td>

                `;


                container.appendChild(row);


                /*
                | Pasang event untuk baris
                | yang baru dibuat.
                */

                pasangEvent(row);


                hitungTotal();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | HITUNG TOTAL SAAT HALAMAN DIBUKA
        |--------------------------------------------------------------------------
        */

        hitungTotal();

    }
);

</script>


<?php require __DIR__ . "/../../layout/footer.php"; ?>