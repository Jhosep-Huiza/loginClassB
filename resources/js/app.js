// Esperamos a que cargue la página
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("loginForm");
    const username = document.getElementById("username");
    const password = document.getElementById("password");

    form.addEventListener("submit", function (e) {
        // Si algún campo está vacío, detenemos el envío
        if (username.value.trim() === "" || password.value.trim() === "") {
            e.preventDefault();
            alert("Por favor completa usuario y contraseña");
        }
    });
});