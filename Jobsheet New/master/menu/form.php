<?php

require __DIR__ . "/../../config/database.php";

$id = $_GET['id'] ?? null;

$edit = false;

$kode_menu = '';
$nama_menu = '';
$kategori_id = '';
$harga = '';
$stok = '';
$status = 'Tersedia';


/*
|--------------------------------------------------------------------------
| AMBIL DATA KATEGORI
|--------------------------------------------------------------------------
*/

$queryKategori = $pdo->query("
    SELECT
        id,
        nama_kategori
    FROM kategori
    ORDER BY nama_kategori ASC
");

$kategori = $queryKategori->fetchAll();


/*
|--------------------------------------------------------------------------
| MODE EDIT
|--------------------------------------------------------------------------
*/

if ($id !== null) {

    $stmt = $pdo->prepare("
        SELECT
            id,
            kode_menu,
            nama_menu,
            kategori_id,
            harga,
            stok,
            status
        FROM menu
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

    $kode_menu = $data['kode_menu'];
    $nama_menu = $data['nama_menu'];
    $kategori_id = $data['kategori_id'];
    $harga = $data['harga'];
    $stok = $data['stok'];
    $status = $data['status'];
}


$page_title = $edit
    ? "Edit Menu"
    : "Tambah Menu";

?>

<?php require __DIR__ . "/../../layout/header.php"; ?>


<section>

    <h2>

        <?= $edit
            ? 'Edit Menu'
            : 'Tambah Menu';
        ?>

    </h2>


    <p>

        <?= $edit
            ? 'Perbarui data menu Cafe_Najwa.'
            : 'Tambahkan menu baru ke Cafe_Najwa.';
        ?>

    </p>

</section>


<section>

    <form
        action="proses.php"
        method="POST">


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


        <div>

            <label for="kode_menu">
                Kode Menu
            </label>

            <input
                type="text"
                id="kode_menu"
                name="kode_menu"
                value="<?= htmlspecialchars(
                    $kode_menu
                ); ?>"
                placeholder="Contoh: M001"
                maxlength="20"
                required>

        </div>


        <div>

            <label for="nama_menu">
                Nama Menu
            </label>

            <input
                type="text"
                id="nama_menu"
                name="nama_menu"
                value="<?= htmlspecialchars(
                    $nama_menu
                ); ?>"
                placeholder="Contoh: Es Kopi Susu"
                maxlength="150"
                required>

        </div>


        <div>

            <label for="kategori_id">
                Kategori
            </label>

            <select
                id="kategori_id"
                name="kategori_id"
                required>

                <option value="">
                    -- Pilih Kategori --
                </option>


                <?php foreach ($kategori as $dataKategori): ?>

                    <option
                        value="<?= $dataKategori['id']; ?>"
                        <?= (string)$kategori_id ===
                            (string)$dataKategori['id']
                            ? 'selected'
                            : '';
                        ?>>

                        <?= htmlspecialchars(
                            $dataKategori['nama_kategori']
                        ); ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <div>

            <label for="harga">
                Harga
            </label>

            <input
                type="number"
                id="harga"
                name="harga"
                value="<?= htmlspecialchars(
                    $harga
                ); ?>"
                placeholder="Contoh: 15000"
                min="0"
                step="0.01"
                required>

        </div>


        <div>

            <label for="stok">
                Stok
            </label>

            <input
                type="number"
                id="stok"
                name="stok"
                value="<?= htmlspecialchars(
                    $stok
                ); ?>"
                placeholder="Contoh: 20"
                min="0"
                required>

        </div>


        <div>

            <label for="status">
                Status
            </label>

            <select
                id="status"
                name="status"
                required>

                <option
                    value="Tersedia"
                    <?= $status === 'Tersedia'
                        ? 'selected'
                        : '';
                    ?>>
                    Tersedia
                </option>


                <option
                    value="Tidak Tersedia"
                    <?= $status === 'Tidak Tersedia'
                        ? 'selected'
                        : '';
                    ?>>
                    Tidak Tersedia
                </option>

            </select>

        </div>


        <div class="actions">

            <button type="submit">

                <?= $edit
                    ? 'Simpan Perubahan'
                    : 'Simpan Menu';
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


<?php require __DIR__ . "/../../layout/footer.php"; ?>