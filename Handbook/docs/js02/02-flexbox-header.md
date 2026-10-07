# JS02 — Header dan Flexbox

## Kode inti

```css
header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}
```

### Penjelasan

- `display: flex` membuat children menjadi flex items.
- `align-items: center` mengatur posisi vertikal di tengah cross-axis.
- `justify-content: space-between` memberi jarak sehingga sisi kiri dan kanan terdorong berjauhan.
- `gap: 20px` memberi jarak antar-item.
- `flex-wrap: wrap` mengizinkan item turun ke baris berikutnya ketika ruang sempit.

Navbar:

```css
header nav ul {
    list-style: none;
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
```

`list-style: none` menghilangkan bullet bawaan `<ul>`.

## Hover

```css
header nav a:hover,
header nav a.active {
    background: rgba(255, 255, 255, 0.16);
    color: var(--white);
}
```

`:hover` aktif ketika pointer berada di atas link. `.active` dapat digunakan untuk menandai item yang aktif jika class tersebut diberikan pada HTML.
