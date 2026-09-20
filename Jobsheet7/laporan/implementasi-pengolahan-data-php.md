## Implementasi Pengolahan Data dengan PHP

Pada Jobsheet 7, halaman aplikasi SIMPUS-Mini yang sebelumnya menggunakan HTML dikembangkan menjadi PHP. Penggunaan PHP memungkinkan halaman untuk mengolah data secara dinamis, menggunakan session, memproses data dari form, serta menampilkan pesan hasil proses kepada pengguna.

Struktur halaman juga dibuat lebih terorganisir dengan memisahkan bagian header dan footer ke dalam file `includes/header.php` dan `includes/footer.php`. Data buku dan anggota disimpan sementara menggunakan `$_SESSION`.

### 1. Halaman Beranda `index.php`

File `index.php` digunakan sebagai halaman utama aplikasi SIMPUS-Mini. Halaman ini menampilkan informasi singkat mengenai aplikasi serta ringkasan jumlah buku dan anggota.

```php
<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';

$totalBuku = count($_SESSION['buku'] ?? []);
$totalAnggota = count($_SESSION['anggota'] ?? []);
?>
```

Variabel `$page_title` digunakan untuk menentukan judul halaman menjadi **Beranda**. File `header.php` kemudian dimasukkan menggunakan `include`.

Jumlah buku dan anggota dihitung berdasarkan data yang tersimpan pada session menggunakan fungsi `count()`.

```php
$totalBuku = count($_SESSION['buku'] ?? []);
$totalAnggota = count($_SESSION['anggota'] ?? []);
```

Operator `?? []` digunakan untuk memberikan array kosong apabila data buku atau anggota belum tersedia pada session. Dengan demikian, fungsi `count()` tetap dapat digunakan tanpa menghasilkan error.

Nilai jumlah data kemudian ditampilkan pada bagian ringkasan:

```php
<article>
    <h3>Total Buku</h3>
    <p><?php echo $totalBuku; ?></p>
</article>

<article>
    <h3>Total Anggota</h3>
    <p><?php echo $totalAnggota; ?></p>
</article>

<article>
    <h3>Sedang Dipinjam</h3>
    <p>0</p>
</article>
```

Bagian **Total Buku** dan **Total Anggota** menampilkan jumlah data yang terdapat pada session. Sementara itu, bagian **Sedang Dipinjam** masih menampilkan nilai `0` karena fitur peminjaman belum diimplementasikan pada bagian ini.

Pada akhir halaman, `footer.php` dipanggil untuk menampilkan bagian footer aplikasi.

### 2. File `includes/header.php`

File `header.php` digunakan sebagai bagian header yang digunakan bersama oleh halaman-halaman PHP.

```php
<?php 
session_start(); 
 
$__jobsheetRoot = dirname(__DIR__); 
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']); 
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/'); 
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1); 
?>
```

`session_start()` digunakan untuk memulai session sehingga data yang tersimpan pada `$_SESSION` dapat digunakan oleh halaman PHP.

Beberapa variabel digunakan untuk menentukan lokasi relatif halaman terhadap folder utama Jobsheet. Variabel `$base` kemudian digunakan pada alamat file CSS dan link navigasi agar path tetap sesuai ketika halaman berada di folder yang berbeda.

Judul halaman dibuat secara dinamis menggunakan variabel `$page_title`:

```php
<title>
    SIMPUS-Mini<?php echo isset($page_title) ? ' | ' . $page_title : ''; ?>
</title>
```

Jika `$page_title` tersedia, judul halaman akan ditampilkan dengan format seperti:

**SIMPUS-Mini | Beranda**

Bagian navigasi juga menggunakan `$base` untuk menentukan alamat setiap halaman:

```php
<nav>
    <ul>
        <li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
        <li><a href="<?php echo $base; ?>buku/list.php">Daftar Buku</a></li>
        <li><a href="<?php echo $base; ?>buku/tambah.php">Tambah Buku</a></li>
        <li><a href="<?php echo $base; ?>anggota/list.php">Daftar Anggota</a></li>
        <li><a href="<?php echo $base; ?>anggota/tambah.php">Tambah Anggota</a></li>
    </ul>
</nav>
```

