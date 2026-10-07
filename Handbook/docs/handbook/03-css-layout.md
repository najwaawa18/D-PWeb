# Desain Handbook — CSS Layout dan Responsive

## Desktop

```css
.app-shell {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 290px 1fr;
}
```

Sidebar tetap 290px, sedangkan content mengambil sisa ruang.

## Sidebar

```css
.sidebar {
    position: sticky;
    top: 0;
    height: 100vh;
    overflow: auto;
}
```

Artinya sidebar tetap berada di area atas viewport dan dapat scroll jika menu terlalu panjang.

## Reader

```css
.reader {
    max-width: 980px;
    margin: 0 auto;
    padding: 70px 6vw 100px;
}
```

`max-width` mencegah baris teks menjadi terlalu panjang pada monitor besar.

## Mobile

```css
@media(max-width:850px) {
    .app-shell { grid-template-columns: 1fr; }
    .sidebar { position: fixed; left: -310px; }
    .sidebar.open { left: 0; }
}
```

Pada layar kecil sidebar menjadi panel off-canvas. Tombol hamburger mengubah class `open`.

**Catatan:** menambah dokumentasi tidak memerlukan perubahan aturan visual ini.
