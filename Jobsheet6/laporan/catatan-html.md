## Perubahan HTML dari Jobsheet 5 ke Jobsheet 6

Pada Jobsheet 6, struktur dasar HTML masih menggunakan halaman yang sama seperti Jobsheet 5. Perubahan utama dilakukan untuk mendukung **pengambilan data dari file JSON secara dinamis** menggunakan JavaScript.

### 1. Penambahan Loading Indicator

Pada halaman **Daftar Buku** dan **Daftar Anggota**, ditambahkan elemen `loading-indicator`.

```html
<p id="loading-indicator" style="display:none;">Memuat data...</p>
```

Elemen ini digunakan untuk menampilkan informasi kepada pengguna ketika data sedang dimuat oleh JavaScript.

- `id="loading-indicator"` digunakan agar elemen dapat diakses melalui JavaScript.
- `display:none` membuat pesan tidak ditampilkan secara default.
- JavaScript dapat mengubah tampilannya ketika proses pengambilan data sedang berlangsung.

### 2. Data Tabel Tidak Lagi Ditulis Langsung di HTML

Pada Jobsheet 5, isi tabel ditulis langsung dalam HTML. Pada Jobsheet 6, bagian `<tbody>` dikosongkan karena data akan diisi secara dinamis menggunakan JavaScript.

Pada halaman **Daftar Buku**:

```html
<tbody>
    <!-- Baris diisi dinamis oleh assets/js/buku.js via fetch('../data/buku.json') -->
</tbody>
```

Sedangkan pada halaman **Daftar Anggota**:

```html
<tbody>
    <!-- Baris diisi dinamis oleh assets/js/anggota.js via fetch('../data/anggota.json') -->
</tbody>
```

Perubahan ini membuat data tidak perlu ditulis satu per satu di dalam HTML. JavaScript akan mengambil data dari file JSON kemudian membuat baris tabel berdasarkan data tersebut.

### 3. Penambahan JavaScript `buku.js`

Pada halaman `buku/list.html`, ditambahkan pemanggilan file JavaScript khusus untuk mengelola data buku.

```html
<script src="../assets/js/buku.js"></script>
```

File `buku.js` digunakan untuk mengelola data pada halaman Daftar Buku, termasuk mengambil data dari file `buku.json` dan menampilkan data tersebut ke dalam tabel.

### 4. Penambahan JavaScript `anggota.js`

Pada halaman `anggota/list.html`, ditambahkan file JavaScript khusus untuk mengelola data anggota.

```html
<script src="../assets/js/anggota.js"></script>
```

File `anggota.js` digunakan untuk mengambil data dari file `anggota.json` dan menampilkannya ke dalam tabel Daftar Anggota.

### 5. `app.js` Tetap Digunakan

Selain JavaScript khusus untuk masing-masing data, halaman Daftar Buku dan Daftar Anggota tetap menggunakan `app.js`.

```html
<script src="../assets/js/app.js"></script>
<script src="../assets/js/buku.js"></script>
```

atau:

```html
<script src="../assets/js/app.js"></script>
<script src="../assets/js/anggota.js"></script>
```

`app.js` tetap menangani fungsi umum seperti **menu hamburger, pencarian, konfirmasi hapus, dan validasi**, sedangkan `buku.js` dan `anggota.js` menangani data dari JSON pada halaman masing-masing.

### 6. Penambahan `required` pada Form

Pada Jobsheet 6, beberapa field form yang sebelumnya tidak menggunakan `required` kembali diberikan atribut tersebut.

Pada form **Tambah Anggota**:

```html
<input type="text" id="nama" name="nama" required>
<input type="text" id="no_anggota" name="no_anggota" required>
```

Sedangkan pada form **Tambah Buku**:

```html
<input type="text" id="judul" name="judul" required>
<input type="text" id="pengarang" name="pengarang" required>
<input type="number" id="tahun" name="tahun" min="1900" max="2026" required>
<input type="number" id="stok" name="stok" min="0" required>
```

Atribut `required` digunakan untuk memastikan field tertentu tidak boleh kosong sebelum form dikirim.

### 7. Footer Disesuaikan dengan Jobsheet 6

Pada seluruh halaman, teks footer yang sebelumnya menunjukkan Jobsheet 5 diubah menjadi Jobsheet 6.

```html
<footer>
    <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 6</p>
</footer>
```

Perubahan ini hanya menyesuaikan identitas halaman dengan jobsheet yang sedang dikerjakan.

### Kesimpulan

Perubahan HTML pada Jobsheet 6 berfokus pada persiapan halaman agar dapat menggunakan **data dinamis dari JSON**. Perubahan utamanya adalah:

- Menambahkan `loading-indicator` pada halaman daftar.
- Mengosongkan `<tbody>` karena data akan dibuat oleh JavaScript.
- Menambahkan `buku.js` untuk mengelola data buku.
- Menambahkan `anggota.js` untuk mengelola data anggota.
- Tetap menggunakan `app.js` untuk fungsi umum.
- Menambahkan kembali atribut `required` pada beberapa field form.
- Mengubah keterangan footer menjadi **Jobsheet 6**.

Dengan perubahan tersebut, data buku dan anggota tidak lagi bergantung pada isi tabel yang ditulis secara manual di HTML, tetapi dapat dimuat secara dinamis dari file JSON.