-- SQL para crear la base de datos y tablas
CREATE DATABASE IF NOT EXISTS halloween CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE halloween;

CREATE TABLE IF NOT EXISTS disfraces (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  descripcion TEXT NOT NULL,
  votos INT(11) NOT NULL DEFAULT 0,
  foto VARCHAR(255) DEFAULT '',
  foto_blob LONGBLOB,
  eliminado TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS usuarios (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL UNIQUE,
  clave TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS votos (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT(11) NOT NULL,
  id_disfraz INT(11) NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (id_disfraz) REFERENCES disfraces(id) ON DELETE CASCADE
);

-- Crear usuario admin de ejemplo (contraseña: admin123)
INSERT INTO usuarios (nombre, clave) VALUES ('admin', '{PASSWORD_PLACEHOLDER}');