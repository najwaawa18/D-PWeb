## Implementasi JavaScript pada `app.js`

Pada Jobsheet 8, file `app.js` tetap digunakan untuk menangani interaksi pada halaman SIMPUS-Mini. JavaScript mengatur menu hamburger, konfirmasi penghapusan data, pencarian tabel, dan validasi form.

### 1. Hamburger Menu

```javascript
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}
```

Fungsi `initNavToggle()` digunakan untuk mengatur tombol hamburger pada tampilan mobile.

Program mengambil tombol dengan ID `nav-toggle-btn` dan elemen navigasi pada `header`. Jika salah satu elemen tidak ditemukan, fungsi dihentikan menggunakan `return`.

Ketika tombol diklik, program menjalankan:

```javascript
nav.classList.toggle("nav-open");
```

Perintah tersebut menambahkan class `nav-open` jika class belum ada dan menghapusnya jika sudah ada. Class tersebut kemudian digunakan oleh CSS untuk menampilkan atau menyembunyikan menu navigasi pada perangkat mobile.

---

### 2. Konfirmasi Penghapusan Data

```javascript
function initHapusConfirm() {
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-hapus");
        if (!btn) return;

        const row = btn.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
        if (yakin && row) {
            row.remove();
        }
    });
}
```

Fungsi `initHapusConfirm()` digunakan untuk memberikan konfirmasi sebelum data dihapus dari tampilan.

Program menggunakan **event delegation** pada `document`. Cara ini memungkinkan event klik tetap dapat ditemukan pada tombol `.btn-hapus` yang berada di dalam tabel.

Ketika tombol Hapus diklik, program mencari baris tabel menggunakan:

```javascript
const row = btn.closest("tr");
```

Kemudian isi kolom pertama diambil sebagai identitas data yang akan dihapus.

```javascript
const nama = row ? row.querySelector("td")?.textContent : "data ini";
```

Setelah itu, `confirm()` menampilkan pertanyaan kepada pengguna. Jika pengguna memilih OK, baris tabel dihapus menggunakan:

```javascript
row.remove();
```

Pada kode ini, proses hapus masih merupakan **proses front-end**, sehingga hanya menghilangkan baris dari tampilan. Kode tersebut belum menjalankan query `DELETE` ke database PostgreSQL.

---

### 3. Filter atau Pencarian Tabel

```javascript
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}
```

Fungsi `initTableFilter()` digunakan untuk melakukan pencarian data secara langsung pada tabel.

Program mengambil input pencarian dan tabel yang terdapat pada halaman. Ketika pengguna mengetik, event `keyup` dijalankan.

Nilai pencarian diubah menjadi huruf kecil menggunakan:

```javascript
const keyword = input.value.toLowerCase();
```

Kemudian setiap baris tabel diperiksa. Jika isi baris mengandung kata kunci, baris tetap ditampilkan. Jika tidak ditemukan, baris disembunyikan.

```javascript
row.style.display = teks.includes(keyword) ? "" : "none";
```

Pencarian ini dilakukan pada data yang **sudah ditampilkan di halaman**, bukan dengan menjalankan query pencarian baru ke database.

---

### 4. Menampilkan dan Menghapus Pesan Error

```javascript
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}
```

Fungsi `tampilkanError()` digunakan untuk menampilkan pesan kesalahan pada input form.

Program membuat elemen `<span>` baru menggunakan:

```javascript
document.createElement("span");
```

Kemudian elemen tersebut diberi class `error` dan diisi dengan pesan yang diberikan.

Sebelum membuat pesan baru, fungsi `hapusError()` dipanggil agar pesan error sebelumnya tidak menumpuk.

Pesan tersebut kemudian ditempatkan setelah input menggunakan:

```javascript
input.insertAdjacentElement("afterend", span);
```

---

### 5. Validasi Form Tambah

```javascript
function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;
```

Fungsi `initValidasiForm()` digunakan untuk melakukan **validasi client-side** sebelum form dikirim ke server.

