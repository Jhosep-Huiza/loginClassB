document.addEventListener("DOMContentLoaded", function () {

    // ===== Formulario de LOGIN =====
    const loginForm = document.getElementById("loginForm");

    if (loginForm) {
        const username = document.getElementById("username");
        const password = document.getElementById("password");

        loginForm.addEventListener("submit", function (e) {
            if (username.value.trim() === "" || password.value.trim() === "") {
                e.preventDefault();
                alert("Por favor completa usuario y contraseña");
            }
        });
    }

    // ===== Formulario de RECUPERAR CONTRASEÑA =====
    const recuperarForm = document.getElementById("recuperarForm");

    if (recuperarForm) {
        const email = document.getElementById("email");

        recuperarForm.addEventListener("submit", function (e) {
            if (email.value.trim() === "") {
                e.preventDefault();
                alert("Por favor escribe tu correo");
            }
        });
    }
});