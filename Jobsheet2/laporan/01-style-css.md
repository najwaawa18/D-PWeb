# Ringkasan & Penjelasan Kode CSS (SIMPUS-Mini)

Berikut adalah penjelasan poin-poin utama rancangan file `style.css` untuk aplikasi **SIMPUS-Mini**:

---

## 1. Konsep Desain Utama

* **Tema Warna Maroon Modern**: Menggunakan kombinasi warna utama Maroon (`#800000`), Maroon Gelap (`#500000`), dan Krem Muda (`#f7eded`) sebagai aksen latar belakang agar tampilan terlihat profesional dan konsisten.
* **Tampilan Lurus & Tegas (*Flat Sharp Design*)**: Penggunaan properti `border-radius: 0 !important;` memastikan seluruh elemen—mulai dari tombol, bidang input, kartu statistik, hingga header tabel—memiliki sudut siku-siku lurus tanpa lekukan.

---

## 2. Struktur & Penataan Komponen

* **Navigasi (*Header & Navbar*)**: Memanfaatkan **CSS Flexbox** (`display: flex`) untuk memisahkan judul aplikasi di posisi kiri dan menu di posisi kanan. Dilengkapi efek *hover* yang merubah latar belakang tautan menjadi maroon gelap saat disentuh kursor.
* **Kartu Ringkasan Beranda (*CSS Grid*)**: Menggunakan fitur CSS modern `section:has(article)` dan `display: grid` dengan `repeat(3, 1fr)` untuk memaksa ketiga kartu statistik (*Total Buku*, *Total Anggota*, dan *Sedang Dipinjam*) berjajar rapi dalam 3 kolom ke samping secara otomatis.
* **Tabel Data (*Daftar Buku & Anggota*)**: Bagian kepala tabel (`thead`) dirancang kontras dengan latar maroon dan teks putih. Baris data (`tbody`) dilengkapi efek selang-seling warna (*zebra striping*) serta efek visual saat kursor diarahkan (*row hover*).
* **Tombol Aksi**: Dibuat berbeda berdasarkan fungsinya; tombol **Edit** menggunakan warna oranye-mustard (`#d97724`), sedangkan tombol **Hapus** menggunakan warna merah tua (`#a31c1c`).
* **Formulir Input**: Bidang isian teks, angka, dan dropdown dibatasi lebar maksimalnya (450px) dengan efek *glowing border* maroon saat elemen sedang aktif atau difokuskan (`:focus`).