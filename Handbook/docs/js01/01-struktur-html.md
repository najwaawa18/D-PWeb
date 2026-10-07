# JS01 — Struktur Dokumen HTML

## Template dasar

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMPUS-Mini | Daftar Buku</title>
</head>
<body>
    <header>...</header>
    <main>...</main>
    <footer>...</footer>
</body>
</html>
```

### Penjelasan

- `<!DOCTYPE html>` memberi tahu browser bahwa dokumen menggunakan HTML5.
- `<html lang="id">` adalah root element dan memberi informasi bahasa utama dokumen.
- `<head>` berisi metadata, bukan konten utama yang terlihat.
- `<meta charset="UTF-8">` menentukan encoding karakter.
- `<title>` menjadi judul tab browser.
- `<body>` berisi konten yang ditampilkan.

## Struktur semantik

```html
<header>
    <h1>SIMPUS-Mini</h1>
    <nav>...</nav>
</header>

<main>
    <section>
        <h2>Daftar Buku</h2>
        ...
    </section>
</main>

<footer>...</footer>
```

`header` bukan berarti hanya "bagian atas layar"; ia adalah bagian pengantar/kepala konten. `main` berisi konten utama halaman. `section` mengelompokkan satu bagian yang memiliki tema/judul. `footer` berisi informasi kaki halaman.

## Kenapa struktur ini bagus?

Karena struktur lebih mudah dibaca manusia, lebih jelas secara semantik, dan lebih mudah dikembangkan ketika CSS/JavaScript ditambahkan.
