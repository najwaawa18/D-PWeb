document.addEventListener("DOMContentLoaded", function () {


    // =====================================================
    // HAMBURGER MENU
    // =====================================================

    const navToggle =
        document.getElementById("navToggle");

    const mainNav =
        document.getElementById("mainNav");


    if (navToggle && mainNav) {

        navToggle.addEventListener("click", function () {

            const isOpen =
                mainNav.classList.toggle("open");


            navToggle.setAttribute(
                "aria-expanded",
                isOpen ? "true" : "false"
            );

        });

    }



    // =====================================================
    // DROPDOWN NAVBAR
    // =====================================================

    const dropdownGroups =
        document.querySelectorAll(".nav-group");


    dropdownGroups.forEach(function (group) {

        const toggle =
            group.querySelector(
                ".nav-dropdown-toggle"
            );


        if (!toggle) {
            return;
        }


        toggle.addEventListener(
            "click",
            function (event) {

                event.stopPropagation();


                const isOpen =
                    group.classList.contains("open");


                // Tutup semua dropdown lainnya

                dropdownGroups.forEach(
                    function (otherGroup) {

                        otherGroup.classList.remove(
                            "open"
                        );


                        const otherToggle =
                            otherGroup.querySelector(
                                ".nav-dropdown-toggle"
                            );


                        if (otherToggle) {

                            otherToggle.setAttribute(
                                "aria-expanded",
                                "false"
                            );

                        }

                    }
                );


                // Jika sebelumnya tertutup,
                // buka dropdown yang diklik

                if (!isOpen) {

                    group.classList.add("open");


                    toggle.setAttribute(
                        "aria-expanded",
                        "true"
                    );

                }

            }
        );

    });



    // =====================================================
    // KLIK DI LUAR NAVBAR
    // =====================================================

    document.addEventListener(
        "click",
        function (event) {

            if (
                !event.target.closest("#mainNav")
            ) {

                dropdownGroups.forEach(
                    function (group) {

                        group.classList.remove(
                            "open"
                        );


                        const toggle =
                            group.querySelector(
                                ".nav-dropdown-toggle"
                            );


                        if (toggle) {

                            toggle.setAttribute(
                                "aria-expanded",
                                "false"
                            );

                        }

                    }
                );

            }

        }
    );



    // =====================================================
    // KONFIRMASI HAPUS
    // =====================================================

    const formHapus =
        document.querySelectorAll(
            ".form-hapus"
        );

    formHapus.forEach(function (form) {

        form.addEventListener("submit", function (event) {

            const yakin = confirm(
                "Yakin ingin menghapus data ini?"
            );

            if (!yakin) {
                event.preventDefault();
            }

        });

    });

});
