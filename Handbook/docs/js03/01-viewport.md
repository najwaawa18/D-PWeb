# JS03 — Viewport dan Media Query

## Viewport

```html
<meta name="viewport" content="width=device-width, initial-scale=1">
```

`width=device-width` membuat viewport mengikuti lebar perangkat. `initial-scale=1` menetapkan skala awal 1:1.

Tanpa konfigurasi viewport yang tepat, browser mobile dapat memperlakukan halaman seperti halaman desktop yang diperkecil sehingga layout responsive tidak bekerja seperti yang diharapkan.

## Media query

Contoh pada CSS:

```css
@media (max-width: 768px) {
    main section:has(article) {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    main section:has(article) {
        grid-template-columns: 1fr;
    }
}
```

Artinya:

- di atas 768px → layout normal 3 kolom;
- sampai 768px → 2 kolom;
- sampai 480px → 1 kolom.

## Pola berpikir

```text
Desktop → 3 kolom
Tablet  → 2 kolom
Mobile  → 1 kolom
```
