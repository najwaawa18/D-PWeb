## JavaScript Jobsheet 6

Pada Jobsheet 6, JavaScript dikembangkan dari Jobsheet 5 dengan menambahkan **pengambilan data secara asinkron dari file JSON**. Data buku dan anggota tidak lagi ditulis langsung pada HTML, tetapi dimuat menggunakan `fetch()` kemudian ditampilkan ke dalam tabel secara dinamis.

Selain itu, fungsi konfirmasi hapus pada `app.js` disesuaikan menggunakan **event delegation** agar dapat bekerja pada baris tabel yang dibuat secara dinamis.

### 1. `app.js`

File `app.js` masih digunakan untuk fungsi umum pada website, seperti menu hamburger, konfirmasi hapus, pencarian tabel, dan validasi form.

#### a. Penyesuaian Konfirmasi Hapus dengan Event Delegation

Pada Jobsheet 6, fungsi `initHapusConfirm()` diubah karena tombol **Hapus** pada tabel sekarang dibuat secara dinamis oleh `buku.js` dan `anggota.js`.

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

Pada Jobsheet 5, tombol `.btn-hapus` dicari langsung ketika halaman dimuat. Cara tersebut tidak dapat digunakan dengan baik pada JS6 karena tombol Hapus belum ada ketika `DOMContentLoaded` dijalankan.

Pada JS6 digunakan **event delegation** dengan memasang event `click` pada `document`.

- `document.addEventListener("click", ...)` menangkap klik yang terjadi pada halaman.
- `e.target.closest(".btn-hapus")` mencari apakah elemen yang diklik atau induknya merupakan tombol Hapus.
- Jika bukan tombol Hapus, fungsi dihentikan dengan `return`.
- Jika merupakan tombol Hapus, program mencari baris tabel menggunakan `closest("tr")`.
- Setelah pengguna melakukan konfirmasi, baris tersebut dapat dihapus menggunakan `row.remove()`.

Dengan cara ini, tombol Hapus yang dibuat **setelah data JSON berhasil dimuat** tetap dapat berfungsi.

#### b. Fungsi Lain Tetap Digunakan

Fungsi berikut masih digunakan seperti pada Jobsheet 5:

```javascript
initNavToggle();
initTableFilter();
initValidasiForm();
```

Fungsi tersebut tetap menangani:

- `initNavToggle()` → menu hamburger.
- `initTableFilter()` → pencarian tabel.
- `initValidasiForm()` → validasi form Tambah Buku dan Tambah Anggota.

---

## 2. `buku.js`

Pada Jobsheet 6 ditambahkan file `buku.js` untuk mengambil dan menampilkan data buku dari file JSON.

```javascript
async function muatDaftarBuku() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;
```

Fungsi `muatDaftarBuku()` menggunakan `async` karena di dalamnya terdapat proses pengambilan data secara asinkron.

- `tbody` digunakan untuk menentukan bagian tabel yang akan diisi data.
- `loading` digunakan untuk mengambil elemen indikator loading.
- Jika `tbody` tidak ditemukan, fungsi dihentikan.

### 2.1 Menampilkan Loading Indicator

```javascript
loading.style.display = "block";
tbody.innerHTML = "";
```

Saat proses pengambilan data dimulai:

- `loading.style.display = "block"` menampilkan tulisan **"Memuat data..."**.
- `tbody.innerHTML = ""` mengosongkan isi tabel sebelum data baru dimasukkan.

### 2.2 Simulasi Delay

```javascript
await new Promise((resolve) => setTimeout(resolve, 600));
```

Kode tersebut memberikan jeda selama **600 milidetik** untuk mensimulasikan waktu yang dibutuhkan dalam proses pengambilan data.

Tujuannya agar **loading indicator** dapat terlihat ketika data sedang dimuat.

### 2.3 Mengambil Data dari JSON

```javascript
const res = await fetch("../data/buku.json");

if (!res.ok) {
    throw new Error("Gagal mengambil data (status " + res.status + ")");
}

const daftarBuku = await res.json();
```

Bagian ini digunakan untuk mengambil data dari file `buku.json`.

- `fetch("../data/buku.json")` meminta data dari file JSON.
- `await` menunggu sampai proses pengambilan data selesai.
- `res.ok` memeriksa apakah proses pengambilan data berhasil.
- Jika gagal, `throw new Error()` menghasilkan pesan kesalahan.
- `res.json()` mengubah data JSON menjadi data JavaScript yang dapat diproses.

### 2.4 Menampilkan Data Buku ke Tabel

```javascript
daftarBuku.forEach(function (buku) {
    const tr = document.createElement("tr");

    tr.innerHTML =
        "<td>" + buku.judul + "</td>" +
        "<td>" + buku.pengarang + "</td>" +
        "<td>" + buku.tahun + "</td>" +
        "<td>" + buku.stok + "</td>" +
        "<td>" +
        "<button type=\"button\">Edit</button> " +
        "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
        "</td>";

    tbody.appendChild(tr);
});
```

Setiap data buku yang terdapat dalam `daftarBuku` diproses menggunakan `forEach()`.

- `createElement("tr")` membuat baris tabel baru.
- `innerHTML` digunakan untuk membuat isi kolom berdasarkan data buku.
- Data yang ditampilkan adalah **judul, pengarang, tahun, stok, dan tombol aksi**.
- `appendChild(tr)` menambahkan baris yang telah dibuat ke dalam `<tbody>`.

Dengan demikian, isi tabel Daftar Buku yang sebelumnya ditulis secara manual pada HTML sekarang dibuat **secara dinamis berdasarkan data dari JSON**.

