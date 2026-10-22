```php
<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$host = 'localhost';
$db   = 'loginclassb';
$user = 'root';
$pass = ''; // Escribe aquí tu contraseña de MySQL si tienes una.

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ]
    );
} catch (PDOException $e) {
    error_log('Error de conexión MySQL: ' . $e->getMessage());

    http_response_code(500);
    exit('No se pudo conectar con la base de datos. Revisa la configuración de MySQL.');
}
