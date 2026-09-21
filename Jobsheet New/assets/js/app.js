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

    const tombolHapus =
        document.querySelectorAll(
            ".btn-hapus"
        );


    tombolHapus.forEach(
        function (button) {

            button.addEventListener(
                "click",
                function (event) {

                    const yakin =
                        confirm(
                            "Yakin ingin menghapus data ini?"
                        );


                    if (!yakin) {

                        event.preventDefault();

                    }

                }
            );

        }
    );



    // =====================================================
    // PENCARIAN DATA
    // =====================================================

    const searchInputs =
        document.querySelectorAll(
            "[data-search]"
        );


    searchInputs.forEach(
        function (input) {

            input.addEventListener(
                "input",
                function () {

                    const targetSelector =
                        input.getAttribute(
                            "data-search"
                        );


                    const target =
                        document.querySelector(
                            targetSelector
                        );


                    if (!target) {
                        return;
                    }


                    const keyword =
                        input.value.toLowerCase();


                    const rows =
                        target.querySelectorAll(
                            "tbody tr"
                        );


                    rows.forEach(
                        function (row) {

                            const text =
                                row.textContent
                                    .toLowerCase();


                            if (
                                text.includes(keyword)
                            ) {

                                row.style.display =
                                    "";

                            } else {

                                row.style.display =
                                    "none";

                            }

                        }
                    );

                }
            );

        }
    );

});