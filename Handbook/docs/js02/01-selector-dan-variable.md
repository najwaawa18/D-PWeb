# JS02 — Selector dan CSS Variable

## CSS variable

Di awal stylesheet terdapat:

```css
:root {
    --maroon-dark: #4a1020;
    --maroon: #6f1d35;
    --maroon-mid: #8f304b;
    --maroon-light: #f7edf0;
    --cream: #fffaf8;
    --white: #ffffff;
    --text: #30252a;
    --muted: #76666d;
    --border: #ead9df;
}
```

Variable dipanggil menggunakan `var()`:

```css
header {
    background: linear-gradient(
        135deg,
        var(--maroon-dark),
        var(--maroon),
        var(--maroon-mid)
    );
}
```

### Kenapa variable berguna?

Kalau warna maroon utama ingin diganti, cukup ubah nilai `--maroon`. Semua aturan yang memakai `var(--maroon)` ikut berubah.

## Universal selector

```css
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
```

`*` memilih semua elemen. `box-sizing: border-box` membuat perhitungan ukuran elemen lebih mudah karena padding dan border ikut diperhitungkan dalam ukuran yang ditentukan.

## Selector element, class, id

```css
body { ... }
.search-box { ... }
#nav-toggle { ... }
```

- `body` = selector berdasarkan nama elemen.
- `.search-box` = selector class.
- `#nav-toggle` = selector id.
