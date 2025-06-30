CREATE DATABASE IF NOT EXISTS db_zonautp;
USE db_zonautp;

-- Tipos de usuario
CREATE TABLE IF NOT EXISTS TiposUsuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(50) NOT NULL
);

-- Usuarios
CREATE TABLE IF NOT EXISTS Usuarios (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    tipo_usuario_id INT NOT NULL,
    uid_google VARCHAR(100) DEFAULT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tipo_usuario_id) REFERENCES TiposUsuario(id)
);

-- Categorías
CREATE TABLE IF NOT EXISTS Categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Productos
CREATE TABLE IF NOT EXISTS Productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    categoria_id INT,
    imagen_url VARCHAR(255),
    FOREIGN KEY (categoria_id) REFERENCES Categorias(id)
);

-- Carrito
CREATE TABLE IF NOT EXISTS Carrito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id BIGINT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
);

CREATE TABLE IF NOT EXISTS CarritoProductos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    carrito_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    FOREIGN KEY (carrito_id) REFERENCES Carrito(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES Productos(id) ON DELETE CASCADE
);

-- Pedidos
CREATE TABLE IF NOT EXISTS Pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id BIGINT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
);

-- Detalle de cada pedido
CREATE TABLE IF NOT EXISTS DetallePedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES Pedidos(id),
    FOREIGN KEY (producto_id) REFERENCES Productos(id)
);

-- Métodos de pago
CREATE TABLE IF NOT EXISTS MetodosPago (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- Pagos
CREATE TABLE IF NOT EXISTS Pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    metodo_pago_id INT NOT NULL,
    fecha_pago TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    monto DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES Pedidos(id),
    FOREIGN KEY (metodo_pago_id) REFERENCES MetodosPago(id)
);


-- Tabla para gestionar sesiones de usuario
CREATE TABLE IF NOT EXISTS GestionSesion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id BIGINT NOT NULL,
    fecha_inicio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip VARCHAR(45),
    user_agent VARCHAR(255),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
);

-- Tabla para registrar intentos de inicio de sesión
CREATE TABLE IF NOT EXISTS IntentosSesion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id BIGINT NOT NULL,
    fecha_intento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    exito BOOLEAN NOT NULL,
    ip VARCHAR(45),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
);

-- Insertar tipos de usuario por defecto
INSERT INTO TiposUsuario (tipo) VALUES ('admin'), ('usuarios'), ('google')
    ON DUPLICATE KEY UPDATE tipo=tipo;

-- Procedimientos almacenados para usuarios
DELIMITER $$

CREATE PROCEDURE CrearUsuario(
    IN p_nombre VARCHAR(100),
    IN p_correo VARCHAR(100),
    IN p_password VARCHAR(255),
    IN p_tipo_usuario_id INT,
    IN p_uid_google VARCHAR(100)
)
BEGIN
    INSERT INTO Usuarios (nombre, correo, password, tipo_usuario_id, uid_google)
    VALUES (p_nombre, p_correo, p_password, p_tipo_usuario_id, p_uid_google);
END $$

CREATE PROCEDURE ListarUsuarios()
BEGIN
    SELECT * FROM Usuarios;
END $$

CREATE PROCEDURE BuscarUsuarioPorId(IN p_id BIGINT)
BEGIN
    SELECT * FROM Usuarios WHERE id = p_id;
END $$

CREATE PROCEDURE BuscarUsuarioPorCorreo(IN p_correo VARCHAR(100))
BEGIN
    SELECT * FROM Usuarios WHERE correo = p_correo;
END $$

CREATE PROCEDURE EditarUsuario(
    IN p_id BIGINT,
    IN p_nombre VARCHAR(100),
    IN p_correo VARCHAR(100),
    IN p_password VARCHAR(255),
    IN p_tipo_usuario_id INT,
    IN p_uid_google VARCHAR(100)
)
BEGIN
    UPDATE Usuarios
    SET nombre = p_nombre,
        correo = p_correo,
        password = p_password,
        tipo_usuario_id = p_tipo_usuario_id,
        uid_google = p_uid_google
    WHERE id = p_id;
END $$

CREATE PROCEDURE EliminarUsuario(IN p_id BIGINT)
BEGIN
    DELETE FROM Usuarios WHERE id = p_id;
END $$

