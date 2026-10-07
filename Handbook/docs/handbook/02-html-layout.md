# Desain Handbook — Struktur HTML

Struktur utama `index.html`:

```html
<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <!-- brand, search, menu -->
    </aside>

    <main class="content">
        <header class="topbar">
            <!-- mobile button + title + portfolio link -->
        </header>

        <article id="reader" class="reader">
            <!-- welcome atau hasil dokumentasi -->
        </article>
    </main>
</div>
```

## Kenapa `aside`?

Sidebar berisi konten pelengkap utama berupa navigasi dokumentasi, sehingga `aside` cocok secara semantik.

## Kenapa `main`?

Area kanan adalah konten utama yang sedang dibaca.

## `reader`

`#reader` adalah target yang diisi JavaScript. Saat pengguna klik menu, Markdown diambil lalu hasil HTML dimasukkan ke `reader.innerHTML`.

## Menu berbasis `data-doc`

```html
<button data-doc="docs/js06/02-json.md">
    JSON
</button>
```

`data-doc` menyimpan path dokumen. JavaScript membacanya melalui:

```js
button.dataset.doc
```

Dengan pola ini satu halaman HTML dapat membuka banyak dokumen tanpa reload penuh.
