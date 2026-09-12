## Perubahan HTML dari Jobsheet 4 ke Jobsheet 5

Pada Jobsheet 5, struktur HTML dari Jobsheet 4 mengalami beberapa penyesuaian untuk mendukung fitur JavaScript, seperti pencarian data, penghapusan data, validasi form, dan navigasi responsif.

### 1. Penambahan Viewport

Pada bagian `<head>` ditambahkan:

```html
<meta name="viewport" content="width=device-width, initial-scale=1">
```

Penambahan ini membuat tampilan halaman dapat menyesuaikan ukuran layar perangkat, sehingga lebih mendukung tampilan responsif.

### 2. Penambahan Tombol Menu pada Header

Pada bagian `<header>` ditambahkan tombol:

```html
<button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>
```

Tombol ini digunakan sebagai tombol menu atau **hamburger menu**. `id="nav-toggle-btn"` nantinya digunakan oleh JavaScript untuk mengatur tampilan navigasi, terutama pada layar dengan ukuran kecil.

### 3. Penambahan Fitur Pencarian pada Daftar Buku dan Anggota

Pada halaman `buku/list.html` dan `anggota/list.html` ditambahkan kotak pencarian.

Contohnya pada Daftar Buku:

```html
<div class="search-box">
    <label for="search-input">Cari Judul Buku</label>
    <input type="text" id="search-input" placeholder="Ketik judul buku...">
</div>
```

Sedangkan pada Daftar Anggota:

```html
<div class="search-box">
    <label for="search-input">Cari Nama Anggota</label>
    <input type="text" id="search-input" placeholder="Ketik nama anggota...">
</div>
```

Elemen tersebut digunakan sebagai tempat pengguna memasukkan kata kunci pencarian. `id="search-input"` digunakan sebagai identitas elemen yang akan diakses oleh JavaScript untuk menjalankan fitur pencarian.

### 4. Penambahan `table-responsive`

Tabel pada halaman Daftar Buku dan Daftar Anggota sekarang dibungkus dengan:

```html
<div class="table-responsive">
    <table>
        ...
    </table>
</div>
```

Class `table-responsive` digunakan untuk membantu tabel menyesuaikan tampilan pada layar yang lebih kecil sehingga tabel tetap dapat digeser secara horizontal jika ukurannya melebihi layar.

### 5. Penambahan Class pada Tombol Hapus

Pada Jobsheet 5, tombol Hapus diberikan class khusus:

```html
<button type="button" class="btn-hapus">Hapus</button>
```

Class `btn-hapus` digunakan sebagai penanda agar JavaScript dapat mengenali tombol Hapus dan memberikan fungsi penghapusan pada data yang dipilih.

### 6. Penambahan `id="form-tambah"` pada Form

Pada halaman `buku/tambah.html` dan `anggota/tambah.html`, elemen `<form>` diberi ID:

```html
<form id="form-tambah">
```

ID tersebut digunakan oleh JavaScript untuk mengenali form tambah data dan menjalankan proses ketika form disubmit.

### 7. Perubahan Atribut `required` pada Form

Pada Jobsheet 4, beberapa input menggunakan atribut `required`, sedangkan pada Jobsheet 5 atribut tersebut dihilangkan.

Contohnya dari:

```html
<input type="text" id="judul" name="judul" required>
```

menjadi:

```html
<input type="text" id="judul" name="judul">
```

Hal ini memungkinkan validasi input ditangani oleh JavaScript sehingga pesan atau aturan validasi dapat dibuat sesuai kebutuhan aplikasi.

### 8. Penambahan Pemanggilan JavaScript

Pada setiap halaman ditambahkan file JavaScript sebelum tag `</body>`.

Pada `index.html`:

```html
<script src="assets/js/app.js"></script>
```

Sedangkan pada halaman yang berada di dalam folder `buku` dan `anggota`:

```html
<script src="../assets/js/app.js"></script>
```

Pemanggilan `app.js` merupakan perubahan penting pada Jobsheet 5 karena HTML sekarang sudah terhubung dengan JavaScript. JavaScript inilah yang digunakan untuk menambahkan interaksi pada halaman, seperti **pencarian data, tombol hapus, validasi form, dan navigasi menu**.

### Kesimpulan Perubahan

Secara keseluruhan, HTML pada Jobsheet 5 masih menggunakan struktur dasar dari Jobsheet 4, tetapi ditambahkan beberapa **ID dan class sebagai penghubung dengan JavaScript**. Perubahan tersebut memungkinkan halaman yang sebelumnya hanya menampilkan data menjadi lebih interaktif, seperti dapat melakukan pencarian, menghapus data, memvalidasi form, dan mengatur navigasi pada layar kecil.