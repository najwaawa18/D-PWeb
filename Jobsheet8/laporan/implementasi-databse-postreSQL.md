# Implementasi Database PostgreSQL pada SIMPUS-Mini

Pada Jobsheet 8, aplikasi SIMPUS-Mini dikembangkan dari penyimpanan data menggunakan `$_SESSION` menjadi penyimpanan menggunakan **database PostgreSQL**. Data buku dan anggota yang sebelumnya hanya tersimpan sementara pada session sekarang disimpan secara permanen di dalam database.

Perubahan utama pada Jobsheet 8 adalah penggunaan **PDO (PHP Data Objects)** untuk menghubungkan PHP dengan PostgreSQL, menjalankan query SQL, mengambil data dari tabel, serta menyimpan data baru ke database.

---

## 1. Koneksi Database dengan `koneksi.php`

File `includes/koneksi.php` digunakan untuk membuat koneksi antara aplikasi PHP dengan database PostgreSQL.

```php
<?php
$host = "localhost";
$port = "5432";
$db   = "simpus_mini";
$user = "postgres";

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$db",
        $user,
        $pass
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
```

Variabel `$host`, `$port`, `$db`, dan `$user` digunakan untuk menentukan informasi database yang akan diakses. Database yang digunakan pada proyek ini adalah `simpus_mini` dengan PostgreSQL.

Koneksi dibuat menggunakan objek `PDO`. Pada bagian DSN terdapat `pgsql`, yang menunjukkan bahwa PDO digunakan untuk terhubung dengan database PostgreSQL.

```php
$pdo = new PDO(
    "pgsql:host=$host;port=$port;dbname=$db",
    $user,
    $pass
);
```

Setelah koneksi dibuat, digunakan:

```php
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

Pengaturan tersebut membuat PDO menggunakan mode exception ketika terjadi kesalahan pada proses database. Dengan demikian, kesalahan koneksi atau query dapat ditangani sebagai `PDOException`.

Jika koneksi gagal, bagian `catch` akan menampilkan pesan:

```php
catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
```

### Perubahan dari Jobsheet 7

Pada Jobsheet 7, data buku dan anggota disimpan menggunakan `$_SESSION`. Pada Jobsheet 8, penyimpanan tersebut digantikan dengan database PostgreSQL sehingga data dapat diambil dan disimpan melalui query SQL.

---

## 2. Mengambil Data Anggota dari Database — `anggota/list.php`

Pada Jobsheet 7, daftar anggota diambil dari session. Pada Jobsheet 8, data anggota diambil langsung dari tabel `anggota` pada database.

```php
require __DIR__ . '/../includes/koneksi.php';

$daftarAnggota = $pdo->query(
    "SELECT * FROM anggota ORDER BY id DESC"
)->fetchAll(PDO::FETCH_ASSOC);
```

Baris berikut digunakan untuk memasukkan file koneksi database:

```php
require __DIR__ . '/../includes/koneksi.php';
```

Dengan demikian, objek `$pdo` yang dibuat pada `koneksi.php` dapat digunakan pada halaman daftar anggota.

Query:

```sql
SELECT * FROM anggota ORDER BY id DESC
```

digunakan untuk mengambil seluruh data dari tabel `anggota`. `ORDER BY id DESC` membuat data diurutkan berdasarkan `id` dari yang terbesar ke yang terkecil, sehingga data yang lebih baru ditampilkan terlebih dahulu.

Hasil query kemudian diambil menggunakan:

```php
fetchAll(PDO::FETCH_ASSOC)
```

`fetchAll()` mengambil seluruh hasil query, sedangkan `PDO::FETCH_ASSOC` membuat setiap data dikembalikan dalam bentuk array asosiatif berdasarkan nama kolom.

Hasilnya disimpan pada variabel:

```php
$daftarAnggota
```

Variabel tersebut kemudian digunakan oleh `foreach` untuk menampilkan data ke dalam tabel.

```php
foreach ($daftarAnggota as $anggota):
```

Dengan perubahan ini, isi tabel tidak lagi berasal dari session, tetapi langsung dari database PostgreSQL.

---

## 3. Menambahkan Data Anggota ke Database — `anggota/proses_tambah.php`

Pada Jobsheet 8, proses penambahan anggota tidak lagi menggunakan:

```php
$_SESSION['anggota'][]
```

seperti pada Jobsheet 7. Data sekarang dimasukkan ke tabel `anggota` menggunakan query `INSERT`.

```php
$stmt = $pdo->prepare(
    "INSERT INTO anggota (nama, no_anggota, alamat, no_hp)
     VALUES (:nama, :no_anggota, :alamat, :no_hp)
     RETURNING id"
);

