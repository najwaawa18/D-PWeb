# Desain Handbook — Visual System

## Warna

CSS menggunakan variable:

```css
:root {
    --ink: #2c2024;
    --muted: #76666d;
    --cream: #f7f1eb;
    --paper: #fffdfb;
    --maroon: #641c2b;
    --dark: #42121c;
    --line: #e5d7d4;
    --soft: #f2e7e7;
}
```

### Peran warna

- `--cream` → background global.
- `--paper` → permukaan kartu/reader.
- `--maroon` → aksen utama.
- `--dark` → bagian gelap/sidebar dan heading.
- `--muted` → teks sekunder.
- `--line` → border/separator.
- `--soft` → background ringan untuk tabel/card.

## Typography

Handbook memakai dua keluarga font dari Google Fonts:

```css
DM Sans
Playfair Display
```

DM Sans dipakai untuk body/UI. Playfair Display dipakai untuk heading agar terasa editorial.

## Kenapa kombinasi ini?

Sans-serif cocok untuk teks panjang dan navigasi. Serif memberi karakter pada judul tanpa mengorbankan keterbacaan isi.
