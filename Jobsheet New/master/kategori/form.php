<?php

require __DIR__ . "/../../config/database.php";


// ==========================================
// CEK MODE
// ==========================================

$id = $_GET['id'] ?? null;

$edit = false;

$nama_kategori = '';


// ==========================================
// MODE EDIT
// ==========================================

if ($id !== null) {

    $stmt = $pdo->prepare("
        SELECT id, nama_kategori
        FROM kategori
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

    $nama_kategori = $data['nama_kategori'];

}


// ==========================================
// JUDUL HALAMAN
// ==========================================

$page_title = $edit
    ? "Edit Kategori"
    : "Tambah Kategori";

?>


<?php require __DIR__ . "/../../layout/header.php"; ?>


<section>

    <h2>

        <?= $edit
            ? 'Edit Kategori'
            : 'Tambah Kategori';
        ?>

    </h2>


    <p>

        <?= $edit
            ? 'Perbarui data kategori menu.'
            : 'Tambahkan kategori menu baru.';
        ?>

    </p>

</section>


<section>

    <form
        action="proses.php"
        method="POST">


        <!--
        ==========================================
        ID
        ==========================================
        -->

        <?php if ($edit): ?>

            <input
                type="hidden"
                name="id"
                value="<?= htmlspecialchars($id); ?>">

        <?php endif; ?>


        <!--
        ==========================================
        AKSI
        ==========================================
        -->

        <input
            type="hidden"
            name="aksi"
            value="<?= $edit ? 'edit' : 'tambah'; ?>">


        <!--
        ==========================================
        NAMA KATEGORI
        ==========================================
        -->

        <div>

            <label for="nama_kategori">
                Nama Kategori
            </label>

            <input
                type="text"
                id="nama_kategori"
                name="nama_kategori"
                value="<?= htmlspecialchars($nama_kategori); ?>"
                placeholder="Contoh: Kopi"
                maxlength="100"
                required>

        </div>


        <!--
        ==========================================
        TOMBOL
        ==========================================
        -->

        <div class="actions">

            <button type="submit">

                <?= $edit
                    ? 'Simpan Perubahan'
                    : 'Simpan Kategori';
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