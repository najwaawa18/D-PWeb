# Desain Handbook — Gambaran Besar

Handbook memakai desain **maroon editorial**: sidebar gelap, area baca cream/paper, judul serif, isi sans-serif, dan aksen maroon.

## Tujuan desain

- terlihat seperti handbook pribadi, bukan dashboard admin;
- navigasi dokumentasi selalu tersedia;
- kode mudah dibaca;
- nyaman untuk dokumen panjang;
- responsive di layar kecil;
- tetap ringan karena dokumentasi disimpan sebagai Markdown.

## Struktur visual

```text
┌───────────────┬─────────────────────────────────────┐
│   SIDEBAR     │ TOPBAR                              │
│               ├─────────────────────────────────────┤
│ Brand         │                                     │
│ Search        │        READER / DOKUMENTASI         │
│ Menu          │                                     │
│               │                                     │
└───────────────┴─────────────────────────────────────┘
```

## Yang dipertahankan

Desain yang sudah ada **tidak dirombak**. Dokumentasi baru hanya ditambahkan ke sistem menu dan folder `docs/`; stylesheet utama tetap digunakan.
