const exploreBtn = document.getElementById("exploreBtn");
const portfolio = document.getElementById("portfolio");

const categories = document.getElementById("categories");
const categoryCards = document.querySelectorAll(".category-card");
const panels = document.querySelectorAll(".portfolio-panel");
const backButtons = document.querySelectorAll(".back-btn");


/* =====================================================
   EXPLORE PORTFOLIO
===================================================== */

exploreBtn.addEventListener("click", () => {

    portfolio.scrollIntoView({
        behavior: "smooth",
        block: "start"
    });

});


/* =====================================================
   OPEN CATEGORY
===================================================== */

categoryCards.forEach(card => {

    card.addEventListener("click", () => {

        const targetId = card.dataset.target;

        const targetPanel =
            document.getElementById(targetId);

        if (!targetPanel) return;


        categories.classList.add("category-hidden");


        panels.forEach(panel => {
            panel.classList.remove("panel-active");
        });


        setTimeout(() => {

            targetPanel.classList.add("panel-active");

            targetPanel.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

        }, 180);

    });

});


/* =====================================================
   BACK TO CATEGORIES
===================================================== */

backButtons.forEach(button => {

    button.addEventListener("click", () => {

        const currentPanel =
            button.closest(".portfolio-panel");

        currentPanel.classList.remove("panel-active");


        setTimeout(() => {

            categories.classList.remove("category-hidden");

            categories.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

        }, 200);

    });

});