$stmt->execute([
    'nama' => $nama,
    'no_anggota' => $noAnggota,
    'alamat' => $alamat,
    'no_hp' => $noHp,
]);
```

### `prepare()`

Method `prepare()` digunakan untuk menyiapkan query SQL sebelum dijalankan.

Pada query terdapat placeholder seperti:

```text
:nama
:no_anggota
:alamat
:no_hp
```

Placeholder tersebut nantinya diisi menggunakan data yang berasal dari form.

### `execute()`

Method `execute()` digunakan untuk menjalankan query yang sudah disiapkan.

Data dari form dimasukkan ke placeholder melalui array:

```php
$stmt->execute([
    'nama' => $nama,
    'no_anggota' => $noAnggota,
    'alamat' => $alamat,
    'no_hp' => $noHp,
]);
```

Penggunaan `prepare()` dan `execute()` membuat data form dapat dikirim ke query menggunakan parameter, bukan dengan menggabungkannya langsung ke string SQL.

### `RETURNING id`

Pada query terdapat:

```sql
RETURNING id
```

Bagian ini digunakan pada PostgreSQL untuk mengembalikan nilai `id` dari data yang baru dimasukkan.

Setelah proses `INSERT` berhasil, aplikasi memberikan flash message:

```php
$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Anggota berhasil ditambahkan.'
];
```

Kemudian pengguna diarahkan kembali ke halaman daftar anggota.

---

## 4. Mengambil Data Buku dari Database — `buku/list.php`

Sama seperti data anggota, data buku pada Jobsheet 8 juga diambil langsung dari database.

```php
require __DIR__ . '/../includes/koneksi.php';

$daftarBuku = $pdo->query(
    "SELECT * FROM buku ORDER BY id DESC"
)->fetchAll(PDO::FETCH_ASSOC);
```

Query tersebut mengambil seluruh data dari tabel `buku`:

```sql
SELECT * FROM buku ORDER BY id DESC
```

Data kemudian disimpan pada `$daftarBuku` dalam bentuk array asosiatif.

Data tersebut digunakan oleh `foreach` untuk menghasilkan baris tabel:

```php
foreach ($daftarBuku as $buku):
```

Setiap nilai kolom kemudian ditampilkan menggunakan nama kolom dari database, seperti:

```php
$buku['judul']
$buku['pengarang']
$buku['tahun']
$buku['stok']
```

Dengan demikian, tabel daftar buku sekarang menampilkan data yang tersimpan pada tabel `buku` di PostgreSQL.

---

## 5. Menambahkan Data Buku ke Database — `buku/proses_tambah.php`

Pada proses tambah buku, data yang dikirim melalui form terlebih dahulu diambil dari `$_POST`.

```php
$judul = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun = $_POST['tahun'] ?? '';
$isbn = trim($_POST['isbn'] ?? '');
$stok = $_POST['stok'] ?? '';
$kategori = trim($_POST['kategori'] ?? '');
```

Setelah proses validasi server-side dilakukan, data dimasukkan ke database menggunakan `prepare()`.

```php
$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori)
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)
     RETURNING id"
);
```

Query tersebut memasukkan data ke beberapa kolom pada tabel `buku`, yaitu:

- `judul`
- `pengarang`
- `tahun`
- `isbn`
- `stok`
- `kategori`

Data kemudian dikirim melalui `execute()`:

```php
$stmt->execute([
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => (int) $tahun,
    'isbn' => $isbn,
    'stok' => (int) $stok,
    'kategori' => $kategori,
]);
```

Pada bagian `tahun` dan `stok` digunakan casting:

```php
(int) $tahun
(int) $stok
```

Casting tersebut mengubah nilai menjadi tipe integer sebelum dikirim ke database.

Setelah proses `INSERT` berhasil, flash message keberhasilan disimpan ke session dan pengguna diarahkan kembali ke `list.php`.

---

## 6. Perubahan pada `index.php`

Pada Jobsheet 7, jumlah buku dan anggota dihitung dari data yang tersimpan di session. Pada Jobsheet 8, jumlah tersebut dihitung langsung dari database menggunakan SQL `COUNT()`.

```php
$totalBuku = $pdo->query(
    "SELECT COUNT(*) FROM buku"
)->fetchColumn();

