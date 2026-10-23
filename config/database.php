<?php

class Database
{
    private $host;
    private $dbname;
    private $username;
    private $password;

    public function __construct()
    {
        // ⚠️ Cambia estos valores por los reales
        $this->host     = 'localhost';
        $this->dbname = 'loginclassb';
        $this->username = 'root';
        $this->password = '';
    }

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