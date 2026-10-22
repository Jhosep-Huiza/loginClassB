<?php
session_start();

require_once __DIR__ . '/../model/user.php';

// --- Cerrar sesión ---
if (isset($_GET['logout'])) {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
    header('Location: ../views/login.php');
    exit;
}

// --- Solo POST ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/login.php');
    exit;
}

$userModel = new Usuario();
$accion = $_POST['accion'] ?? 'login';

// =====================================================
// RECUPERAR CONTRASEÑA
// =====================================================
if ($accion === 'recuperar') {
    // En este esquema no hay email; usamos el nombre de usuario
    $usuario = trim($_POST['email'] ?? $_POST['username'] ?? '');

    if ($usuario === '') {
        header('Location: ../views/recuperar.php?estado=1');
        exit;
    }

    $user = $userModel->findByEmail($usuario);

    if ($user) {
        // Aquí iría el envío real del correo / generación de token
    }

    // Misma respuesta exista o no el usuario (no revela cuentas)
    header('Location: ../views/recuperar.php?estado=3');
    exit;
}

// =====================================================
// LOGIN
// =====================================================
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header('Location: ../views/login.php?error=1');
    exit;
}

$user = $userModel->login($username, $password);

if ($user) {
    session_regenerate_id(true);
    $_SESSION['usuario']    = $user['usuario'];
    $_SESSION['usuario_id'] = $user['id'];
    header('Location: ../views/menu.php');
    exit;
}

header('Location: ../views/login.php?error=2');
exit;