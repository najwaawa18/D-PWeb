# Desain Handbook — JavaScript Reader & Markdown Parser

Handbook tidak membutuhkan backend khusus untuk membuka dokumen. `assets/app.js` mengambil file `.md` dengan Fetch API.

## Alur

```text
Klik menu
   ↓
openDoc(path, button)
   ↓
fetch(path)
   ↓
res.text()
   ↓
markdownToHtml(md)
   ↓
reader.innerHTML = hasil
```

## Konversi heading

```js
const h = line.match(/^(#{1,3})\s+(.*)$/);
```

Jumlah `#` menentukan `<h1>`, `<h2>`, atau `<h3>`.

## Code block

Ketika parser menemukan:

```text
```
```

state `inCode` diubah. Baris berikutnya dikumpulkan ke array `code` sampai fence berikutnya ditemukan.

Hasilnya:

```html
<pre><code>...</code></pre>
```

## List

Baris yang diawali `- ` atau `* ` diubah menjadi `<li>` dalam `<ul>`.

## Table

Baris Markdown yang dimulai/diakhiri `|` diproses menjadi `<table>`, `<thead>`, dan `<tbody>`.

## Inline formatting

Fungsi `inline()` menangani backtick, bold, dan italic sederhana.

## Catatan batasan

Parser ini **bukan Markdown engine lengkap**. Ia dibuat khusus untuk pola dokumentasi handbook yang digunakan project.
