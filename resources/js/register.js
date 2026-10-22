// Mostrar / ocultar contraseña
document.querySelectorAll('.toggle-pass').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var input = document.getElementById(btn.dataset.target);
        var visible = input.type === 'text';
        input.type = visible ? 'password' : 'text';
        btn.textContent = visible ? 'Show' : 'Hide';
    });
});

// Marcar en rojo el campo de confirmación si no coincide (solo visual)
var pass = document.getElementById('password');
var confirmPass = document.getElementById('confirm_password');

function checkMatch() {
    var mismatch = confirmPass.value !== '' && pass.value !== confirmPass.value;
    confirmPass.closest('.field').classList.toggle('is-error', mismatch);
}

pass.addEventListener('input', checkMatch);
confirmPass.addEventListener('input', checkMatch);

// Por ahora el formulario es estático: evitamos que recargue la página
document.querySelector('.register-form').addEventListener('submit', function (e) {
    e.preventDefault();
});