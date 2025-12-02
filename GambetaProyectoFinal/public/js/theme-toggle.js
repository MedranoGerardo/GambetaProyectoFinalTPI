document.addEventListener("DOMContentLoaded", () => {

    const body = document.body;
    const icon = document.getElementById("themeIcon");
    const toggle = document.getElementById("themeToggle");

    toggle.addEventListener("click", () => {

        // Cambiar a modo claro
        if (body.classList.contains("dark-mode")) {
            body.classList.remove("dark-mode");
            body.classList.add("light-mode");
            icon.classList.replace("bi-moon-fill", "bi-sun-fill");

        // Cambiar a modo oscuro
        } else {
            body.classList.remove("light-mode");
            body.classList.add("dark-mode");
            icon.classList.replace("bi-sun-fill", "bi-moon-fill");
        }
    });

});
