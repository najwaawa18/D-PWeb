## Implementasi JavaScript pada `app.js`

File `app.js` digunakan untuk menangani beberapa interaksi pada halaman SIMPUS-Mini, seperti menu hamburger, konfirmasi penghapusan data, pencarian tabel, dan validasi form. JavaScript dijalankan setelah seluruh elemen halaman selesai dimuat melalui event `DOMContentLoaded`.

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

Fungsi `initNavToggle()` digunakan untuk mengatur tombol hamburger pada tampilan perangkat dengan ukuran layar kecil. Program mencari tombol dengan ID `nav-toggle-btn` dan elemen navigasi pada bagian `header`.

Ketika tombol hamburger diklik, `classList.toggle("nav-open")` akan menambahkan atau menghapus class `nav-open`. Class tersebut kemudian digunakan oleh CSS untuk menampilkan atau menyembunyikan menu navigasi.

Dengan demikian, menu navigasi dapat dibuka dan ditutup tanpa menggunakan checkbox seperti mekanisme sebelumnya.

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

Fungsi `initHapusConfirm()` digunakan untuk memberikan konfirmasi sebelum data pada tabel dihapus. Program mencari tombol yang memiliki class `.btn-hapus` menggunakan **event delegation** pada `document`.

Ketika tombol Hapus diklik, program mengambil baris tabel (`tr`) tempat tombol tersebut berada, kemudian mengambil isi kolom pertama sebagai nama atau identitas data yang akan dihapus.

Selanjutnya, fungsi `confirm()` menampilkan pertanyaan kepada pengguna. Jika pengguna memilih **OK**, baris tersebut akan dihapus dari tampilan menggunakan `row.remove()`.

Pada implementasi ini, proses hapus masih bersifat **front-end**, sehingga penghapusan hanya menghilangkan baris dari tampilan dan belum menghapus data pada server atau penyimpanan PHP.

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

Fungsi `initTableFilter()` digunakan untuk membuat fitur pencarian data pada tabel. Program mengambil input dengan ID `search-input` dan tabel yang berada di dalam `.table-responsive`.

Setiap kali pengguna mengetik pada kolom pencarian, nilai input diubah menjadi huruf kecil menggunakan `toLowerCase()`. Program kemudian memeriksa setiap baris tabel menggunakan `includes()`.

Jika isi baris sesuai dengan kata kunci pencarian, baris tetap ditampilkan. Jika tidak sesuai, baris disembunyikan dengan mengubah `style.display` menjadi `"none"`.

Fitur ini membuat pencarian data dapat dilakukan secara langsung tanpa perlu memuat ulang halaman.

---

### 4. Menampilkan Pesan Error pada Form

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

Fungsi `tampilkanError()` digunakan untuk menampilkan pesan kesalahan pada input yang tidak memenuhi validasi. Program membuat elemen `<span>` baru, memberikan class `.error`, kemudian menempatkan pesan tersebut setelah input yang bermasalah.

Sebelum menampilkan pesan baru, fungsi `hapusError()` dipanggil untuk menghapus pesan error sebelumnya agar tidak terjadi penumpukan pesan.

---

### 5. Validasi Form

```javascript
function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        const judul = form.querySelector("[name='judul'], [name='nama']");
        if (judul && judul.value.trim() === "") {
            tampilkanError(judul, "Field ini wajib diisi.");
            valid = false;
        } else if (judul) {
            hapusError(judul);
        }

        const pengarang = form.querySelector("[name='pengarang']");
        if (pengarang && pengarang.value.trim() === "") {
            tampilkanError(pengarang, "Pengarang wajib diisi.");
            valid = false;
        } else if (pengarang) {
            hapusError(pengarang);
        }

        const tahun = form.querySelector("[name='tahun']");
        if (tahun) {
            const nilai = parseInt(tahun.value, 10);
            if (isNaN(nilai) || nilai < 1900 || nilai > 2026) {
                tampilkanError(tahun, "Tahun harus di antara 1900-2026.");
                valid = false;
            } else {
                hapusError(tahun);
            }
        }

        const stok = form.querySelector("[name='stok']");
        if (stok) {
            const nilai = parseInt(stok.value, 10);
            if (isNaN(nilai) || nilai < 0) {
                tampilkanError(stok, "Stok tidak boleh negatif.");
                valid = false;
            } else {
                hapusError(stok);
            }
        }

        if (!valid) {
            e.preventDefault();
        }
    });
}
```

Fungsi `initValidasiForm()` digunakan untuk melakukan **validasi client-side** sebelum data form dikirim ke server. Validasi dilakukan ketika pengguna menekan tombol **Simpan**.

Beberapa data yang diperiksa adalah:

- Nama atau judul tidak boleh kosong.
- Pengarang wajib diisi pada form buku.
- Tahun harus berupa angka dan berada pada rentang **1900–2026**.
- Stok harus berupa angka dan tidak boleh bernilai negatif.

Variabel `valid` digunakan untuk menentukan apakah seluruh data telah memenuhi ketentuan. Jika ditemukan kesalahan, program menampilkan pesan menggunakan `tampilkanError()` dan mengubah nilai `valid` menjadi `false`.

Jika `valid` bernilai `false`, `e.preventDefault()` digunakan untuk mencegah form dikirim ke server sehingga pengguna dapat memperbaiki data terlebih dahulu.

---

### 6. Menjalankan Seluruh Fungsi Setelah Halaman Dimuat

```javascript
document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});
```

Bagian ini memastikan seluruh fungsi JavaScript dijalankan setelah struktur HTML selesai dimuat oleh browser.

Ketika event `DOMContentLoaded` terjadi, program menjalankan empat fungsi utama, yaitu:

1. `initNavToggle()` untuk menu hamburger.
2. `initHapusConfirm()` untuk konfirmasi penghapusan.
3. `initTableFilter()` untuk pencarian tabel.
4. `initValidasiForm()` untuk validasi form.

Dengan cara ini, JavaScript dapat bekerja setelah elemen-elemen HTML yang dibutuhkan tersedia.

### Kesimpulan

File `app.js` berfungsi sebagai pengatur interaksi pada aplikasi SIMPUS-Mini. Fitur yang ditangani meliputi **menu hamburger, konfirmasi hapus, pencarian tabel, dan validasi form**.

Pada Jobsheet 7, JavaScript client-side ini tetap digunakan untuk membantu interaksi pengguna. Namun, validasi pada JavaScript bukan satu-satunya pengamanan karena data yang dikirim melalui form tetap diperiksa kembali menggunakan **validasi server-side pada PHP** di file `proses_tambah.php`.