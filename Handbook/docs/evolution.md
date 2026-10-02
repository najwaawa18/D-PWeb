# Perkembangan JS09 → JS10 → JS11 → JS12 → Jobsheet New

## JS09 — Data management
Fokus utama: CRUD, search, pagination, master data dan transaksi dasar.

Pola yang harus dipahami:
`form → proses → database → redirect`.

## JS10 — Authentication
Fokus bergeser ke identitas pengguna:
- register;
- login;
- logout;
- session;
- role.

Pola:
`input login → query user → password_verify → session → halaman terlindungi`.

## JS11 — Security
Lapisan keamanan ditambahkan:
- prepared statement;
- CSRF;
- XSS output escaping;
- session fixation mitigation;
- validasi input.

Pola:
`request → security checks → business logic → database`.

## JS12 — Transaction integration
Fokus menjadi integrasi lintas tabel:
- pesanan;
- detail pesanan;
- stok menu;
- meja;
- pembayaran;
- transaction database;
- row locking;
- pengosongan meja.

Pola:
`validasi → beginTransaction → lock → read old state → update multiple tables → commit`,
atau `rollback` jika terjadi exception.

## Jobsheet New
Project final Cafe_Najwa mempertahankan konsep utama dan menyatukannya dalam struktur
aplikasi final. Jangan menganggap folder final otomatis identik 100% dengan JS12:
jika dosen menunjuk file final, baca source file final tersebut.
