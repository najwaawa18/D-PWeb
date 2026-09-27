<?php

require __DIR__ . "/../../config/database.php";

$id = $_GET['id'] ?? null;

$edit = false;

$kode_pelanggan = '';
$nama = '';
$no_hp = '';
$email = '';


if ($id !== null) {

    $stmt = $pdo->prepare("
        SELECT
            id,
            kode_pelanggan,
            nama,
            no_hp,
            email
        FROM pelanggan
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

    $kode_pelanggan = $data['kode_pelanggan'];
    $nama = $data['nama'];
    $no_hp = $data['no_hp'];
    $email = $data['email'];
}


$page_title = $edit
    ? "Edit Pelanggan"
    : "Tambah Pelanggan";

?>

<?php require __DIR__ . "/../../layout/header.php"; ?>


<section>

    <h2>
        <?= $edit
            ? 'Edit Pelanggan'
            : 'Tambah Pelanggan';
        ?>
    </h2>

    <p>

        <?= $edit
            ? 'Perbarui data pelanggan Cafe_Najwa.'
            : 'Tambahkan data pelanggan baru.';
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

            <label for="kode_pelanggan">
                Kode Pelanggan
            </label>

            <input
                type="text"
                id="kode_pelanggan"
                name="kode_pelanggan"
                value="<?= htmlspecialchars(
                    $kode_pelanggan
                ); ?>"
                placeholder="Contoh: P001"
                maxlength="20"
                required>

        </div>


        <div>

            <label for="nama">
                Nama Pelanggan
            </label>

            <input
                type="text"
                id="nama"
                name="nama"
                value="<?= htmlspecialchars(
                    $nama
                ); ?>"
                placeholder="Contoh: Najwa"
                maxlength="150"
                required>

        </div>


        <div>

            <label for="no_hp">
                Nomor HP
            </label>

            <input
                type="text"
                id="no_hp"
                name="no_hp"
                value="<?= htmlspecialchars(
                    $no_hp ?? ''
                ); ?>"
                placeholder="Contoh: 081234567890"
                maxlength="30">

        </div>


        <div>

            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars(
                    $email ?? ''
                ); ?>"
                placeholder="Contoh: nama@email.com"
                maxlength="150">

        </div>


        <div class="actions">

            <button type="submit">

                <?= $edit
                    ? 'Simpan Perubahan'
                    : 'Simpan Pelanggan';
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