Program mencari form dengan ID `form-tambah`. Ketika form dikirim, variabel `valid` digunakan untuk menentukan apakah seluruh data telah memenuhi ketentuan.

#### Validasi Judul atau Nama

```javascript
const judul = form.querySelector("[name='judul'], [name='nama']");

if (judul && judul.value.trim() === "") {
    tampilkanError(judul, "Field ini wajib diisi.");
    valid = false;
}
```

Kode tersebut digunakan untuk memeriksa field `judul` pada form buku atau `nama` pada form anggota. Jika field kosong, pesan error ditampilkan dan `valid` diubah menjadi `false`.

#### Validasi Pengarang

```javascript
const pengarang = form.querySelector("[name='pengarang']");

if (pengarang && pengarang.value.trim() === "") {
    tampilkanError(pengarang, "Pengarang wajib diisi.");
    valid = false;
}
```

Pada form buku, field pengarang diperiksa agar tidak kosong.

#### Validasi Tahun

```javascript
const tahun = form.querySelector("[name='tahun']");

if (tahun) {
    const nilai = parseInt(tahun.value, 10);

    if (isNaN(nilai) || nilai < 1900 || nilai > 2026) {
        tampilkanError(tahun, "Tahun harus di antara 1900-2026.");
        valid = false;
    }
}
```

Field tahun diperiksa menggunakan `parseInt()` untuk mengubah nilai menjadi bilangan bulat. Nilai dianggap tidak valid apabila bukan angka atau berada di luar rentang **1900–2026**.

#### Validasi Stok

```javascript
const stok = form.querySelector("[name='stok']");

if (stok) {
    const nilai = parseInt(stok.value, 10);

    if (isNaN(nilai) || nilai < 0) {
        tampilkanError(stok, "Stok tidak boleh negatif.");
        valid = false;
    }
}
```

Field stok harus berupa angka dan tidak boleh memiliki nilai negatif.

Jika terdapat kesalahan:

```javascript
if (!valid) {
    e.preventDefault();
}
```

`e.preventDefault()` digunakan untuk mencegah form dikirim ke server sehingga pengguna dapat memperbaiki data terlebih dahulu.

---

### 6. Menjalankan Fungsi Setelah Halaman Dimuat

```javascript
document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});
```

Bagian ini memastikan fungsi JavaScript dijalankan setelah struktur HTML selesai dimuat.

Empat fungsi yang dijalankan adalah:

1. `initNavToggle()` → mengatur hamburger menu.
2. `initHapusConfirm()` → memberikan konfirmasi sebelum menghapus data dari tampilan.
3. `initTableFilter()` → mengatur fitur pencarian tabel.
4. `initValidasiForm()` → melakukan validasi form sebelum dikirim.

### Hubungan dengan Database pada Jobsheet 8

JavaScript pada `app.js` masih menangani sisi **client-side**, sedangkan proses penyimpanan data ke PostgreSQL dilakukan oleh PHP.

Alurnya pada form tambah adalah:

```text
Form HTML
    ↓
Validasi JavaScript
    ↓
POST ke proses_tambah.php
    ↓
Validasi server-side PHP
    ↓
prepare() dan execute()
    ↓
Database PostgreSQL
```

Dengan demikian, JavaScript membantu memberikan interaksi dan validasi awal kepada pengguna, sedangkan PHP bertanggung jawab untuk memproses dan menyimpan data ke database.

### Kesimpulan

File `app.js` pada Jobsheet 8 tetap berfungsi sebagai pengatur interaksi pada sisi pengguna. Fitur yang ditangani meliputi **hamburger menu, konfirmasi hapus, pencarian tabel, dan validasi form**.

Meskipun aplikasi pada Jobsheet 8 sudah menggunakan database PostgreSQL, JavaScript tidak langsung melakukan penyimpanan ke database. Proses tersebut tetap dilakukan oleh PHP melalui file `proses_tambah.php`.