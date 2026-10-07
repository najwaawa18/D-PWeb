# JS05 — Cheat Sheet UTS

```js
document.getElementById("x")
```
→ cari satu elemen berdasarkan id.

```js
document.querySelector(".kelas")
```
→ cari elemen pertama yang cocok selector.

```js
document.querySelectorAll("tr")
```
→ ambil semua elemen yang cocok.

```js
element.addEventListener("click", handler)
```
→ jalankan handler saat click.

```js
event.preventDefault()
```
→ cegah aksi default.

```js
element.classList.toggle("active")
```
→ toggle class.

```js
element.remove()
```
→ hapus element dari DOM.

### Front-end only

`row.remove()` **bukan** DELETE database. Ini hanya mengubah DOM yang sedang terlihat.
