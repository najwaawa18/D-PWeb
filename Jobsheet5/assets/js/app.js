// ===== Hamburger Menu =====
// Membuka dan menutup menu navigasi pada tampilan mobile
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");

    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}


// ===== Konfirmasi Hapus =====
// Menghapus baris dari tampilan setelah pengguna melakukan konfirmasi
// Penghapusan masih hanya di sisi front-end
function initHapusConfirm() {
    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const row = btn.closest("tr");

            const nama = row
                ? row.querySelector("td")?.textContent
                : "data ini";

            const yakin = confirm(
                'Yakin ingin menghapus "' + nama + '"?'
            );

            if (yakin && row) {
                row.remove();
            }
        });
    });
}


// ===== Pencarian Tabel Real-Time =====
// Menyaring data pada tabel berdasarkan kata yang diketik
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");

    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();

        const rows = table.querySelectorAll("tbody tr");

        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();

            row.style.display = teks.includes(keyword)
                ? ""
                : "none";
        });
    });
}


// ===== Menampilkan Pesan Error =====
function tampilkanError(input, pesan) {
    hapusError(input);

    const span = document.createElement("span");

    span.className = "error";
    span.textContent = pesan;

    input.insertAdjacentElement("afterend", span);
}


// ===== Menghapus Pesan Error =====
function hapusError(input) {
    const next = input.nextElementSibling;

    if (next && next.classList.contains("error")) {
        next.remove();
    }
}


// ===== Validasi Form Tambah Buku & Anggota =====
function initValidasiForm() {
    const form = document.getElementById("form-tambah");

    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;


        // Validasi Judul Buku / Nama Anggota
        const judul = form.querySelector(
            "[name='judul'], [name='nama']"
        );

        if (judul && judul.value.trim() === "") {
            tampilkanError(
                judul,
                "Field ini wajib diisi."
            );

            valid = false;
        } else if (judul) {
            hapusError(judul);
        }


        // Validasi Pengarang
        const pengarang = form.querySelector(
            "[name='pengarang']"
        );

        if (pengarang && pengarang.value.trim() === "") {
            tampilkanError(
                pengarang,
                "Pengarang wajib diisi."
            );

            valid = false;
        } else if (pengarang) {
            hapusError(pengarang);
        }


        // Validasi Tahun
        const tahun = form.querySelector(
            "[name='tahun']"
        );

        if (tahun) {
            const nilai = parseInt(
                tahun.value,
                10
            );

            if (
                isNaN(nilai) ||
                nilai < 1900 ||
                nilai > 2026
            ) {
                tampilkanError(
                    tahun,
                    "Tahun harus di antara 1900-2026."
                );

                valid = false;
            } else {
                hapusError(tahun);
            }
        }


        // Validasi Stok
        const stok = form.querySelector(
            "[name='stok']"
        );

        if (stok) {
            const nilai = parseInt(
                stok.value,
                10
            );

            if (
                isNaN(nilai) ||
                nilai < 0
            ) {
                tampilkanError(
                    stok,
                    "Stok tidak boleh negatif."
                );

                valid = false;
            } else {
                hapusError(stok);
            }
        }


        // Jika ada kesalahan, form tidak dikirim
        if (!valid) {
            e.preventDefault();
        }
    });
}


// ===== Menjalankan Semua Fungsi =====
document.addEventListener(
    "DOMContentLoaded",
    function () {
        initNavToggle();
        initHapusConfirm();
        initTableFilter();
        initValidasiForm();
    }
);