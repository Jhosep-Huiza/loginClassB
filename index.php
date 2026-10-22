<?php
session_start();

// Punto de entrada: con sesión va al menú, sin sesión al login
$destino = !empty($_SESSION['usuario']) ? 'views/menu.php' : 'views/login.php';
header('Location: ' . $destino);
exit;