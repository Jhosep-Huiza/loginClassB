<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_ingresado = trim($_POST["usuario"]);
    $password_ingresada = trim($_POST["password"]);

    if ($usuario_ingresado === "admin" && $password_ingresada === "12345") {
        $_SESSION["usuario"] = $usuario_ingresado;
        header("Location: bienvenido.php");
        exit();
    } else {
        echo "<body style='background:#0f172a; color:#f8fafc; font-family:sans-serif; display:flex; flex-direction:column; align-items:center; justify-content:center; height:100vh; margin:0;'>";
        echo "<h3 style='color:#ef4444;'>Usuario o contraseña incorrectos.</h3>";
        echo "<p style='color:#94a3b8; font-size:12px;'>Recibido: ($usuario_ingresado)</p>";
        echo "<a href='index.php' style='color:#38bdf8; text-decoration:none; font-weight:600; margin-top:10px;'>Volver a intentarlo</a>";
        echo "</body>";
    }
}
?>