-- Procedimientos para productos
CREATE PROCEDURE CrearProducto(
    IN p_nombre VARCHAR(100),
    IN p_descripcion TEXT,
    IN p_precio DECIMAL(10,2),
    IN p_categoria_id INT,
    IN p_imagen_url VARCHAR(255)
)
BEGIN
    INSERT INTO Productos (nombre, descripcion, precio, categoria_id, imagen_url)
    VALUES (p_nombre, p_descripcion, p_precio, p_categoria_id, p_imagen_url);
END $$

CREATE PROCEDURE ListarProductos()
BEGIN
    SELECT * FROM Productos;
END $$

CREATE PROCEDURE BuscarProductoPorId(IN p_id INT)
BEGIN
    SELECT * FROM Productos WHERE id = p_id;
END $$

CREATE PROCEDURE EditarProducto(
    IN p_id INT,
    IN p_nombre VARCHAR(100),
    IN p_descripcion TEXT,
    IN p_precio DECIMAL(10,2),
    IN p_categoria_id INT,
    IN p_imagen_url VARCHAR(255)
)
BEGIN
    UPDATE Productos
    SET nombre = p_nombre,
        descripcion = p_descripcion,
        precio = p_precio,
        categoria_id = p_categoria_id,
        imagen_url = p_imagen_url
    WHERE id = p_id;
END $$

CREATE PROCEDURE EliminarProducto(IN p_id INT)
BEGIN
    DELETE FROM Productos WHERE id = p_id;
END $$

-- Procedimientos para pedidos
CREATE PROCEDURE CrearPedido(
    IN p_usuario_id BIGINT,
    IN p_total DECIMAL(10,2)
)
BEGIN
    INSERT INTO Pedidos (usuario_id, total)
    VALUES (p_usuario_id, p_total);
END $$

CREATE PROCEDURE ListarPedidos()
BEGIN
    SELECT * FROM Pedidos;
END $$

CREATE PROCEDURE BuscarPedidoPorId(IN p_id INT)
BEGIN
    SELECT * FROM Pedidos WHERE id = p_id;
END $$

CREATE PROCEDURE EditarPedido(
    IN p_id INT,
    IN p_total DECIMAL(10,2)
)
BEGIN
    UPDATE Pedidos
    SET total = p_total
    WHERE id = p_id;
END $$

CREATE PROCEDURE EliminarPedido(IN p_id INT)
BEGIN
    DELETE FROM Pedidos WHERE id = p_id;
END $$

-- Procedimientos para métodos de pago
CREATE PROCEDURE CrearMetodoPago(
    IN p_nombre VARCHAR(50)
)
BEGIN
    INSERT INTO MetodosPago (nombre)
    VALUES (p_nombre);
END $$

CREATE PROCEDURE ListarMetodosPago()
BEGIN
    SELECT * FROM MetodosPago;
END $$

CREATE PROCEDURE BuscarMetodoPagoPorId(IN p_id INT)
BEGIN
    SELECT * FROM MetodosPago WHERE id = p_id;
END $$

CREATE PROCEDURE EditarMetodoPago(
    IN p_id INT,
    IN p_nombre VARCHAR(50)
)
BEGIN
    UPDATE MetodosPago
    SET nombre = p_nombre
    WHERE id = p_id;
END $$

CREATE PROCEDURE EliminarMetodoPago(IN p_id INT)
BEGIN
    DELETE FROM MetodosPago WHERE id = p_id;
END $$

-- Procedimientos para gestionar sesión
CREATE PROCEDURE RegistrarSesion(
    IN p_usuario_id BIGINT,
    IN p_ip VARCHAR(45),
    IN p_user_agent VARCHAR(255)
)
BEGIN
    INSERT INTO GestionSesion (usuario_id, ip, user_agent)
    VALUES (p_usuario_id, p_ip, p_user_agent);
END $$

-- Procedimiento para registrar un intento de inicio de sesión
CREATE PROCEDURE RegistrarIntentoSesion(
    IN p_usuario_id BIGINT,
    IN p_exito BOOLEAN,
    IN p_ip VARCHAR(45)
)
BEGIN
    INSERT INTO IntentosSesion (usuario_id, exito, ip)
    VALUES (p_usuario_id, p_exito, p_ip);
END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE LoginUsuario(
    IN p_correo VARCHAR(100),
    IN p_password VARCHAR(255)
)
BEGIN
    SELECT * FROM Usuarios
    WHERE correo = p_correo AND password = p_password
    LIMIT 1;
END $$

DELIMITER ;