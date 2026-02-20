const menus = document.querySelectorAll(".menuprincipal");

menus.forEach(menu => {
  menu.addEventListener("mouseenter", () => {
    menu.classList.add("active");
  });

  menu.addEventListener("mouseleave", () => {
    menu.classList.remove("active");
  });
});