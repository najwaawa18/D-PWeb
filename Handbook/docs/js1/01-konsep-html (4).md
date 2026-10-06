# JS1 — Halaman Daftar Data

## 1. Tujuan
Halaman daftar digunakan untuk menampilkan data SIMPUS-Mini dalam bentuk tabel. Pada Jobsheet 1, data masih ditulis langsung pada HTML sehingga belum mengambil data dari database.

## 2. Struktur Tabel

```html
<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>A001</td>
            <td>Siti Aminah</td>
            <td>Malang</td>
            <td>
                <button type="button">Edit</button>
                <button type="button">Hapus</button>
            </td>
        </tr>
    </tbody>
</table>
```

## 3. Penjelasan

### `<table>`
Wadah utama seluruh tabel.

### `<thead>`
Bagian kepala tabel yang berisi nama kolom.

### `<tr>`
Singkatan dari **table row**, yaitu satu baris.

### `<th>`
Singkatan dari **table header**, yaitu judul kolom.

### `<tbody>`
Bagian isi utama tabel.

### `<td>`
Singkatan dari **table data**, yaitu isi setiap sel.

## 4. Cara Membaca Data

```html
<tr>
    <td>A001</td>
    <td>Siti Aminah</td>
    <td>Malang</td>
</tr>
```

Artinya satu baris mempunyai:

```text
Kolom 1 → A001
Kolom 2 → Siti Aminah
Kolom 3 → Malang
```

Urutan `<td>` mengikuti urutan `<th>`.

## 5. Kolom Aksi

```html
<button type="button">Edit</button>
<button type="button">Hapus</button>
```

Pada JS1 tombol tersebut masih merupakan tampilan antarmuka. Belum ada proses edit atau hapus yang terhubung ke database.

Fungsi tersebut berkembang pada jobsheet berikutnya.

## 6. Pola yang Wajib Diingat

```text
<table>
 ├── <thead>
 │    └── <tr>
 │         └── <th>
 │
 └── <tbody>
      └── <tr>
           └── <td>
```

## 7. Footer

```html
<footer>
    <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 1</p>
</footer>
```

`<footer>` adalah bagian bawah halaman. `&copy;` menghasilkan simbol © dan `&mdash;` menghasilkan tanda —.

## 8. 🧠 Kalau Lupa

**TH = judul kolom**

**TD = isi kolom**

**TR = baris**

**THEAD = kepala tabel**

**TBODY = isi tabel**
