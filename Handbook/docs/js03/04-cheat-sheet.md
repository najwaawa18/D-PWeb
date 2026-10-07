# JS03 — Cheat Sheet UTS

```html
<meta name="viewport" content="width=device-width, initial-scale=1">
```
→ membuat viewport mengikuti device.

```css
@media (max-width: 480px) { ... }
```
→ aturan khusus layar maksimal 480px.

```css
overflow-x: auto;
```
→ konten horizontal dapat digeser jika terlalu lebar.

```css
.nav-toggle:checked ~ nav { ... }
```
→ menu dipengaruhi status checkbox.

### Bedakan

**Responsive** = menyesuaikan layout.

**Adaptive** = dapat menggunakan layout tertentu berdasarkan kondisi/perangkat.

Dalam project ini yang paling jelas dipraktikkan adalah responsive melalui media query dan overflow.
