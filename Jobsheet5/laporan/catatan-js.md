## JavaScript Jobsheet 5

Pada Jobsheet 5, SIMPUS-Mini mulai menggunakan **JavaScript** untuk menambahkan interaksi pada halaman website. JavaScript yang dibuat disimpan dalam file `app.js` dan digunakan pada halaman Beranda, Daftar Buku, Daftar Anggota, Tambah Buku, serta Tambah Anggota.

Fitur yang ditambahkan meliputi **menu hamburger, konfirmasi hapus, pencarian tabel secara real-time, pesan error, dan validasi form**.

### 1. Hamburger Menu

Fungsi `initNavToggle()` digunakan untuk membuka dan menutup menu navigasi pada tampilan mobile.

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

Penjelasan:

- `getElementById("nav-toggle-btn")` mengambil tombol hamburger berdasarkan ID yang ada pada HTML.
- `querySelector("header nav")` mengambil elemen navigasi.
- `if (!toggleBtn || !nav) return;` menghentikan fungsi jika tombol atau navigasi tidak ditemukan.
- `addEventListener("click", ...)` menjalankan fungsi ketika tombol hamburger diklik.
- `classList.toggle("nav-open")` menambahkan atau menghapus class `nav-open`.
- Class `nav-open` kemudian digunakan oleh CSS untuk menampilkan atau menyembunyikan menu pada layar mobile.

### 2. Konfirmasi Hapus

Fungsi `initHapusConfirm()` digunakan untuk memberikan konfirmasi sebelum data pada tabel dihapus.

```javascript
function initHapusConfirm() {
    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const row = btn.closest("tr");

            const nama = row
                ? row.querySelector("td")?.textContent
                : "data ini";

            const yakin = confirm(
                'Yakin ingin menghapus "' + nama + '"?'
            );

            if (yakin && row) {
                row.remove();
            }
        });
    });
}
```

Penjelasan:

- `querySelectorAll(".btn-hapus")` mengambil semua tombol **Hapus** pada tabel.
- `forEach()` digunakan agar setiap tombol Hapus memiliki fungsi yang sama.
- `closest("tr")` mencari baris tabel tempat tombol tersebut berada.
- `row.querySelector("td")?.textContent` mengambil isi kolom pertama pada baris sebagai nama atau identitas data yang akan ditampilkan dalam konfirmasi.
- `confirm()` menampilkan pertanyaan konfirmasi kepada pengguna.
- Jika pengguna memilih **OK**, `row.remove()` menghapus baris tersebut dari tampilan tabel.
- Penghapusan pada Jobsheet 5 masih dilakukan pada **sisi front-end**, sehingga belum menghapus data dari database.

### 3. Pencarian Tabel Real-Time

