<?php
session_start();

// Con sesión iniciada va al menú; si no, al login
if (!empty($_SESSION['usuario'])) {
    header("Location: bienvenido.php");
} else {
    header("Location: views/login.php");
}
exit;