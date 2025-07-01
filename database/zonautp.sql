-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-06-2025
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12
-- Proyecto: SoftwareIX
-- Nombre de la base de datos: `db_zonautp`
-- Ecommerce Database Schema

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Base de datos: `db_zonautp`
DROP DATABASE IF EXISTS `db_zonautp`;
CREATE DATABASE `db_zonautp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_zonautp`;

DELIMITER $$
-- Procedimientos
CREATE DEFINER=`root`@`localhost` PROCEDURE `BuscarMetodoPagoPorId` (IN `p_id` INT)   BEGIN
    SELECT * FROM MetodosPago WHERE id = p_id;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `BuscarPedidoPorId` (IN `p_id` INT)   BEGIN
    SELECT * FROM Pedidos WHERE id = p_id;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `BuscarProductoPorId` (IN `p_id` INT)   BEGIN
    SELECT * FROM Productos WHERE id = p_id;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `BuscarUsuarioPorCorreo` (IN `p_correo` VARCHAR(100))   BEGIN
    SELECT * FROM Usuarios WHERE correo = p_correo;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `BuscarUsuarioPorId` (IN `p_id` BIGINT)   BEGIN
    SELECT * FROM Usuarios WHERE id = p_id;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearMetodoPago` (IN `p_nombre` VARCHAR(50))   BEGIN
    INSERT INTO MetodosPago (nombre)
    VALUES (p_nombre);
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearPedido` (IN `p_usuario_id` BIGINT, IN `p_total` DECIMAL(10,2))   BEGIN
    INSERT INTO Pedidos (usuario_id, total)
    VALUES (p_usuario_id, p_total);
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearProducto` (IN `p_nombre` VARCHAR(100), IN `p_descripcion` TEXT, IN `p_precio` DECIMAL(10,2), IN `p_categoria_id` INT, IN `p_imagen_url` VARCHAR(255))   BEGIN
    INSERT INTO Productos (nombre, descripcion, precio, categoria_id, imagen_url)
    VALUES (p_nombre, p_descripcion, p_precio, p_categoria_id, p_imagen_url);
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearUsuario` (IN `p_nombre` VARCHAR(100), IN `p_correo` VARCHAR(100), IN `p_password` VARCHAR(255), IN `p_tipo_usuario_id` INT, IN `p_uid_google` VARCHAR(100))   BEGIN
    INSERT INTO Usuarios (nombre, correo, password, tipo_usuario_id, uid_google)
    VALUES (p_nombre, p_correo, p_password, p_tipo_usuario_id, p_uid_google);
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarMetodoPago` (IN `p_id` INT, IN `p_nombre` VARCHAR(50))   BEGIN
    UPDATE MetodosPago
    SET nombre = p_nombre
    WHERE id = p_id;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarPedido` (IN `p_id` INT, IN `p_total` DECIMAL(10,2))   BEGIN
    UPDATE Pedidos
    SET total = p_total
    WHERE id = p_id;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarProducto` (IN `p_id` INT, IN `p_nombre` VARCHAR(100), IN `p_descripcion` TEXT, IN `p_precio` DECIMAL(10,2), IN `p_categoria_id` INT, IN `p_imagen_url` VARCHAR(255))   BEGIN
    UPDATE Productos
    SET nombre = p_nombre,
        descripcion = p_descripcion,
        precio = p_precio,
        categoria_id = p_categoria_id,
        imagen_url = p_imagen_url
    WHERE id = p_id;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarUsuario` (IN `p_id` BIGINT, IN `p_nombre` VARCHAR(100), IN `p_correo` VARCHAR(100), IN `p_password` VARCHAR(255), IN `p_tipo_usuario_id` INT, IN `p_uid_google` VARCHAR(100))   BEGIN
    UPDATE Usuarios
    SET nombre = p_nombre,
        correo = p_correo,
        password = p_password,
        tipo_usuario_id = p_tipo_usuario_id,
        uid_google = p_uid_google
    WHERE id = p_id;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarMetodoPago` (IN `p_id` INT)   BEGIN
    DELETE FROM MetodosPago WHERE id = p_id;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarPedido` (IN `p_id` INT)   BEGIN
    DELETE FROM Pedidos WHERE id = p_id;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarProducto` (IN `p_id` INT)   BEGIN
    DELETE FROM Productos WHERE id = p_id;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarUsuario` (IN `p_id` BIGINT)   BEGIN
    DELETE FROM Usuarios WHERE id = p_id;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ListarMetodosPago` ()   BEGIN
    SELECT * FROM MetodosPago;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ListarPedidos` ()   BEGIN
    SELECT * FROM Pedidos;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ListarProductos` ()   BEGIN
    SELECT * FROM Productos;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ListarUsuarios` ()   BEGIN
    SELECT * FROM Usuarios;
END$$
CREATE DEFINER=`jasonpty`@`localhost` PROCEDURE `LoginUsuario` (IN `p_correo` VARCHAR(100), IN `p_password` VARCHAR(255))   BEGIN
    SELECT * FROM Usuarios
    WHERE correo = p_correo AND password = p_password
    LIMIT 1;
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarIntentoSesion` (IN `p_usuario_id` BIGINT, IN `p_exito` BOOLEAN, IN `p_ip` VARCHAR(45))   BEGIN
    INSERT INTO IntentosSesion (usuario_id, exito, ip)
    VALUES (p_usuario_id, p_exito, p_ip);
END$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarSesion` (IN `p_usuario_id` BIGINT, IN `p_ip` VARCHAR(45), IN `p_user_agent` VARCHAR(255))   BEGIN
    INSERT INTO GestionSesion (usuario_id, ip, user_agent)
    VALUES (p_usuario_id, p_ip, p_user_agent);
END$$
DELIMITER ;

-- Tablas
CREATE TABLE `carrito` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `carritoproductos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `carrito_id` bigint(20) NOT NULL,
  `producto_id` bigint(20) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `carrito_id` (`carrito_id`),
  KEY `producto_id` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `categorias` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `detallepedido` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pedido_id` bigint(20) NOT NULL,
  `producto_id` bigint(20) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`),
  KEY `producto_id` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `gestionsesion` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) NOT NULL,
  `fecha_inicio` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `intentossesion` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) NOT NULL,
  `fecha_intento` timestamp NOT NULL DEFAULT current_timestamp(),
  `exito` tinyint(1) NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `metodospago` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pagos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pedido_id` bigint(20) NOT NULL,
  `metodo_pago_id` bigint(20) NOT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp(),
  `monto` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`),
  KEY `metodo_pago_id` (`metodo_pago_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pedidos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `productos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria_id` bigint(20) DEFAULT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `recuperacion_password` (
  `user_id` bigint(20) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `creado_en` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tiposusuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tiposusuario` (`id`, `tipo`) VALUES
(1, 'admin'),
(2, 'usuario'),
(3, 'google');

CREATE TABLE `usuarios` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tipo_usuario_id` int(11) NOT NULL,
  `uid_google` varchar(100) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`),
  KEY `tipo_usuario_id` (`tipo_usuario_id`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`tipo_usuario_id`) REFERENCES `tiposusuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;