Fungsi `initTableFilter()` digunakan untuk melakukan pencarian pada tabel Daftar Buku dan Daftar Anggota berdasarkan teks yang diketik pengguna.

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

            row.style.display = teks.includes(keyword)
                ? ""
                : "none";
        });
    });
}
```

Penjelasan:

- `getElementById("search-input")` mengambil kolom pencarian dari HTML.
- `querySelector(".table-responsive table")` mengambil tabel yang berada di dalam `.table-responsive`.
- `keyup` digunakan untuk menjalankan pencarian setiap kali pengguna mengetik.
- `toLowerCase()` membuat pencarian tidak membedakan huruf besar dan kecil.
- `querySelectorAll("tbody tr")` mengambil seluruh baris data pada tabel.
- `textContent` mengambil seluruh teks dalam satu baris.
- `includes(keyword)` mengecek apakah teks pada baris mengandung kata yang dicari.
- Jika cocok, baris tetap ditampilkan dengan `display = ""`.
- Jika tidak cocok, baris disembunyikan dengan `display = "none"`.

Dengan demikian, pencarian dapat dilakukan **secara langsung tanpa perlu me-refresh halaman**.

### 4. Menampilkan Pesan Error

Fungsi `tampilkanError()` digunakan untuk membuat dan menampilkan pesan kesalahan pada input form.

```javascript
function tampilkanError(input, pesan) {
    hapusError(input);

    const span = document.createElement("span");

    span.className = "error";
    span.textContent = pesan;

    input.insertAdjacentElement("afterend", span);
}
```

Penjelasan:

- `hapusError(input)` dipanggil terlebih dahulu agar pesan error sebelumnya tidak muncul berulang.
- `createElement("span")` membuat elemen `<span>` baru.
- `className = "error"` memberikan class agar tampilannya dapat diatur menggunakan CSS.
- `textContent = pesan` memasukkan pesan kesalahan ke dalam elemen.
- `insertAdjacentElement("afterend", span)` menempatkan pesan error setelah input yang bermasalah.

### 5. Menghapus Pesan Error

Fungsi `hapusError()` digunakan untuk menghapus pesan error yang sudah ditampilkan.

```javascript
function hapusError(input) {
    const next = input.nextElementSibling;

    if (next && next.classList.contains("error")) {
        next.remove();
    }
}
```

Penjelasan:

- `nextElementSibling` mengambil elemen yang berada tepat setelah input.
- `classList.contains("error")` mengecek apakah elemen tersebut merupakan pesan error.
- Jika benar, `remove()` menghapus pesan error dari halaman.

Fungsi ini digunakan ketika input sudah diperbaiki atau sebelum menampilkan pesan error baru.

### 6. Validasi Form Tambah Buku dan Anggota

Fungsi `initValidasiForm()` digunakan untuk memeriksa data sebelum form Tambah Buku atau Tambah Anggota dikirim.

```javascript
function initValidasiForm() {
    const form = document.getElementById("form-tambah");

    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;
```

Program mengambil form berdasarkan ID `form-tambah`. Jika form tidak ditemukan, fungsi dihentikan.

Variabel `valid` digunakan untuk menentukan apakah seluruh data sudah memenuhi aturan validasi.

#### a. Validasi Judul Buku / Nama Anggota

```javascript
const judul = form.querySelector(
    "[name='judul'], [name='nama']"
);

if (judul && judul.value.trim() === "") {
    tampilkanError(
        judul,
        "Field ini wajib diisi."
    );

    valid = false;
} else if (judul) {
    hapusError(judul);
}
```

Bagian ini digunakan untuk memeriksa:

- `judul` pada form Tambah Buku.
- `nama` pada form Tambah Anggota.

`trim()` digunakan untuk menghilangkan spasi di awal dan akhir input sehingga input yang hanya berisi spasi tetap dianggap kosong.

Jika kosong, program menampilkan pesan **"Field ini wajib diisi."** dan mengubah `valid` menjadi `false`.

#### b. Validasi Pengarang

```javascript
const pengarang = form.querySelector(
    "[name='pengarang']"
);

if (pengarang && pengarang.value.trim() === "") {
    tampilkanError(
        pengarang,
        "Pengarang wajib diisi."
    );

    valid = false;
} else if (pengarang) {
    hapusError(pengarang);
}
```

Bagian ini khusus digunakan pada form Tambah Buku untuk memastikan field **Pengarang** tidak kosong.

#### c. Validasi Tahun

```javascript
const tahun = form.querySelector(
    "[name='tahun']"
);

if (tahun) {
    const nilai = parseInt(
        tahun.value,
        10
    );

    if (
        isNaN(nilai) ||
        nilai < 1900 ||
        nilai > 2026
    ) {
        tampilkanError(
            tahun,
            "Tahun harus di antara 1900-2026."
        );

        valid = false;
    } else {
        hapusError(tahun);
    }
}
```

Bagian ini memeriksa tahun terbit buku.

- `parseInt()` mengubah input menjadi bilangan bulat.
- `isNaN()` memeriksa apakah input bukan angka.
- Tahun harus berada pada rentang **1900 sampai 2026**.
- Jika tidak sesuai, pesan error ditampilkan dan `valid` menjadi `false`.

#### d. Validasi Stok

```javascript
const stok = form.querySelector(
    "[name='stok']"
);

if (stok) {
    const nilai = parseInt(
        stok.value,
        10
    );

    if (
        isNaN(nilai) ||
        nilai < 0
    ) {
        tampilkanError(
            stok,
            "Stok tidak boleh negatif."
        );

        valid = false;
    } else {
        hapusError(stok);
    }
}
```

Bagian ini memeriksa nilai **Stok** pada form Tambah Buku.

Stok harus berupa angka dan tidak boleh kurang dari `0`.

#### e. Mencegah Form Dikirim Jika Tidak Valid

```javascript
if (!valid) {
    e.preventDefault();
}
```

Jika terdapat kesalahan pada form, `valid` bernilai `false`.

`preventDefault()` digunakan untuk **mencegah proses submit form**, sehingga pengguna harus memperbaiki data terlebih dahulu.

### 7. Menjalankan Semua Fungsi

Pada bagian terakhir, seluruh fungsi JavaScript dijalankan setelah halaman selesai dimuat.

```javascript
document.addEventListener(
    "DOMContentLoaded",
    function () {
        initNavToggle();
        initHapusConfirm();
        initTableFilter();
        initValidasiForm();
    }
);
```

`DOMContentLoaded` memastikan kode JavaScript dijalankan setelah struktur HTML selesai dimuat.

Kemudian empat fungsi utama dipanggil:

- `initNavToggle()` → menjalankan menu hamburger.
- `initHapusConfirm()` → menjalankan konfirmasi dan penghapusan baris.
- `initTableFilter()` → menjalankan pencarian tabel.
- `initValidasiForm()` → menjalankan validasi form.

### Kesimpulan

JavaScript pada Jobsheet 5 menambahkan interaksi yang sebelumnya belum tersedia pada Jobsheet 4. Fitur yang ditambahkan adalah:

1. **Menu hamburger** untuk navigasi pada layar mobile.
2. **Konfirmasi Hapus** sebelum baris data dihapus.
3. **Pencarian real-time** pada tabel buku dan anggota.
4. **Pesan error** pada input yang tidak sesuai.
5. **Validasi form** untuk data buku dan anggota.
6. **Pencegahan submit** apabila data form belum valid.

Dengan JavaScript tersebut, SIMPUS-Mini menjadi lebih **interaktif** karena pengguna tidak hanya melihat halaman, tetapi juga dapat melakukan pencarian, menghapus tampilan data, membuka menu mobile, dan mendapatkan validasi saat mengisi form.