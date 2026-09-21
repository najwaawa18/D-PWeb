-- =========================================================
-- DATABASE KAFEIN
-- Sistem Informasi Manajemen Kafe
-- PostgreSQL
-- =========================================================


-- =========================================================
-- 1. TABEL KATEGORI
-- =========================================================

CREATE TABLE IF NOT EXISTS kategori (
    id SERIAL PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL UNIQUE
);


-- =========================================================
-- 2. TABEL MENU
-- =========================================================

CREATE TABLE IF NOT EXISTS menu (
    id SERIAL PRIMARY KEY,

    kode_menu VARCHAR(20) NOT NULL UNIQUE,

    nama_menu VARCHAR(150) NOT NULL,

    kategori_id INTEGER NOT NULL,

    harga NUMERIC(12,2) NOT NULL
        CHECK (harga >= 0),

    stok INTEGER NOT NULL DEFAULT 0
        CHECK (stok >= 0),

    status VARCHAR(20) NOT NULL DEFAULT 'Tersedia'
        CHECK (status IN ('Tersedia', 'Tidak Tersedia')),

    CONSTRAINT fk_menu_kategori
        FOREIGN KEY (kategori_id)
        REFERENCES kategori(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);


-- =========================================================
-- 3. TABEL PELANGGAN
-- =========================================================

CREATE TABLE IF NOT EXISTS pelanggan (
    id SERIAL PRIMARY KEY,

    kode_pelanggan VARCHAR(20) NOT NULL UNIQUE,

    nama VARCHAR(150) NOT NULL,

    no_hp VARCHAR(30),

    email VARCHAR(150)
);


-- =========================================================
-- 4. TABEL MEJA
-- =========================================================

CREATE TABLE IF NOT EXISTS meja (
    id SERIAL PRIMARY KEY,

    nomor_meja VARCHAR(20) NOT NULL UNIQUE,

    kapasitas INTEGER NOT NULL
        CHECK (kapasitas > 0),

    status VARCHAR(20) NOT NULL DEFAULT 'Kosong'
        CHECK (status IN ('Kosong', 'Terisi', 'Dipesan'))
);


-- =========================================================
-- 5. TABEL PESANAN
-- =========================================================

CREATE TABLE IF NOT EXISTS pesanan (
    id SERIAL PRIMARY KEY,

    kode_pesanan VARCHAR(20) NOT NULL UNIQUE,

    pelanggan_id INTEGER,

    meja_id INTEGER,

    tanggal_pesanan TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP,

    status VARCHAR(30) NOT NULL DEFAULT 'Proses',

    total NUMERIC(12,2) NOT NULL DEFAULT 0,

    CONSTRAINT fk_pesanan_pelanggan
        FOREIGN KEY (pelanggan_id)
        REFERENCES pelanggan(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL,

    CONSTRAINT fk_pesanan_meja
        FOREIGN KEY (meja_id)
        REFERENCES meja(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);


-- =========================================================
-- 6. TABEL DETAIL PESANAN
-- =========================================================

CREATE TABLE IF NOT EXISTS detail_pesanan (
    id SERIAL PRIMARY KEY,

    pesanan_id INTEGER NOT NULL,

    menu_id INTEGER NOT NULL,

    jumlah INTEGER NOT NULL
        CHECK (jumlah > 0),

    harga NUMERIC(12,2) NOT NULL
        CHECK (harga >= 0),

    subtotal NUMERIC(12,2) NOT NULL
        CHECK (subtotal >= 0),

    CONSTRAINT fk_detail_pesanan
        FOREIGN KEY (pesanan_id)
        REFERENCES pesanan(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_detail_menu
        FOREIGN KEY (menu_id)
        REFERENCES menu(id)
        ON DELETE RESTRICT
);


-- =========================================================
-- 7. TABEL PEMBAYARAN
-- =========================================================

CREATE TABLE IF NOT EXISTS pembayaran (
    id SERIAL PRIMARY KEY,

    pesanan_id INTEGER NOT NULL UNIQUE,

    tanggal_bayar TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP,

    total_bayar NUMERIC(12,2) NOT NULL
        CHECK (total_bayar >= 0),

    metode_pembayaran VARCHAR(30) NOT NULL
        CHECK (
            metode_pembayaran IN (
                'Cash',
                'QRIS',
                'Debit',
                'E-Wallet'
            )
        ),

    status VARCHAR(20) NOT NULL DEFAULT 'Lunas'
        CHECK (
            status IN (
                'Lunas',
                'Belum Lunas'
            )
        ),

    CONSTRAINT fk_pembayaran_pesanan
        FOREIGN KEY (pesanan_id)
        REFERENCES pesanan(id)
        ON DELETE CASCADE
);


-- =========================================================
-- DATA AWAL KATEGORI
-- =========================================================

INSERT INTO kategori (nama_kategori)
VALUES
    ('Kopi'),
    ('Non-Kopi'),
    ('Makanan'),
    ('Snack'),
    ('Dessert')
ON CONFLICT (nama_kategori) DO NOTHING;


-- =========================================================
-- DATA AWAL MEJA
-- =========================================================

INSERT INTO meja (
    nomor_meja,
    kapasitas,
    status
)
VALUES
    ('M01', 2, 'Kosong'),
    ('M02', 2, 'Kosong'),
    ('M03', 4, 'Kosong'),
    ('M04', 4, 'Kosong'),
    ('M05', 6, 'Kosong')
ON CONFLICT (nomor_meja) DO NOTHING;


-- =========================================================
-- SELESAI
-- =========================================================