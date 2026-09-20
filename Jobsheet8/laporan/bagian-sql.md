## Implementasi SQL Database pada Jobsheet 8

Pada Jobsheet 8, SIMPUS-Mini mulai menggunakan **database PostgreSQL** untuk menyimpan data buku dan anggota. Sebelumnya, data pada Jobsheet 7 masih disimpan sementara menggunakan session PHP. Pada Jobsheet 8, data disimpan secara permanen di dalam database.

File SQL yang digunakan adalah `sql/01_buku_anggota.sql`.

### 1. Membuat Tabel `buku`

```sql
CREATE TABLE IF NOT EXISTS buku (
    id SERIAL PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    pengarang VARCHAR(255) NOT NULL,
    tahun INTEGER NOT NULL,
    isbn VARCHAR(50),
    stok INTEGER NOT NULL DEFAULT 0,
    kategori VARCHAR(50)
);
```

Perintah tersebut digunakan untuk membuat tabel `buku` sebagai tempat penyimpanan data buku.

Struktur tabel terdiri dari:

- `id` → nomor identitas setiap data buku. Menggunakan `SERIAL` sehingga nilainya dapat bertambah secara otomatis dan menjadi `PRIMARY KEY`.
- `judul` → menyimpan judul buku dengan panjang maksimal 255 karakter dan wajib diisi.
- `pengarang` → menyimpan nama pengarang dan wajib diisi.
- `tahun` → menyimpan tahun terbit dalam bentuk bilangan bulat.
- `isbn` → menyimpan nomor ISBN buku dan bersifat opsional.
- `stok` → menyimpan jumlah stok buku dalam bentuk bilangan bulat. Nilai awalnya adalah `0`.
- `kategori` → menyimpan kategori buku dengan panjang maksimal 50 karakter.

`NOT NULL` digunakan pada beberapa kolom untuk memastikan data penting tidak boleh kosong.

---

### 2. Membuat Tabel `anggota`

```sql
CREATE TABLE IF NOT EXISTS anggota (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    no_anggota VARCHAR(50) NOT NULL UNIQUE,
    alamat VARCHAR(255),
    no_hp VARCHAR(30)
);
```

Perintah tersebut digunakan untuk membuat tabel `anggota` sebagai tempat penyimpanan data anggota perpustakaan.

Struktur tabel terdiri dari:

- `id` → nomor identitas anggota yang dibuat secara otomatis dan menjadi `PRIMARY KEY`.
- `nama` → menyimpan nama anggota dan wajib diisi.
- `no_anggota` → menyimpan nomor anggota dan wajib diisi.
- `alamat` → menyimpan alamat anggota dan bersifat opsional.
- `no_hp` → menyimpan nomor telepon anggota dan bersifat opsional.

Pada kolom `no_anggota` terdapat `UNIQUE`, sehingga setiap nomor anggota harus berbeda dan tidak boleh digunakan oleh lebih dari satu anggota.

---

### 3. `PRIMARY KEY`

Pada kedua tabel terdapat kolom:

```sql
id SERIAL PRIMARY KEY
```

`PRIMARY KEY` digunakan sebagai identitas unik untuk setiap baris data. Sementara itu, `SERIAL` membuat nilai `id` bertambah secara otomatis ketika data baru dimasukkan.

---

### 4. `NOT NULL`

Beberapa kolom menggunakan `NOT NULL`, contohnya:

```sql
judul VARCHAR(255) NOT NULL
```

Artinya, kolom tersebut wajib memiliki nilai dan tidak boleh kosong ketika data dimasukkan ke database.

Pada tabel `buku`, kolom yang menggunakan `NOT NULL` adalah `judul`, `pengarang`, `tahun`, dan `stok`.

Pada tabel `anggota`, kolom yang menggunakan `NOT NULL` adalah `nama` dan `no_anggota`.

---

### 5. `UNIQUE`

Pada tabel `anggota`, kolom `no_anggota` menggunakan:

```sql
no_anggota VARCHAR(50) NOT NULL UNIQUE
```

`UNIQUE` digunakan agar tidak terdapat dua anggota dengan nomor anggota yang sama.

---

### 6. `DEFAULT`

Pada kolom `stok` terdapat:

```sql
stok INTEGER NOT NULL DEFAULT 0
```

`DEFAULT 0` berarti apabila nilai stok tidak diberikan ketika data dimasukkan, PostgreSQL akan memberikan nilai `0` secara otomatis.

---

### 7. `IF NOT EXISTS`

Kedua tabel dibuat menggunakan:

```sql
CREATE TABLE IF NOT EXISTS
```

Perintah ini membuat tabel hanya jika tabel tersebut belum tersedia. Jika tabel sudah ada, PostgreSQL tidak membuat tabel baru dengan nama yang sama.

---

### 8. Menjalankan File SQL

File SQL dapat dijalankan setelah database `simpus_mini` dibuat. Contohnya:

```bash
createdb simpus_mini
psql -d simpus_mini -f sql/01_buku_anggota.sql
```

Perintah tersebut digunakan untuk membuat database terlebih dahulu, kemudian menjalankan file SQL yang berisi struktur tabel `buku` dan `anggota`.

### Kesimpulan

SQL pada Jobsheet 8 digunakan untuk membangun struktur awal database PostgreSQL SIMPUS-Mini. Database memiliki dua tabel utama, yaitu **`buku`** untuk menyimpan data buku dan **`anggota`** untuk menyimpan data anggota.

Dengan adanya struktur database ini, PHP pada Jobsheet 8 dapat melakukan proses `SELECT` untuk mengambil data dan `INSERT` untuk menambahkan data ke PostgreSQL.