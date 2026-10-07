# Desain Handbook — Menu dan Search

## Menu

Semua tombol yang memiliki `data-doc` dikumpulkan:

```js
const menuButtons = [
    ...document.querySelectorAll('[data-doc]')
];
```

Kemudian setiap tombol diberi click listener:

```js
menuButtons.forEach(button =>
    button.addEventListener('click', () =>
        openDoc(button.dataset.doc, button)
    )
);
```

## Active state

Sebelum dokumen baru dibuka:

```js
menuButtons.forEach(b => b.classList.remove('active'));
```

Lalu tombol yang dipilih diberi:

```js
button.classList.add('active');
```

CSS menentukan tampilannya.

## Search

```js
search.addEventListener('input', () => {
    const q = search.value.toLowerCase().trim();

    menuButtons.forEach(button => {
        const show = !q ||
            button.textContent.toLowerCase().includes(q);
        button.style.display = show ? '' : 'none';
    });
});
```

Search ini mencari **nama tombol menu**, bukan isi seluruh Markdown. Jadi jika ingin menemukan topik melalui search, nama menu perlu deskriptif.

## Mobile menu

```js
mobileMenu.addEventListener('click', () =>
    sidebar.classList.toggle('open')
);
```

Ini menghubungkan tombol hamburger dengan class `.open` pada sidebar.
