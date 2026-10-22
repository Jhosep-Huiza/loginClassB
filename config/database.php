<?php
class Database {
    private $host = "localhost";
    private $db   = "login_db";
    private $user = "root";
    private $pass = "";          // en XAMPP la clave de root viene vacía

    public function getConnection() {
        try {
            $conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db};charset=utf8",
                $this->user,
                $this->pass
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}