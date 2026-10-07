# Jobsheet 03 — Responsive Design

## Tujuan

JS03 membuat SIMPUS-Mini lebih nyaman di desktop, tablet, dan smartphone.

## Perubahan HTML

Setiap halaman mendapatkan viewport metadata:

```html
<meta name="viewport" content="width=device-width, initial-scale=1">
```

Halaman tertentu mendapatkan kontrol hamburger:

```html
<input type="checkbox" id="nav-toggle" class="nav-toggle">
<label for="nav-toggle" class="nav-toggle-label">&#9776;</label>
```

Halaman tabel dibungkus:

```html
<div class="table-responsive">
    <table>...</table>
</div>
```

## Konsep inti

Responsive bukan berarti "membuat ukuran semuanya kecil". Responsive berarti **layout beradaptasi terhadap ruang yang tersedia**.
