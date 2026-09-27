const exploreBtn =
    document.getElementById("exploreBtn");

const portfolio =
    document.getElementById("portfolio");


exploreBtn.addEventListener("click", () => {

    document.body.classList.add("entering");

    setTimeout(() => {

        portfolio.scrollIntoView({
            behavior: "smooth"
        });

    }, 300);

});