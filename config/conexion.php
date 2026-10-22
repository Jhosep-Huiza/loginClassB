<?php
// Conexión PDO única para todo el proyecto.
// Usa los datos de config/database.php, así la contraseña de MySQL vive en un solo archivo.
require_once __DIR__ . '/database.php';

$pdo = (new Database())->getConnection();