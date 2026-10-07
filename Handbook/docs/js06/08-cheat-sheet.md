# JS06 — Cheat Sheet UTS

```js
async function fungsi() { ... }
```
→ fungsi asynchronous.

```js
const res = await fetch("data.json");
```
→ mengambil resource dan menunggu hasilnya.

```js
const data = await res.json();
```
→ membaca response sebagai JSON.

```js
if (!res.ok) throw new Error("...");
```
→ validasi status response.

```js
data.forEach(function(item) { ... });
```
→ iterasi array.

```js
document.createElement("tr")
```
→ membuat node HTML baru.

```js
tbody.appendChild(tr)
```
→ memasukkan node ke DOM.

```js
document.addEventListener("click", ...)
```
→ contoh event delegation.

### Alur wajib hafal

```text
fetch → response → response.json() → array/object → loop → DOM
```