Dengan menggunakan `header.php`, struktur header dan navigasi tidak perlu ditulis ulang pada setiap halaman.

### 3. File `includes/footer.php`

File `footer.php` digunakan untuk menampilkan bagian akhir halaman dan memanggil JavaScript aplikasi.

```php
<footer>
    <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 7</p>
</footer>

<script src="<?php echo $base; ?>assets/js/app.js"></script>
```

Footer menampilkan identitas aplikasi dan nomor Jobsheet. File `app.js` juga dipanggil menggunakan nilai `$base` agar lokasi file JavaScript tetap sesuai.

Selain itu, terdapat bagian:

```php
<?php if (!empty($extra_scripts)): foreach ($extra_scripts as $src): ?>
<script src="<?php echo $src; ?>"></script>
<?php endforeach;
endif; ?>
```

Kode tersebut digunakan untuk memanggil JavaScript tambahan jika terdapat nilai pada `$extra_scripts`.

Dengan memisahkan footer ke dalam file tersendiri, setiap halaman tidak perlu menuliskan struktur footer dan pemanggilan script secara berulang.

### 4. Halaman Daftar Anggota `anggota/list.php`

File `anggota/list.php` digunakan untuk menampilkan data anggota yang tersimpan pada session.

```php
<?php
$page_title = "Daftar Anggota";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarAnggota = $_SESSION['anggota'] ?? [];
?>
```

Variabel `$page_title` menentukan judul halaman menjadi **Daftar Anggota**. File `header.php` dimasukkan menggunakan `include`.

Variabel `$flash` digunakan untuk mengambil pesan sementara dari `$_SESSION['flash']`. Setelah pesan diambil, `unset()` digunakan untuk menghapusnya dari session.

```php
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
```

Data anggota diambil dari session menggunakan:

```php
$daftarAnggota = $_SESSION['anggota'] ?? [];
```

Jika belum terdapat data anggota, nilai `$daftarAnggota` akan menjadi array kosong.

Data kemudian ditampilkan menggunakan percabangan:

```php
<?php if (empty($daftarAnggota)): ?>
    <tr>
        <td colspan="5">
            Belum ada data anggota. Silakan tambah lewat menu "Tambah Anggota".
        </td>
    </tr>
<?php else: ?>
```

Fungsi `empty()` digunakan untuk mengecek apakah data anggota kosong. Jika kosong, sistem menampilkan pesan bahwa belum terdapat data anggota.

Jika terdapat data, `foreach` digunakan untuk menampilkan setiap anggota:

```php
<?php foreach ($daftarAnggota as $anggota): ?>
    <tr>
        <td><?php echo $anggota['no_anggota']; ?></td>
        <td><?php echo $anggota['nama']; ?></td>
        <td><?php echo $anggota['alamat']; ?></td>
        <td><?php echo $anggota['no_hp']; ?></td>
        <td>
            <button type="button">Edit</button>
            <button type="button" class="btn-hapus">Hapus</button>
        </td>
    </tr>
<?php endforeach; ?>
```

Setiap data anggota ditampilkan ke dalam tabel berdasarkan atribut `no_anggota`, `nama`, `alamat`, dan `no_hp`.

Pada halaman ini juga terdapat fitur pencarian nama anggota dan tombol **Edit** serta **Hapus**. Tombol tersebut merupakan bagian dari antarmuka yang tersedia pada halaman.

### 5. Halaman Daftar Buku `buku/list.php`

File `buku/list.php` digunakan untuk menampilkan data buku yang tersimpan pada session.

```php
<?php
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarBuku = $_SESSION['buku'] ?? [];
?>
```

Data buku diambil dari `$_SESSION['buku']` dan disimpan ke dalam variabel `$daftarBuku`.

Jika data buku kosong, sistem menampilkan pesan:

```php
<?php if (empty($daftarBuku)): ?>
    <tr>
        <td colspan="5">
            Belum ada data buku. Silakan tambah lewat menu "Tambah Buku".
        </td>
    </tr>
<?php else: ?>
```

Jika terdapat data, setiap buku ditampilkan menggunakan `foreach`:

