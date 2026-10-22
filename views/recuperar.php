<?php
// Leemos el estado que manda el controlador
$estado = $_GET['estado'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="../resources/css/style.css">
</head>
<body>

    <div class="recuperar-marco">
        <div class="recuperar-card">

            <h2 class="recuperar-titulo">Recuperar contraseña</h2>

            <?php if ($estado === '1'): ?>
                <p class="recuperar-mensaje error">Escribe un correo válido</p>
            <?php elseif ($estado === '3'): ?>
                <p class="recuperar-mensaje ok">Si el correo está registrado, recibirás las instrucciones</p>
            <?php endif; ?>

            <form id="recuperarForm" action="../controllers/AuthController.php" method="POST">
                <!-- Este campo oculto le avisa al controlador qué queremos hacer -->
                <input type="hidden" name="accion" value="recuperar">

                <input type="email" name="email" id="email" class="recuperar-input" placeholder="correo@dominio.com">

                <button type="submit" class="recuperar-btn">Recuperar contraseña</button>
            </form>

            <hr class="recuperar-linea">

            <p class="recuperar-pregunta">¿Ya tienes tu contraseña?</p>
            <p class="recuperar-texto">
                Entonces, <a href="login.php">haz click aquí</a> para acceder a tu Extranet de Cliente.
            </p>

        </div>
    </div>

    <script src="../resources/js/app.js"></script>
</body>
</html>