### 2.5 Menangani Kesalahan Pengambilan Data

```javascript
catch (err) {
    tbody.innerHTML =
        "<tr><td colspan=\"5\">Gagal memuat data: " + err.message + "</td></tr>";
}
```

Jika terjadi kesalahan saat mengambil atau membaca data JSON, program menampilkan pesan kesalahan pada tabel.

`colspan="5"` digunakan karena tabel Daftar Buku memiliki lima kolom.

### 2.6 Menyembunyikan Loading Setelah Proses Selesai

```javascript
finally {
    loading.style.display = "none";
}
```

`finally` dijalankan setelah proses selesai, baik berhasil maupun mengalami kesalahan.

Loading indicator kemudian disembunyikan kembali.

### 2.7 Menjalankan Fungsi Setelah HTML Dimuat

```javascript
document.addEventListener("DOMContentLoaded", muatDaftarBuku);
```

Fungsi `muatDaftarBuku()` dijalankan setelah struktur HTML selesai dimuat.

---

## 3. `anggota.js`

File `anggota.js` memiliki konsep yang sama dengan `buku.js`, tetapi digunakan khusus untuk mengambil dan menampilkan data anggota.

```javascript
async function muatDaftarAnggota() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;
```

Fungsi mengambil elemen `<tbody>` dan loading indicator dari halaman Daftar Anggota.

### 3.1 Mengambil Data Anggota

```javascript
const res = await fetch("../data/anggota.json");

if (!res.ok) {
    throw new Error("Gagal mengambil data (status " + res.status + ")");
}

const daftarAnggota = await res.json();
```

Data anggota diambil dari file:

```text
../data/anggota.json
```

Kemudian data JSON diubah menjadi data JavaScript menggunakan `res.json()`.

### 3.2 Menampilkan Data Anggota ke Tabel

```javascript
daftarAnggota.forEach(function (anggota) {
    const tr = document.createElement("tr");

    tr.innerHTML =
        "<td>" + anggota.no_anggota + "</td>" +
        "<td>" + anggota.nama + "</td>" +
        "<td>" + anggota.alamat + "</td>" +
        "<td>" + anggota.no_hp + "</td>" +
        "<td>" +
        "<button type=\"button\">Edit</button> " +
        "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
        "</td>";

    tbody.appendChild(tr);
});
```

Setiap data anggota dibuat menjadi satu baris tabel.

Data yang ditampilkan meliputi:

- Nomor anggota.
- Nama.
- Alamat.
- Nomor HP.
- Tombol **Edit** dan **Hapus**.

Baris tersebut kemudian ditambahkan ke dalam `<tbody>`.

### 3.3 Menangani Kesalahan

```javascript
catch (err) {
    tbody.innerHTML =
        "<tr><td colspan=\"5\">Gagal memuat data: " + err.message + "</td></tr>";
}
```

Jika data anggota gagal dimuat, pesan kesalahan ditampilkan pada tabel.

Karena tabel anggota memiliki lima kolom, digunakan `colspan="5"`.

### 3.4 Loading Indicator

Sama seperti `buku.js`, `anggota.js` juga menampilkan loading ketika data sedang diambil.

```javascript
loading.style.display = "block";
tbody.innerHTML = "";
```

Setelah proses selesai:

```javascript
finally {
    loading.style.display = "none";
}
```

Dengan demikian, pengguna dapat mengetahui bahwa data sedang diproses.

### 3.5 Menjalankan Fungsi

```javascript
document.addEventListener("DOMContentLoaded", muatDaftarAnggota);
```

Fungsi `muatDaftarAnggota()` dijalankan setelah HTML selesai dimuat.

---

## 4. Perbedaan `buku.js` dan `anggota.js`

Kedua file memiliki mekanisme yang hampir sama. Perbedaannya terletak pada sumber data dan field yang ditampilkan.

| File | Sumber Data | Data yang Ditampilkan |
|---|---|---|
| `buku.js` | `data/buku.json` | Judul, pengarang, tahun, stok |
| `anggota.js` | `data/anggota.json` | No. Anggota, nama, alamat, no. HP |

Keduanya sama-sama menggunakan `fetch()`, `async/await`, `forEach()`, `try...catch...finally`, serta membuat baris tabel menggunakan JavaScript.

## Kesimpulan

Pada Jobsheet 6, JavaScript dikembangkan agar data buku dan anggota dapat **dimuat secara dinamis dari file JSON**.

Perubahan utama dari Jobsheet 5 adalah:

1. Ditambahkan `buku.js` untuk mengambil data dari `buku.json`.
2. Ditambahkan `anggota.js` untuk mengambil data dari `anggota.json`.
3. Data tabel dibuat secara dinamis menggunakan `createElement()` dan `innerHTML`.
4. Ditambahkan `fetch()` dan `async/await` untuk mengambil data secara asinkron.
5. Ditambahkan **loading indicator** saat data sedang dimuat.
6. Ditambahkan `try...catch...finally` untuk menangani proses berhasil maupun gagal.
7. Fungsi konfirmasi hapus pada `app.js` diubah menjadi **event delegation** agar tombol Hapus yang dibuat secara dinamis tetap dapat digunakan.
8. `app.js` tetap menangani fungsi umum seperti menu hamburger, pencarian, dan validasi form.

Dengan perubahan tersebut, SIMPUS-Mini mulai menggunakan konsep **data eksternal dan pemrosesan data secara dinamis**, sehingga isi tabel tidak lagi bergantung pada data yang ditulis langsung di dalam HTML.