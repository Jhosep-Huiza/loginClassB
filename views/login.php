<?php
// Leemos si hay un error enviado por el controlador
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>

    <!-- Íconos (usuario y candado) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Nuestro CSS -->
    <link rel="stylesheet" href="../resources/css/style.css">
</head>
<body>

    <div class="login-card">

        <h1 class="login-title">USER LOGIN</h1>

        <?php if ($error === '1'): ?>
            <p class="mensaje-error">Completa todos los campos</p>
        <?php elseif ($error === '2'): ?>
            <p class="mensaje-error">Usuario o contraseña incorrectos</p>
        <?php endif; ?>

        <form id="loginForm" action="../controllers/AuthController.php" method="POST">

            <div class="campo">
                <i class="fa-solid fa-user icono"></i>
                <input type="text" name="username" id="username" placeholder="Username">
            </div>

            <div class="campo">
                <i class="fa-solid fa-lock icono"></i>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>

            <div class="opciones">
                <label class="recordar">
                    <input type="checkbox" name="remember" checked>
                    <span>Remember</span>
                </label>
                <a href="recuperar.php">Forgot password ?</a>
            </div>

            <button type="submit" class="btn-login">LOGIN</button>
        </form>

        <a href="register.php" class="crear-cuenta">Create Account</a>
    </div>

    <script src="../resources/js/app.js"></script>
</body>
</html>