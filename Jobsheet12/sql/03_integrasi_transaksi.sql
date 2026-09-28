-- =========================================================
-- JOBSHEET 12 - INTEGRASI TRANSAKSI CAFE_NAJWA
-- PostgreSQL
--
-- File ini tidak membuat database baru.
-- Jalankan setelah database.sql dan 02_users.sql.
-- =========================================================

-- Index untuk mempercepat relasi dan pencarian transaksi.
CREATE INDEX IF NOT EXISTS idx_pesanan_pelanggan
    ON pesanan (pelanggan_id);

CREATE INDEX IF NOT EXISTS idx_pesanan_meja
    ON pesanan (meja_id);

CREATE INDEX IF NOT EXISTS idx_detail_pesanan_pesanan
    ON detail_pesanan (pesanan_id);

CREATE INDEX IF NOT EXISTS idx_detail_pesanan_menu
    ON detail_pesanan (menu_id);

CREATE INDEX IF NOT EXISTS idx_pembayaran_pesanan
    ON pembayaran (pesanan_id);

-- =========================================================
-- INTEGRASI JS12
--
-- 1. Pesanan terhubung dengan pelanggan + meja.
-- 2. Detail pesanan terhubung dengan menu.
-- 3. Pembayaran terhubung dengan pesanan.
-- 4. Stok menu dikendalikan oleh proses pesanan.
-- =========================================================
