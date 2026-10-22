<?php
session_start();

// Si no hay sesión iniciada, lo mandamos al login
if (!isset($_SESSION['username'])) {
    header("Location: views/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <a href="controllers/AuthController.php?logout=1">Cerrar sesión</a>
</body>
</html>