```php
<?php foreach ($daftarBuku as $buku): ?>
    <tr>
        <td><?php echo $buku['judul']; ?></td>
        <td><?php echo $buku['pengarang']; ?></td>
        <td><?php echo $buku['tahun']; ?></td>
        <td><?php echo $buku['stok']; ?></td>
        <td>
            <button type="button">Edit</button>
            <button type="button" class="btn-hapus">Hapus</button>
        </td>
    </tr>
<?php endforeach; ?>
```

Data `judul`, `pengarang`, `tahun`, dan `stok` ditampilkan pada masing-masing kolom tabel.

Halaman ini juga menyediakan pencarian berdasarkan judul buku serta tombol **Edit** dan **Hapus**.

### 6. Form Tambah Anggota `anggota/tambah.php`

File `anggota/tambah.php` digunakan untuk menampilkan form penambahan data anggota.

```php
<form id="form-tambah" method="post" action="proses_tambah.php">
```

Form menggunakan metode `POST` dan mengirimkan data menuju `proses_tambah.php`.

Form anggota terdiri dari beberapa field:

- `nama` untuk nama anggota.
- `no_anggota` untuk nomor anggota.
- `alamat` untuk alamat anggota.
- `no_hp` untuk nomor HP anggota.

Field nama dan nomor anggota memiliki atribut `required`:

```html
<input type="text" id="nama" name="nama" required>
```

```html
<input type="text" id="no_anggota" name="no_anggota" required>
```

Artinya, kedua field tersebut wajib diisi sebelum data dikirim.

Sedangkan alamat dan nomor HP tidak memiliki atribut `required`, sehingga dapat dikosongkan.

Setelah tombol **Simpan** ditekan, data dikirim ke `proses_tambah.php` untuk dilakukan validasi dan penyimpanan.

### 7. Form Tambah Buku `buku/tambah.php`

File `buku/tambah.php` digunakan untuk menampilkan form penambahan data buku.

```php
<form id="form-tambah" method="post" action="proses_tambah.php">
```

Form menggunakan metode `POST` dan mengirimkan data ke `proses_tambah.php`.

Field yang tersedia adalah:

- `judul`
- `pengarang`
- `tahun`
- `isbn`
- `stok`
- `kategori`

Field judul dan pengarang wajib diisi menggunakan atribut `required`.

Field tahun menggunakan batas nilai:

```html
<input
    type="number"
    id="tahun"
    name="tahun"
    min="1900"
    max="2026"
    required
>
```

Tahun dibatasi antara 1900 sampai 2026.

Field stok menggunakan:

```html
<input
    type="number"
    id="stok"
    name="stok"
    min="0"
    required
>
```

Nilai stok memiliki batas minimum `0`.

Kategori buku disediakan dalam bentuk pilihan menggunakan `<select>` dengan tiga pilihan, yaitu Fiksi, Non-Fiksi, dan Referensi.

### 8. Proses Penambahan Anggota `anggota/proses_tambah.php`

File `anggota/proses_tambah.php` digunakan untuk menerima, memvalidasi, dan menyimpan data anggota yang dikirim dari form.

Pada awal file, session dijalankan menggunakan:

```php
session_start();
```

Data dari form kemudian diambil menggunakan `$_POST`:

```php
$nama = trim($_POST['nama'] ?? '');
$noAnggota = trim($_POST['no_anggota'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');
```

Fungsi `trim()` digunakan untuk menghapus spasi kosong pada awal dan akhir input.

Selanjutnya dilakukan validasi terhadap field yang wajib diisi:

```php
$errors = [];

if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}

if ($noAnggota === '') {
    $errors[] = "No. Anggota wajib diisi.";
}
```

Jika terdapat kesalahan, pesan disimpan ke session sebagai flash message:

```php
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => implode(' ', $errors)
    ];

    header('Location: tambah.php');
    exit;
}
```

`header()` digunakan untuk mengarahkan pengguna kembali ke halaman `tambah.php`, sedangkan `exit` menghentikan proses setelah pengalihan dilakukan.

Jika validasi berhasil, session `anggota` dibuat jika belum tersedia:

```php
if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}
```

Data anggota kemudian ditambahkan ke dalam array session:

```php
$_SESSION['anggota'][] = [
    'nama' => $nama,
    'no_anggota' => $noAnggota,
    'alamat' => $alamat,
    'no_hp' => $noHp,
];
```

