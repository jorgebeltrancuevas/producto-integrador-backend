-- Importar en una base de datos vacía seleccionada en el hosting.

CREATE TABLE `usuarios` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(100) NOT NULL,
    `usuario` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `fecha_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `rol` ENUM('usuario', 'admin') NOT NULL DEFAULT 'usuario',
    PRIMARY KEY (`id`),
    UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `imagenes` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre_archivo` VARCHAR(255) NOT NULL,
    `categoria` VARCHAR(50) NOT NULL DEFAULT 'General',
    `fecha_subida` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `usuario_id` INT DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `nombre_archivo` (`nombre_archivo`),
    KEY `fk_imagenes_usuario` (`usuario_id`),
    CONSTRAINT `fk_imagenes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
