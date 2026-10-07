# JS06 — Perubahan HTML

## Tabel dinamis

Pada halaman daftar buku/anggota, baris data statis diganti komentar seperti:

```html
<tbody>
    <!-- Baris diisi dinamis oleh assets/js/buku.js via fetch('../data/buku.json') -->
</tbody>
```

Artinya HTML hanya menyediakan tempat kosong. JavaScript bertugas membuat `<tr>`.

## Loading indicator

Pada daftar buku terdapat:

```html
<p id="loading-indicator" style="display:none;">
    Memuat data...
</p>
```

JavaScript mengubah `style.display` menjadi `block` ketika proses fetch dimulai dan kembali `none` setelah selesai.

## Script

Halaman buku:

```html
<script src="../assets/js/app.js"></script>
<script src="../assets/js/buku.js"></script>
```

Halaman anggota:

```html
<script src="../assets/js/app.js"></script>
<script src="../assets/js/anggota.js"></script>
```

`app.js` menangani fitur umum, sedangkan file khusus menangani pengambilan data masing-masing.