Setelah berhasil disimpan, sistem membuat flash message keberhasilan:

```php
$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Anggota berhasil ditambahkan.'
];

header('Location: list.php');
exit;
```

Pengguna kemudian diarahkan kembali ke halaman daftar anggota.

### 9. Proses Penambahan Buku `buku/proses_tambah.php`

File `buku/proses_tambah.php` digunakan untuk menerima, memvalidasi, dan menyimpan data buku dari form tambah buku.

Data form diambil menggunakan `$_POST`:

```php
$judul = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun = $_POST['tahun'] ?? '';
$isbn = trim($_POST['isbn'] ?? '');
$stok = $_POST['stok'] ?? '';
$kategori = trim($_POST['kategori'] ?? '');
```

Setelah data diterima, dilakukan validasi server-side.

```php
$errors = [];

if ($judul === '') {
    $errors[] = "Judul wajib diisi.";
}

if ($pengarang === '') {
    $errors[] = "Pengarang wajib diisi.";
}

if (!is_numeric($tahun) || $tahun < 1900 || $tahun > 2026) {
    $errors[] = "Tahun harus di antara 1900-2026.";
}

if (!is_numeric($stok) || $stok < 0) {
    $errors[] = "Stok tidak boleh negatif.";
}
```

Validasi dilakukan untuk memastikan judul dan pengarang tidak kosong, tahun berada pada rentang 1900 sampai 2026, serta stok tidak bernilai negatif.

Validasi server-side tetap dilakukan meskipun form sebelumnya memiliki validasi client-side. Hal ini dilakukan agar data tetap diperiksa ketika JavaScript tidak digunakan atau ketika request dikirim secara langsung ke server.

Jika terdapat kesalahan, sistem menyimpan pesan error ke session dan mengarahkan pengguna kembali ke halaman tambah buku:

```php
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => implode(' ', $errors)
    ];

    header('Location: tambah.php');
    exit;
}
```

Jika validasi berhasil, session `buku` dibuat apabila belum tersedia:

```php
if (!isset($_SESSION['buku'])) {
    $_SESSION['buku'] = [];
}
```

Data buku kemudian ditambahkan ke dalam session:

```php
$_SESSION['buku'][] = [
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => (int) $tahun,
    'isbn' => $isbn,
    'stok' => (int) $stok,
    'kategori' => $kategori,
];
```

Nilai `tahun` dan `stok` dikonversi menjadi integer menggunakan `(int)`.

Setelah berhasil disimpan, sistem memberikan pesan keberhasilan dan mengarahkan pengguna kembali ke daftar buku:

```php
$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Buku berhasil ditambahkan.'
];

header('Location: list.php');
exit;
```

### 10. Alur Pengolahan Data

Secara keseluruhan, proses penambahan data pada Jobsheet 7 dapat digambarkan sebagai berikut:

**Form Tambah → `POST` → `proses_tambah.php` → Validasi Server-side → Session → Flash Message → `list.php`**

Untuk data anggota:

**`anggota/tambah.php` → `anggota/proses_tambah.php` → `$_SESSION['anggota']` → `anggota/list.php`**

Sedangkan untuk data buku:

**`buku/tambah.php` → `buku/proses_tambah.php` → `$_SESSION['buku']` → `buku/list.php`**

Dengan alur tersebut, data yang dimasukkan melalui form dapat diproses dan kemudian ditampilkan kembali pada halaman daftar.

### 11. Kesimpulan

Pada Jobsheet 7, SIMPUS-Mini dikembangkan dari halaman HTML menjadi aplikasi berbasis PHP. Penggunaan PHP memungkinkan data buku dan anggota diproses menggunakan form `POST`, divalidasi di sisi server, serta disimpan sementara menggunakan `$_SESSION`.

Penggunaan `header.php` dan `footer.php` juga membuat struktur halaman lebih terorganisir karena bagian yang sama dapat digunakan oleh beberapa halaman. Selain itu, flash message digunakan untuk memberikan informasi kepada pengguna mengenai hasil proses penambahan data.

Dengan demikian, proses pengolahan data pada SIMPUS-Mini sudah memiliki alur dari pengisian form, pemrosesan dan validasi data, penyimpanan ke session, hingga menampilkan data pada halaman daftar.