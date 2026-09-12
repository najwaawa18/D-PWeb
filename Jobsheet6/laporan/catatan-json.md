## Data JSON

Pada Jobsheet 6, data anggota dan data buku dipisahkan ke dalam file JSON. Data tersebut digunakan sebagai sumber data yang akan diambil oleh JavaScript menggunakan `fetch()`, kemudian ditampilkan secara dinamis ke dalam tabel HTML.

### File `anggota.json`

File `anggota.json` digunakan untuk menyimpan data anggota perpustakaan dalam bentuk array of object.

```json
[
    { "no_anggota": "A001", "nama": "Siti Aminah", "alamat": "Malang", "no_hp": "0812xxxx" },
    { "no_anggota": "A002", "nama": "Budi Santoso", "alamat": "Batu", "no_hp": "0813xxxx" },
    { "no_anggota": "A003", "nama": "Dewi Lestari", "alamat": "Malang", "no_hp": "0814xxxx" },
    { "no_anggota": "A004", "nama": "Rizky Pratama", "alamat": "Batu", "no_hp": "0815xxxx" },
    { "no_anggota": "A005", "nama": "Putri Amelia", "alamat": "Blitar", "no_hp": "0816xxxx" },
    { "no_anggota": "A006", "nama": "Fajar Ramadhan", "alamat": "Malang", "no_hp": "0817xxxx" },
    { "no_anggota": "A007", "nama": "Nabila Putri", "alamat": "Singosari", "no_hp": "0818xxxx" }
]
```

Setiap objek pada `anggota.json` memiliki beberapa atribut:

- `no_anggota` digunakan untuk menyimpan nomor anggota.
- `nama` digunakan untuk menyimpan nama anggota.
- `alamat` digunakan untuk menyimpan alamat anggota.
- `no_hp` digunakan untuk menyimpan nomor HP anggota.

Data tersebut kemudian diambil oleh `anggota.js` menggunakan `fetch()`:

```javascript
const res = await fetch("../data/anggota.json");
const daftarAnggota = await res.json();
```

Setelah data berhasil diambil, setiap objek anggota diproses menggunakan `forEach()` dan dibuat menjadi baris tabel `<tr>` secara dinamis.

### File `buku.json`

File `buku.json` digunakan untuk menyimpan data buku perpustakaan dalam bentuk array of object.

```json
[
    { "judul": "Laskar Pelangi", "pengarang": "Andrea Hirata", "tahun": 2005, "stok": 4 },
    { "judul": "Bumi Manusia", "pengarang": "Pramoedya Ananta Toer", "tahun": 1980, "stok": 2 },
    { "judul": "Negeri 5 Menara", "pengarang": "Ahmad Fuadi", "tahun": 2009, "stok": 0 },
    { "judul": "Filosofi Teras", "pengarang": "Henry Manampiring", "tahun": 2018, "stok": 5 },
    { "judul": "Ronggeng Dukuh Paruk", "pengarang": "Ahmad Tohari", "tahun": 1982, "stok": 1 },
    { "judul": "Hujan", "pengarang": "Tere Liye", "tahun": 2016, "stok": 6 },
    { "judul": "Perahu Kertas", "pengarang": "Dee Lestari", "tahun": 2009, "stok": 4 },
    { "judul": "Dilan 1990", "pengarang": "Pidi Baiq", "tahun": 2014, "stok": 5 },
    { "judul": "Ayat-Ayat Cinta", "pengarang": "Habiburrahman El Shirazy", "tahun": 2004, "stok": 3 },
    { "judul": "Cantik Itu Luka", "pengarang": "Eka Kurniawan", "tahun": 2002, "stok": 2 }
]
```

Setiap objek pada `buku.json` memiliki beberapa atribut:

- `judul` digunakan untuk menyimpan judul buku.
- `pengarang` digunakan untuk menyimpan nama pengarang.
- `tahun` digunakan untuk menyimpan tahun terbit buku.
- `stok` digunakan untuk menyimpan jumlah stok buku.

Data tersebut kemudian diambil oleh `buku.js` menggunakan:

```javascript
const res = await fetch("../data/buku.json");
const daftarBuku = await res.json();
```

Setelah data berhasil diambil, setiap objek buku diproses menggunakan `forEach()` dan dibuat menjadi baris tabel `<tr>` secara dinamis.

### Hubungan JSON dengan JavaScript

Pada Jobsheet 6, file JSON berfungsi sebagai sumber data untuk halaman daftar buku dan anggota. JavaScript mengambil data tersebut menggunakan `fetch()`, kemudian mengubah respons menjadi data JavaScript menggunakan `res.json()`.

Alur prosesnya adalah:

**File JSON → `fetch()` → `res.json()` → Data Array → `forEach()` → Membuat baris tabel → Ditampilkan ke HTML**

Dengan penggunaan JSON, data tidak perlu lagi ditulis secara langsung pada `<tbody>` seperti pada Jobsheet sebelumnya. Data pada tabel dapat dimuat secara dinamis berdasarkan isi file `buku.json` dan `anggota.json`.