$totalAnggota = $pdo->query(
    "SELECT COUNT(*) FROM anggota"
)->fetchColumn();
```

Query:

```sql
SELECT COUNT(*) FROM buku
```

digunakan untuk menghitung jumlah seluruh data pada tabel `buku`.

Sedangkan:

```sql
SELECT COUNT(*) FROM anggota
```

digunakan untuk menghitung jumlah seluruh data pada tabel `anggota`.

Hasil query diambil menggunakan:

```php
fetchColumn()
```

Karena query `COUNT(*)` hanya menghasilkan satu nilai, `fetchColumn()` digunakan untuk mengambil nilai tersebut secara langsung.

Nilai yang diperoleh kemudian ditampilkan pada kartu ringkasan:

```php
<p><?php echo $totalBuku; ?></p>
```

dan:

```php
<p><?php echo $totalAnggota; ?></p>
```

Dengan demikian, jumlah buku dan anggota pada halaman beranda akan mengikuti data yang sebenarnya terdapat di database.

---

## 7. Perubahan pada `header.php`

Struktur utama `header.php` masih digunakan untuk menyediakan header, navigasi, dan path relatif. Namun, pada Jobsheet 8 halaman PHP sudah terhubung dengan sistem database melalui file `koneksi.php` pada halaman yang membutuhkan data.

Bagian perhitungan `$base` tetap digunakan untuk memastikan alamat file seperti CSS, JavaScript, dan halaman PHP dapat ditemukan dengan benar meskipun proyek dijalankan melalui subfolder.

```php
$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(
    str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))),
    '/'
);
$base = $__rel === ''
    ? ''
    : str_repeat('../', substr_count($__rel, '/') + 1);
```

Nilai `$base` kemudian digunakan pada link navigasi dan file CSS, contohnya:

```php
<link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
```

dan:

```php
<a href="<?php echo $base; ?>buku/list.php">Daftar Buku</a>
```

Dengan cara ini, alamat file dapat menyesuaikan posisi halaman terhadap root proyek.

---

## 8. `footer.php`

Pada `footer.php`, struktur footer dan pemanggilan JavaScript tetap digunakan.

```php
<footer>
    <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 8</p>
</footer>

<script src="<?php echo $base; ?>assets/js/app.js"></script>
```

Perubahan yang terlihat adalah keterangan **Jobsheet 8** pada bagian footer.

File `app.js` tetap dipanggil agar fitur JavaScript seperti pencarian, menu hamburger, validasi form, dan konfirmasi hapus tetap dapat digunakan pada halaman PHP.

---

## 9. Alur Pengolahan Data pada Jobsheet 8

Setelah menggunakan database PostgreSQL, alur pengolahan data menjadi:

```text
Form Tambah
     ↓
$_POST
     ↓
Validasi Server-Side
     ↓
prepare() + execute()
     ↓
INSERT ke Database PostgreSQL
     ↓
Flash Message
     ↓
Redirect ke list.php
     ↓
SELECT dari Database
     ↓
Data ditampilkan pada Tabel
```

Contohnya pada proses tambah buku:

1. Pengguna mengisi form tambah buku.
2. Form mengirim data menggunakan method `POST`.
3. `proses_tambah.php` mengambil data dari `$_POST`.
4. Data diperiksa menggunakan validasi server-side.
5. Query `INSERT` disiapkan menggunakan `prepare()`.
6. Data dikirim menggunakan `execute()`.
7. Data tersimpan pada tabel `buku` di PostgreSQL.
8. Flash message keberhasilan disimpan pada session.
9. Pengguna diarahkan ke halaman daftar buku.
10. `list.php` menjalankan query `SELECT` untuk mengambil data terbaru dari database.
11. Data ditampilkan pada tabel.

---

## 10. Perubahan Utama dari Jobsheet 7 ke Jobsheet 8

Perubahan utama yang dilakukan pada Jobsheet 8 adalah:

| Jobsheet 7 | Jobsheet 8 |
|---|---|
| Data buku disimpan di `$_SESSION['buku']` | Data buku disimpan di tabel `buku` |
| Data anggota disimpan di `$_SESSION['anggota']` | Data anggota disimpan di tabel `anggota` |
| `list.php` membaca data dari session | `list.php` menggunakan `SELECT` dari database |
| Proses tambah menggunakan array session | Proses tambah menggunakan `INSERT` |
| Jumlah data dihitung dari session | Jumlah data dihitung menggunakan `COUNT(*)` |
| Belum menggunakan koneksi database | Menggunakan PDO dan PostgreSQL |
| Penyimpanan bersifat sementara melalui session | Data tersimpan pada database |

---

## Kesimpulan

Pada Jobsheet 8, SIMPUS-Mini mengalami perubahan dari sistem penyimpanan data berbasis session menjadi sistem yang menggunakan **database PostgreSQL**. PHP menggunakan **PDO** sebagai penghubung antara aplikasi dengan database.

Data buku dan anggota sekarang dapat diambil menggunakan query `SELECT` dan ditambahkan menggunakan query `INSERT`. Penggunaan `prepare()` dan `execute()` digunakan dalam proses penyimpanan data, sedangkan `COUNT(*)` digunakan untuk menampilkan jumlah buku dan anggota pada halaman beranda.

Dengan perubahan ini, data tidak lagi hanya berada pada session selama proses aplikasi berlangsung, tetapi disimpan pada tabel database sehingga dapat digunakan kembali ketika halaman dibuka kembali.