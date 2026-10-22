<?php
// Plantilla. Copia este archivo como config/database.php y escribe tus datos reales.
// config/database.php está en .gitignore para no subir la contraseña a GitHub.

class Database
{
    private $host     = 'localhost';
    private $dbname   = 'loginclassb';
    private $username = 'root';
    private $password = ''; // En XAMPP por defecto es vacía

    public function getConnection()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            $conn = new PDO($dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $conn;
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }
}