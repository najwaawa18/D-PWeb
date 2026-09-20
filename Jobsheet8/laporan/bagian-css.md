## Implementasi CSS pada Jobsheet 8

Pada Jobsheet 8, tampilan SIMPUS-Mini diperbarui menggunakan tema **Galaxy Cosmic**. Perubahan CSS membuat tampilan aplikasi menggunakan nuansa gelap dengan kombinasi warna ungu, biru, cyan, dan pink serta beberapa efek cahaya untuk memberikan kesan modern.

### 1. Variabel Warna dan Tema

```css
:root {
    --space-deep: #050816;
    --space-dark: #080b1f;
    --space-panel: rgba(15, 19, 48, 0.78);
    --purple: #8b5cf6;
    --purple-light: #a78bfa;
    --blue: #3b82f6;
    --cyan: #22d3ee;
    --pink: #ec4899;
    --text-main: #f5f3ff;
    --text-soft: #b8b5d6;
    --text-muted: #8582a5;
    --border: rgba(139, 92, 246, 0.35);
    --border-soft: rgba(255, 255, 255, 0.1);
    --danger: #ef4444;
    --warning: #f59e0b;
    --success: #34d399;
}
```

Bagian `:root` digunakan untuk menyimpan variabel warna yang digunakan di berbagai bagian halaman. Dengan menggunakan variabel CSS, warna dapat digunakan kembali tanpa harus menuliskan nilai warna yang sama berulang kali.

Warna utama yang digunakan adalah warna gelap sebagai latar belakang, kemudian dipadukan dengan ungu, biru, cyan, dan pink sebagai warna aksen.

---

### 2. Latar Belakang Galaxy

```css
body {
    background:
        radial-gradient(circle at 15% 20%, rgba(139, 92, 246, 0.18), transparent 25%),
        radial-gradient(circle at 85% 15%, rgba(34, 211, 238, 0.12), transparent 25%),
        radial-gradient(circle at 50% 85%, rgba(236, 72, 153, 0.10), transparent 30%),
        linear-gradient(135deg, #03040d, #080b1f 45%, #0b0920);
    min-height: 100vh;
}
```

Background halaman menggunakan beberapa `radial-gradient()` dan `linear-gradient()` untuk menghasilkan perpaduan warna seperti ruang angkasa. Efek tersebut menjadi dasar dari tema Galaxy Cosmic yang digunakan pada aplikasi.

Selain itu, terdapat `body::before` yang digunakan untuk membuat pola titik-titik menyerupai bintang pada background.

```css
body::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    z-index: -1;
    background-image:
        radial-gradient(circle, rgba(255,255,255,0.9) 1px, transparent 1px),
        radial-gradient(circle, rgba(167,139,250,0.7) 1px, transparent 1px),
        radial-gradient(circle, rgba(34,211,238,0.6) 1px, transparent 1px);
}
```

Tiga pola radial gradient digunakan dengan ukuran dan posisi yang berbeda sehingga titik-titik yang dihasilkan tidak berada pada posisi yang sama dan memberikan efek seperti bintang.

---

### 3. Header dan Navbar

```css
header {
    background:
        linear-gradient(
            135deg,
            rgba(8, 11, 31, 0.96),
            rgba(25, 13, 58, 0.94)
        );
    color: #ffffff;
    padding: 1.2rem 2.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
```

Header menggunakan background gradient dengan warna gelap dan ungu. Navbar juga diberikan efek hover agar pengguna dapat mengetahui menu yang sedang diarahkan oleh cursor.

```css
header nav a:hover,
header nav a.active {
    color: #ffffff;
    background:
        linear-gradient(
            135deg,
            rgba(139, 92, 246, 0.2),
            rgba(34, 211, 238, 0.1)
        );
    border-color: rgba(139, 92, 246, 0.4);
}
```

Ketika menu di-hover, warna background berubah dan diberikan efek glow sehingga navigasi terlihat lebih interaktif.

---

### 4. Section dan Panel

```css
section {
    background:
        linear-gradient(
            145deg,
            rgba(15, 19, 48, 0.88),
            rgba(10, 13, 34, 0.82)
        );
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid var(--border);
    box-shadow:
        0 20px 50px rgba(0, 0, 0, 0.35),
        inset 0 1px 0 rgba(255, 255, 255, 0.04);
    backdrop-filter: blur(12px);
}
```

Setiap `section` dibuat menyerupai panel dengan warna gelap transparan. `box-shadow` digunakan untuk memberikan efek kedalaman, sedangkan `backdrop-filter: blur()` memberikan efek blur pada bagian belakang panel.

Judul section juga diberikan simbol dan warna cyan:

```css
section h2::before {
    content: "✦";
    color: var(--cyan);
    margin-right: 0.6rem;
}
```

---

### 5. Kartu Statistik

```css
main section:has(article) {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.4rem;
}
```

Bagian kartu statistik pada halaman beranda menggunakan CSS Grid sehingga tiga informasi, seperti **Total Buku, Total Anggota, dan Sedang Dipinjam**, dapat ditampilkan dalam tiga kolom.

Kartu juga memiliki efek ketika cursor diarahkan ke atasnya:

```css
main section article:hover {
    transform: translateY(-5px);
    border-color: rgba(34, 211, 238, 0.55);
    box-shadow:
        0 10px 35px rgba(0, 0, 0, 0.4),
        0 0 25px rgba(139, 92, 246, 0.12);
}
```

Efek tersebut membuat kartu sedikit bergerak ke atas dan menghasilkan efek cahaya.

---

### 6. Tabel Data

