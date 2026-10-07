# Desain Handbook — Cara Menambah Dokumentasi Tanpa Mengubah Desain

Jika ingin menambah dokumen baru, pola paling aman adalah:

## 1. Buat file Markdown

Contoh:

```text
docs/js06/09-fetch-lanjutan.md
```

Isi menggunakan Markdown biasa:

```md
# Judul

## Bagian

Penjelasan...

```js
const contoh = true;
```
```

## 2. Tambahkan satu tombol menu

```html
<button data-doc="docs/js06/09-fetch-lanjutan.md">
    Fetch Lanjutan
</button>
```

## 3. Jangan ubah CSS jika tidak perlu

Parser sudah mendukung heading, list, code block, table, blockquote, dan inline formatting dasar.

## 4. Uji path

Klik tombol. Jika muncul "Dokumen tidak dapat dibuka", periksa:

- ejaan folder;
- ejaan filename;
- huruf besar/kecil;
- lokasi file relatif terhadap `index.html`.

## Prinsip

**Konten bertambah, sistem visual tetap.** Inilah alasan desain handbook bisa dipertahankan walaupun jumlah dokumentasi menjadi jauh lebih banyak.
