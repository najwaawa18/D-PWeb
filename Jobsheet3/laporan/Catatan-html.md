## Catatan Tambahan

### Responsive dan Navigasi

Pada beberapa halaman ditambahkan beberapa kode untuk mendukung tampilan **responsive** dan navigasi pada perangkat dengan ukuran layar yang berbeda.

#### 1. Halaman Utama (`index.html`)

Ditambahkan:

- `<meta name="viewport" content="width=device-width, initial-scale=1">`  
  Digunakan agar tampilan halaman dapat menyesuaikan dengan ukuran layar perangkat, terutama pada perangkat mobile.

- `<input type="checkbox" id="nav-toggle" class="nav-toggle">`  
  Digunakan sebagai kontrol untuk membuka dan menutup menu navigasi.

- `<label for="nav-toggle" class="nav-toggle-label">&#9776;</label>`  
  Digunakan sebagai tombol menu hamburger (☰) yang berfungsi untuk menampilkan atau menyembunyikan navigasi pada layar kecil.

#### 2. Halaman Daftar Buku (`buku/list.html`) dan Daftar Anggota (`anggota/list.html`)

Ditambahkan kode yang sama seperti pada halaman utama untuk mendukung responsive dan navigasi.

Selain itu, terdapat:

- `<div class="table-responsive"></div>`  
  Digunakan sebagai container untuk membuat tabel lebih mudah ditampilkan pada layar yang sempit, seperti smartphone.

#### 3. Halaman Tambah Buku (`buku/tambah.html`) dan Tambah Anggota (`anggota/tambah.html`)

Ditambahkan:

- `<meta name="viewport" content="width=device-width, initial-scale=1">`  
  Digunakan agar tampilan form menyesuaikan dengan ukuran layar perangkat.

- `<input type="checkbox" id="nav-toggle" class="nav-toggle">`  
  Berfungsi sebagai kontrol untuk menu navigasi.

- `<label for="nav-toggle" class="nav-toggle-label">&#9776;</label>`  
  Berfungsi sebagai tombol hamburger (☰) untuk membuka dan menutup menu navigasi pada tampilan layar kecil.

### Kesimpulan

Penambahan kode tersebut bertujuan untuk membuat website lebih **responsive**, sehingga tampilan dapat menyesuaikan berbagai ukuran layar serta mempermudah pengguna dalam mengakses menu navigasi pada perangkat mobile.