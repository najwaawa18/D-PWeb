# JS03 — Tabel Responsive

## Masalah

Tabel mempunyai banyak kolom. Pada layar kecil, jika dipaksa menyusut, teks menjadi sempit dan sulit dibaca.

## Solusi

```html
<div class="table-responsive">
    <table>
        ...
    </table>
</div>
```

```css
.table-responsive {
    overflow-x: auto;
}
```

`overflow-x: auto` membuat scrollbar horizontal muncul **jika memang diperlukan**.

### Kenapa wrapper yang diberi overflow?

Karena tabel tetap boleh memiliki lebar yang diperlukan, sedangkan container bertanggung jawab menangani konten yang lebih lebar dari viewport.

## Kapan berguna?

- Tabel anggota.
- Tabel buku.
- Tabel dengan banyak kolom.
- Dashboard yang mempunyai data tabular.

## Kesalahan umum

Jangan hanya menulis `overflow-x: auto` tanpa memastikan elemen wrapper benar-benar membatasi area layout. Pola wrapper seperti di project ini lebih mudah dipahami dan dipelihara.
