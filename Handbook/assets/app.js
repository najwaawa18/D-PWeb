const input = document.getElementById("searchInput");
const sections = [...document.querySelectorAll(".content section")];
const links = [...document.querySelectorAll("#toc a")];

input.addEventListener("input", () => {
  const q = input.value.trim().toLowerCase();
  if (!q) {
    sections.forEach(s => s.style.display = "");
    return;
  }
  sections.forEach(s => {
    const hit = s.innerText.toLowerCase().includes(q);
    s.style.display = hit ? "" : "none";
  });
});

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;
    links.forEach(a => a.classList.remove("active"));
    const link = document.querySelector(`#toc a[href="#${entry.target.id}"]`);
    if (link) link.classList.add("active");
  });
}, {rootMargin:"-20% 0px -70% 0px"});

sections.forEach(s => observer.observe(s));