```css
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 0.8rem;
    background: rgba(5, 8, 22, 0.45);
}
```

Tabel menggunakan background gelap agar sesuai dengan tema keseluruhan aplikasi. Header tabel menggunakan gradient warna ungu dan biru.

```css
thead {
    background:
        linear-gradient(
            90deg,
            rgba(74, 35, 125, 0.9),
            rgba(22, 63, 104, 0.9)
        );
    color: #ffffff;
}
```

Baris tabel juga memiliki efek hover sehingga baris yang sedang diarahkan cursor lebih mudah dikenali.

---

### 7. Tombol Edit dan Hapus

Tombol Edit dan Hapus diberikan warna yang berbeda agar pengguna dapat membedakan fungsi keduanya.

```css
td button:first-of-type {
    background:
        linear-gradient(
            135deg,
            #7c3aed,
            #4f46e5
        );
}
```

Bagian tersebut digunakan untuk tombol **Edit** dengan kombinasi warna ungu dan biru.

Sedangkan tombol Hapus menggunakan warna merah:

```css
td button:last-of-type {
    background:
        linear-gradient(
            135deg,
            #dc2626,
            #991b1b
        );
}
```

Ketika tombol diarahkan cursor, diberikan efek `box-shadow` dan sedikit pergerakan menggunakan `transform`.

---

### 8. Form Input

Form juga disesuaikan dengan tema gelap.

```css
form input[type="text"],
form input[type="number"],
form select {
    width: 100%;
    max-width: 500px;
    padding: 0.75rem 0.9rem;
    border: 1px solid rgba(139, 92, 246, 0.3);
    background: rgba(4, 7, 20, 0.75);
    color: #ffffff;
}
```

Input menggunakan background gelap dengan border ungu. Ketika input aktif, border berubah menjadi cyan dan diberikan efek glow.

```css
form input:focus,
form select:focus {
    border-color: var(--cyan);
    box-shadow:
        0 0 0 2px rgba(34, 211, 238, 0.08),
        0 0 20px rgba(34, 211, 238, 0.12);
}
```

Tampilan ini digunakan pada form **Tambah Buku** dan **Tambah Anggota**.

---

### 9. Flash Message

Pada Jobsheet 8, Flash Message tetap digunakan untuk memberikan informasi mengenai hasil proses pengolahan data.

```css
.flash {
    padding: 0.8rem 1rem;
    margin-bottom: 1.2rem;
    font-weight: 500;
    border: 1px solid;
}
```

Pesan berhasil diberikan style khusus:

```css
.flash-success {
    background: rgba(52, 211, 153, 0.08);
    color: #6ee7b7;
    border-color: rgba(52, 211, 153, 0.3);
}
```

Sedangkan pesan kesalahan menggunakan warna merah:

```css
.flash-error {
    background: rgba(239, 68, 68, 0.08);
    color: #fca5a5;
    border-color: rgba(239, 68, 68, 0.3);
}
```

Perubahan warna membuat pengguna dapat membedakan pesan keberhasilan dan pesan kesalahan dengan lebih mudah.

---

### 10. Pesan Error Validasi

```css
.error {
    display: block;
    color: #f87171;
    font-size: 0.85rem;
    margin-top: 0.3rem;
}
```

Class `.error` digunakan untuk menampilkan pesan kesalahan yang dihasilkan oleh validasi JavaScript pada form. Pesan dibuat dengan ukuran lebih kecil dan warna merah agar terlihat sebagai informasi kesalahan pada input.

---

### 11. Footer

Footer juga disesuaikan dengan tema Galaxy Cosmic.

```css
footer {
    text-align: center;
    padding: 1.8rem;
    color: var(--text-muted);
    font-size: 0.85rem;
    border-top: 1px solid rgba(139, 92, 246, 0.2);
    background: rgba(4, 6, 18, 0.85);
}
```

Selain informasi copyright, footer memiliki elemen dekoratif berupa simbol bintang melalui pseudo-element:

```css
footer::before {
    content: "✦  ✧  ✦";
    display: block;
    color: var(--purple-light);
}
```

---

### 12. Responsive Design

CSS tetap menyediakan pengaturan responsive untuk tablet dan perangkat mobile.

Pada ukuran layar maksimal `768px`, kartu statistik berubah menjadi dua kolom:

```css
@media (max-width: 768px) {
    main section:has(article) {
        grid-template-columns: repeat(2, 1fr);
    }
}
```

Sedangkan pada ukuran maksimal `480px`, kartu statistik berubah menjadi satu kolom:

```css
@media (max-width: 480px) {
    main section:has(article) {
        grid-template-columns: 1fr;
    }
}
```

Pada tampilan mobile, navbar juga diubah menjadi hamburger menu. Menu awalnya disembunyikan:

```css
header nav {
    display: none;
}
```

Kemudian akan ditampilkan ketika class `nav-open` ditambahkan oleh JavaScript:

```css
header nav.nav-open {
    display: block;
}
```

Dengan demikian, tampilan aplikasi tetap dapat digunakan pada layar yang lebih kecil.

---

## Kesimpulan

Pada Jobsheet 8, CSS SIMPUS-Mini mengalami perubahan visual menjadi **Galaxy Cosmic Theme**. Perubahan meliputi penggunaan warna gelap, gradient, efek glow, pola bintang, panel transparan, serta penyesuaian tampilan tabel, form, tombol, flash message, dan footer.

Selain perubahan tampilan, CSS tetap mempertahankan fitur responsive dan mendukung interaksi JavaScript seperti hamburger menu, pencarian tabel, validasi form, serta flash message yang digunakan dalam proses PHP dan database pada Jobsheet 8.