<?php
require_once __DIR__ . '/../config/database.php';

class Usuario
{
    private PDO $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    /**
     * Login por nombre de usuario (columna `usuario`) y contraseña (`password`).
     * Acepta contraseña hasheada con password_hash() o, por compatibilidad,
     * en texto plano (comparada de forma segura).
     */
    public function login(string $usuario, string $clave): ?array
    {
        $sql = "SELECT id, usuario, password FROM usuarios WHERE usuario = :usuario LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['usuario' => $usuario]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        $guardada = (string) $row['password'];

        if (password_verify($clave, $guardada) || hash_equals($guardada, $clave)) {
            return $row;
        }

        return null;
    }

    /**
     * Recuperación de contraseña: en este esquema no hay email,
     * así que buscamos por nombre de usuario.
     * (Si algún día añades `correo` a la tabla, cambia el WHERE.)
     */
    public function findByEmail(string $usuario): ?array
    {
        $sql = "SELECT id, usuario, password
                FROM usuarios
                WHERE usuario = :usuario
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['usuario' => $usuario]);
        return $stmt->fetch() ?: null;
    }
}