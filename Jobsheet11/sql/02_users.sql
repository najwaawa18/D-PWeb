-- =========================================================
-- JOBSHEET 10
-- TABEL USERS
-- =========================================================

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(150) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'petugas'
        CHECK (role IN ('admin', 'petugas')),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
