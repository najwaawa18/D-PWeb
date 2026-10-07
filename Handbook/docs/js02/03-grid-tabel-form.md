# JS02 — Grid, Tabel, Form

## Grid kartu statistik

```css
main section:has(article) {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}
```

`repeat(3, 1fr)` berarti membuat 3 kolom dengan ukuran fraksi yang sama.

Selector `:has(article)` memilih `section` yang memiliki descendant `article`. Ini membuat aturan lebih spesifik untuk section statistik.

## Tabel

```css
table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: linear-gradient(90deg, var(--maroon-dark), var(--maroon));
    color: var(--white);
}

tbody tr:nth-child(even) {
    background: #fcf5f7;
}
```

`nth-child(even)` menghasilkan zebra striping pada baris genap.

## Form

```css
form input[type="text"],
form input[type="number"],
form select {
    width: 100%;
    max-width: 450px;
}

form input:focus,
form select:focus {
    border-color: var(--maroon);
}
```

`[type="text"]` adalah attribute selector. `:focus` aktif ketika input sedang fokus.
