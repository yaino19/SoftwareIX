-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-07-2025 a las 23:54:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_zonautp`
--

DELIMITER $$
--
-- Procedimientos
--
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `usuario_id`, `fecha_creacion`, `fecha_actualizacion`, `estado`) VALUES
(1, 3, '2025-07-22 17:30:22', '2025-07-22 17:30:22', 'activo'),
(2, 1, '2025-07-22 21:35:42', '2025-07-22 21:35:42', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritoproductos`
--

CREATE TABLE `carritoproductos` (
  `id` bigint(20) NOT NULL,
  `carrito_id` bigint(20) NOT NULL,
  `producto_id` bigint(20) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `precio_unitario` decimal(10,2) NOT NULL,
  `fecha_agregado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Ropa'),
(2, 'Accesorio'),
(3, 'Oficina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `id` bigint(20) NOT NULL,
  `pedido_id` bigint(20) NOT NULL,
  `producto_id` bigint(20) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestionsesion`
--

CREATE TABLE `gestionsesion` (
  `id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) NOT NULL,
  `fecha_inicio` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gestionsesion`
--

INSERT INTO `gestionsesion` (`id`, `usuario_id`, `fecha_inicio`, `ip`, `user_agent`) VALUES
(1, 1, '2025-07-21 07:14:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0'),
(2, 3, '2025-07-21 07:24:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0'),
(3, 3, '2025-07-21 15:37:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0'),
(4, 3, '2025-07-21 23:03:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0'),
(5, 3, '2025-07-22 06:38:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0'),
(6, 1, '2025-07-22 07:51:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0'),
(7, 3, '2025-07-22 07:52:04', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0'),
(8, 3, '2025-07-22 16:51:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0'),
(9, 3, '2025-07-22 20:54:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0'),
(10, 3, '2025-07-22 20:54:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0'),
(11, 1, '2025-07-22 21:35:40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0'),
(12, 3, '2025-07-22 21:36:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intentossesion`
--

CREATE TABLE `intentossesion` (
  `id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) NOT NULL,
  `fecha_intento` timestamp NOT NULL DEFAULT current_timestamp(),
  `exito` tinyint(1) NOT NULL,
  `ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp(),
  `leido` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `usuario_id`, `asunto`, `mensaje`, `fecha_envio`, `leido`) VALUES
(7, 1, 'Prueb', 'Devolucion', '2025-07-22 21:36:30', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodospago`
--

CREATE TABLE `metodospago` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` bigint(20) NOT NULL,
  `pedido_id` bigint(20) NOT NULL,
  `metodo_pago_id` bigint(20) NOT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp(),
  `monto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria_id` bigint(20) DEFAULT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado del producto: 1=activo, 0=inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `categoria_id`, `imagen_url`, `activo`) VALUES
(17, 'Bolsa UTP', 'Bolsa ecológica resistente con logo institucional', 8.00, 2, 'img/productos/687f58981a9f4_1753176216.png', 1),
(18, 'Taza UTP', 'Taza de cerámica con logo de la universidad', 7.00, 3, 'img/productos/687f58a9c78a5_1753176233.png', 1),
(19, 'Portacredenciales UTP', 'Portacredenciales oficial para estudiantes y personal', 6.00, 2, 'img/productos/687f58bf80eef_1753176255.png', 1),
(20, 'Cuaderno UTP', 'Cuaderno universitario con logo institucional', 6.00, 3, 'img/productos/687f57e7ad77d_1753176039.png', 1),
(21, 'Libreta UTP', 'Libreta de notas con diseño oficial', 5.00, 3, 'img/productos/687f57f115cba_1753176049.png', 1),
(22, 'Calendario UTP', 'Calendario académico anual universitario', 4.00, 3, 'img/productos/687f57fa3d31a_1753176058.png', 1),
(23, 'Alfombrilla UTP', 'Alfombrilla para mouse con logo de la universidad', 3.00, 3, 'img/productos/687f58064c174_1753176070.png', 1),
(24, 'Folder UTP', 'Folder institucional para documentos', 2.00, 3, 'img/productos/687f58117fbad_1753176081.png', 1),
(25, 'Chaqueta Negra UTP', 'Chaqueta negra con bordado institucional', 15.00, 1, 'img/productos/687f581f153a3_1753176095.png', 1),
(26, 'Gorra Negra UTP', 'Gorra oficial negra con logo universitario', 10.00, 1, 'img/productos/687f582c4494a_1753176108.png', 1),
(27, 'Suéter UTP', 'Suéter universitario de alta calidad', 18.00, 1, 'img/productos/687f5835662c3_1753176117.png', 1),
(28, 'Chaqueta Mujer UTP', 'Chaqueta diseñada especialmente para mujeres', 16.00, 1, 'img/productos/687f583c57527_1753176124.png', 1),
(29, 'Chaqueta Blanca UTP', 'Chaqueta blanca con diseño institucional', 15.00, 1, 'img/productos/687f5845a9163_1753176133.png', 1),
(30, 'Pulsera UTP', 'Pulsera UTP', 3.00, 2, 'img/productos/687fdccf46f44_1753210063.png', 1),
(31, 'Llavero gamer UTP', 'Llavero gamer', 10.00, 2, 'img/productos/687fea7d10f37_1753213565.png', 1),
(33, 'Termo verde', 'Termo', 12.00, 2, 'img/productos/687ff46f928ce_1753216111.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuperacion_password`
--

CREATE TABLE `recuperacion_password` (
  `user_id` bigint(20) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `creado_en` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recuperacion_password`
--

INSERT INTO `recuperacion_password` (`user_id`, `codigo`, `creado_en`) VALUES
(3, '980452', '2025-07-22 16:50:14'),
(4, '359544', '2025-07-21 17:36:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposusuario`
--

CREATE TABLE `tiposusuario` (
  `id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiposusuario`
--

INSERT INTO `tiposusuario` (`id`, `tipo`) VALUES
(1, 'admin'),
(2, 'usuario'),
(3, 'google');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tipo_usuario_id` int(11) NOT NULL,
  `uid_google` varchar(100) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `tipo_usuario_id`, `uid_google`, `fecha_creacion`) VALUES
(1, 'Jason Arena', 'jasonarena.business@gmail.com', NULL, 3, '9pesZ0CJPQgHrF5Am3Mss8yksP93', '2025-07-21 07:14:00'),
(2, 'Roberto Gomez', 'roberto.gomez@gmail.com', '$2y$10$M8bLBMIkz8s68uDlusDDNugrrUkwDo4D9xJmyAgTEvDL2YVfBFFZW', 2, NULL, '2025-07-21 07:20:16'),
(3, 'Jason Arena', 'jason.arena@utp.ac.pa', '$2y$10$wN42A2qWKBsOy.PBxrF4aeeKR76WgM5AGUhKzm0L0Bu9oPB0kHzZm', 1, NULL, '2025-07-21 07:20:54'),
(4, 'Ian Arauz', 'ian.arauz@utp.ac.pa', '$2y$10$DBjW.A1lNMjO6rHZCC3.fOpitnpQwfCp/0UVbyJNyTBbWGH4/LRY6', 2, NULL, '2025-07-21 22:36:40');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario_id` (`usuario_id`),
  ADD KEY `idx_estado` (`estado`),
  ADD KEY `idx_carrito_usuario_estado` (`usuario_id`,`estado`);

--
-- Indices de la tabla `carritoproductos`
--
ALTER TABLE `carritoproductos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_carrito_producto` (`carrito_id`,`producto_id`),
  ADD KEY `idx_carrito_id` (`carrito_id`),
  ADD KEY `idx_producto_id` (`producto_id`),
  ADD KEY `idx_carritoproductos_carrito_producto` (`carrito_id`,`producto_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `gestionsesion`
--
ALTER TABLE `gestionsesion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `intentossesion`
--
ALTER TABLE `intentossesion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mensajes_usuario` (`usuario_id`);

--
-- Indices de la tabla `metodospago`
--
ALTER TABLE `metodospago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `metodo_pago_id` (`metodo_pago_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `recuperacion_password`
--
ALTER TABLE `recuperacion_password`
  ADD PRIMARY KEY (`user_id`);

--
-- Indices de la tabla `tiposusuario`
--
ALTER TABLE `tiposusuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `tipo_usuario_id` (`tipo_usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `carritoproductos`
--
ALTER TABLE `carritoproductos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gestionsesion`
--
ALTER TABLE `gestionsesion`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `intentossesion`
--
ALTER TABLE `intentossesion`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `metodospago`
--
ALTER TABLE `metodospago`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `tiposusuario`
--
ALTER TABLE `tiposusuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `carritoproductos`
--
ALTER TABLE `carritoproductos`
  ADD CONSTRAINT `carritoproductos_ibfk_1` FOREIGN KEY (`carrito_id`) REFERENCES `carrito` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carritoproductos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD CONSTRAINT `fk_detallepedido_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detallepedido_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gestionsesion`
--
ALTER TABLE `gestionsesion`
  ADD CONSTRAINT `fk_gestionsesion_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `intentossesion`
--
ALTER TABLE `intentossesion`
  ADD CONSTRAINT `fk_intentossesion_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `fk_mensajes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `fk_pagos_metodo` FOREIGN KEY (`metodo_pago_id`) REFERENCES `metodospago` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pagos_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `recuperacion_password`
--
ALTER TABLE `recuperacion_password`
  ADD CONSTRAINT `fk_recuperacion_password_usuario` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`tipo_usuario_id`) REFERENCES `tiposusuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
