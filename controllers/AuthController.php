<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/user.php';

// --- Cerrar sesión ---
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../views/login.php");
    exit;
}

// --- Solo aceptamos envíos por POST ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/login.php");
    exit;
}

// --- Preparamos la conexión y el modelo ---
$database  = new Database();
$db        = $database->getConnection();
$userModel = new User($db);

// --- ¿Qué quiere hacer? (por defecto: login) ---
$accion = $_POST['accion'] ?? 'login';

// =====================================================
// RECUPERAR CONTRASEÑA
// =====================================================
if ($accion === 'recuperar') {
    $email = trim($_POST['email'] ?? '');

    // Correo vacío o con formato inválido
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../views/recuperar.php?estado=1");
        exit;
    }

    $user = $userModel->findByEmail($email);

    if ($user) {
        // Aquí iría el envío real del correo con el enlace para cambiar la clave
    }

    // Siempre mostramos el mismo mensaje exista o no el correo
    // (así nadie puede averiguar qué correos están registrados)
    header("Location: ../views/recuperar.php?estado=3");
    exit;
}

// =====================================================
// LOGIN
// =====================================================
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header("Location: ../views/login.php?error=1");
    exit;
}

$user = $userModel->findByUsername($username);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];

    // Nombres que usan las páginas de la cafetería
    $_SESSION['usuario_id'] = $user['id'];
    $_SESSION['usuario']    = $user['username'];

    header("Location: ../bienvenido.php");
    exit;
}