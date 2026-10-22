-- =====================================================
-- loginClassB - Base de datos completa
-- Ejecutar en phpMyAdmin (pestaña SQL) o con: mysql -u root -p < login.sql
-- ATENCIÓN: borra y vuelve a crear las tablas usuarios y pedidos.
-- =====================================================

CREATE DATABASE IF NOT EXISTS loginclassb
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE loginclassb;

-- -----------------------------------------------------
-- 1. Reiniciar tablas
-- -----------------------------------------------------
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS usuarios;

-- -----------------------------------------------------
-- 2. Usuarios
--    password VARCHAR(255): guarda hashes de password_hash()
-- -----------------------------------------------------
CREATE TABLE usuarios (
    id       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usuario  VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuario de prueba:  admin  /  12345   (cámbiala cuando ya no la necesites)
-- Hash generado con password_hash() (bcrypt), compatible con password_verify() de PHP
INSERT INTO usuarios (usuario, password) VALUES
('admin', '$2y$10$y1lX9dFSLqA6eGqB8HHjJOnzd54bE9PHgpHje.DLCb7sALzzSVFGC');

-- -----------------------------------------------------
-- 3. Pedidos (todas las columnas que inserta views/confirmar_compra.php)
-- -----------------------------------------------------
CREATE TABLE pedidos (
    id              INT UNSIGNED  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    producto_id     INT           NOT NULL,
    usuario         VARCHAR(50)   NOT NULL,
    nombre          VARCHAR(120)  NOT NULL,
    dni             VARCHAR(15)   NOT NULL,
    telefono        VARCHAR(20)   NOT NULL,
    correo          VARCHAR(120)  NOT NULL,
    cantidad        INT           NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    total           DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    entrega         VARCHAR(30)   NOT NULL,
    direccion       VARCHAR(255)  NOT NULL DEFAULT '',
    pago            VARCHAR(30)   NOT NULL,
    observaciones   TEXT          NULL,
    fecha_registro  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_pedidos_usuario (usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- 4. Verificar
-- -----------------------------------------------------
DESCRIBE usuarios;
DESCRIBE pedidos;