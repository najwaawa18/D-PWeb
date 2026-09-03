# Catatan Responsive Design

CSS responsive digunakan untuk membuat tampilan website dapat menyesuaikan ukuran layar perangkat, baik desktop, tablet, maupun smartphone.

## Tabel Responsif

`.table-responsive` digunakan pada halaman daftar buku dan daftar anggota untuk membuat tabel dapat digeser secara horizontal apabila ukuran tabel lebih lebar daripada layar.

## Navigasi Responsive

`.nav-toggle` dan `.nav-toggle-label` digunakan untuk membuat navigasi hamburger pada perangkat dengan layar kecil. Pada tampilan desktop, keduanya disembunyikan karena menu navigasi ditampilkan secara normal.

Pada layar mobile, tombol hamburger akan ditampilkan. Ketika tombol tersebut dipilih, checkbox `.nav-toggle` menjadi aktif dan menu navigasi akan ditampilkan menggunakan selector:

`.nav-toggle:checked ~ nav`

Dengan cara ini, menu navigasi dapat dibuka dan ditutup tanpa menggunakan JavaScript.

## Responsive Tablet

Pada ukuran layar maksimal 768px, tampilan kartu atau konten yang menggunakan grid diubah menjadi 2 kolom menggunakan:

`grid-template-columns: repeat(2, 1fr);`

Hal ini dilakukan agar tampilan tetap rapi pada perangkat tablet.

## Responsive Mobile

Pada ukuran layar maksimal 480px, beberapa penyesuaian dilakukan, yaitu:

- Header menggunakan `position: relative` agar elemen di dalamnya dapat diatur dengan baik.
- Tombol hamburger ditampilkan sebagai pengganti menu navigasi biasa.
- Menu navigasi disembunyikan terlebih dahulu dan akan muncul ketika tombol hamburger dipilih.
- Menu navigasi diubah menjadi susunan vertikal menggunakan `flex-direction: column`.
- Link navigasi diberikan background dan garis pembatas agar lebih mudah dibedakan.
- Kartu statistik diubah menjadi 1 kolom menggunakan `grid-template-columns: 1fr`.
- Input teks, input angka, dan select dibatasi maksimal 100% dari lebar container agar tidak melebihi layar.

## Kesimpulan

Penerapan responsive design bertujuan agar website tetap nyaman digunakan pada berbagai ukuran layar. Website akan menyesuaikan tata letak berdasarkan perangkat yang digunakan, dengan tampilan desktop untuk layar besar, 2 kolom untuk tablet, dan 1 kolom serta menu hamburger untuk smartphone.