<?php

require __DIR__ . "/../../config/database.php";


// ==========================================
// CEK MODE
// ==========================================

$id = $_GET['id'] ?? null;

$edit = false;

$nomor_meja = '';

$kapasitas = '';

$status = 'Kosong';


// ==========================================
// MODE EDIT
// ==========================================

if ($id !== null) {

    $stmt = $pdo->prepare("
        SELECT
            id,
            nomor_meja,
            kapasitas,
            status
        FROM meja
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

    $nomor_meja = $data['nomor_meja'];

    $kapasitas = $data['kapasitas'];

    $status = $data['status'];

}


// ==========================================
// JUDUL HALAMAN
// ==========================================

$page_title = $edit
    ? "Edit Meja"
    : "Tambah Meja";

?>


<?php require __DIR__ . "/../../layout/header.php"; ?>


<section>

    <h2>

        <?= $edit
            ? 'Edit Meja'
            : 'Tambah Meja';
        ?>

    </h2>


    <p>

        <?= $edit
            ? 'Perbarui data meja KAFEIN.'
            : 'Tambahkan data meja baru.';
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
        NOMOR MEJA
        ==========================================
        -->

        <div>

            <label for="nomor_meja">
                Nomor Meja
            </label>

            <input
                type="text"
                id="nomor_meja"
                name="nomor_meja"
                value="<?= htmlspecialchars($nomor_meja); ?>"
                placeholder="Contoh: M01"
                maxlength="20"
                required>

        </div>


        <!--
        ==========================================
        KAPASITAS
        ==========================================
        -->

        <div>

            <label for="kapasitas">
                Kapasitas
            </label>

            <input
                type="number"
                id="kapasitas"
                name="kapasitas"
                value="<?= htmlspecialchars($kapasitas); ?>"
                placeholder="Contoh: 4"
                min="1"
                required>

        </div>


        <!--
        ==========================================
        STATUS
        ==========================================
        -->

        <div>

            <label for="status">
                Status
            </label>

            <select
                id="status"
                name="status"
                required>

                <option
                    value="Kosong"
                    <?= $status === 'Kosong' ? 'selected' : ''; ?>>
                    Kosong
                </option>

                <option
                    value="Terisi"
                    <?= $status === 'Terisi' ? 'selected' : ''; ?>>
                    Terisi
                </option>

                <option
                    value="Dipesan"
                    <?= $status === 'Dipesan' ? 'selected' : ''; ?>>
                    Dipesan
                </option>

            </select>

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
                    : 'Simpan Meja';
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