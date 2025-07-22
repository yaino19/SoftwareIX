<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once(__DIR__ . '/../../config/config.php');

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}

// Obtener datos de la petición
$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'agregar':
        agregarProducto($conn, $_SESSION['usuario_id'], $input);
        break;
    case 'obtener':
        obtenerCarrito($conn, $_SESSION['usuario_id']);
        break;
    case 'actualizar':
        actualizarCantidad($conn, $_SESSION['usuario_id'], $input);
        break;
    case 'eliminar':
        eliminarProducto($conn, $_SESSION['usuario_id'], $input);
        break;
    case 'vaciar':
        vaciarCarrito($conn, $_SESSION['usuario_id']);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}

$conn->close();

function obtenerOCrearCarrito($conn, $usuario_id) {
    // Verificar si el usuario tiene un carrito activo
    $stmt = $conn->prepare("SELECT id FROM carrito WHERE usuario_id = ? AND estado = 'activo'");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc()['id'];
    } else {
        // Crear nuevo carrito
        $stmt = $conn->prepare("INSERT INTO carrito (usuario_id, fecha_creacion, estado) VALUES (?, NOW(), 'activo')");
        $stmt->bind_param("i", $usuario_id);
        if ($stmt->execute()) {
            return $conn->insert_id;
        }
        return false;
    }
}

function agregarProducto($conn, $usuario_id, $data) {
    $producto_id = $data['producto_id'] ?? 0;
    $cantidad = $data['cantidad'] ?? 1;
    
    if (!$producto_id || $cantidad <= 0) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        return;
    }
    
    // Verificar que el producto existe y está activo
    $stmt = $conn->prepare("SELECT id, nombre, precio FROM productos WHERE id = ? AND COALESCE(activo, 1) = 1");
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $producto = $stmt->get_result()->fetch_assoc();
    
    if (!$producto) {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado o inactivo']);
        return;
    }
    
    $carrito_id = obtenerOCrearCarrito($conn, $usuario_id);
    if (!$carrito_id) {
        echo json_encode(['success' => false, 'message' => 'Error al crear carrito']);
        return;
    }
    
    // Verificar si el producto ya está en el carrito
    $stmt = $conn->prepare("SELECT id, cantidad FROM carritoproductos WHERE carrito_id = ? AND producto_id = ?");
    $stmt->bind_param("ii", $carrito_id, $producto_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        // Actualizar cantidad existente
        $item = $resultado->fetch_assoc();
        $nueva_cantidad = $item['cantidad'] + $cantidad;
        $stmt = $conn->prepare("UPDATE carritoproductos SET cantidad = ? WHERE id = ?");
        $stmt->bind_param("ii", $nueva_cantidad, $item['id']);
    } else {
        // Agregar nuevo producto
        $stmt = $conn->prepare("INSERT INTO carritoproductos (carrito_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $carrito_id, $producto_id, $cantidad, $producto['precio']);
    }
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Producto agregado al carrito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar producto']);
    }
}

function obtenerCarrito($conn, $usuario_id) {
    $carrito_id = obtenerOCrearCarrito($conn, $usuario_id);
    if (!$carrito_id) {
        echo json_encode(['success' => true, 'productos' => [], 'total' => 0, 'cantidad_total' => 0]);
        return;
    }
    
    $stmt = $conn->prepare("
        SELECT 
            cp.id as carrito_producto_id,
            cp.cantidad,
            cp.precio_unitario,
            p.id as producto_id,
            p.nombre,
            p.descripcion,
            p.precio,
            p.imagen_url,
            (cp.cantidad * cp.precio_unitario) as subtotal
        FROM carritoproductos cp
        JOIN productos p ON cp.producto_id = p.id
        WHERE cp.carrito_id = ? AND COALESCE(p.activo, 1) = 1
        ORDER BY cp.id DESC
    ");
    $stmt->bind_param("i", $carrito_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $productos = [];
    $total = 0;
    $cantidad_total = 0;
    
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
        $total += $row['subtotal'];
        $cantidad_total += $row['cantidad'];
    }
    
    echo json_encode([
        'success' => true,
        'productos' => $productos,
        'total' => $total,
        'cantidad_total' => $cantidad_total
    ]);
}

function actualizarCantidad($conn, $usuario_id, $data) {
    $carrito_producto_id = $data['carrito_producto_id'] ?? 0;
    $cantidad = $data['cantidad'] ?? 0;
    
    if (!$carrito_producto_id || $cantidad <= 0) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        return;
    }
    
    // Verificar que el producto del carrito pertenece al usuario
    $stmt = $conn->prepare("
        SELECT cp.id 
        FROM carritoproductos cp
        JOIN carrito c ON cp.carrito_id = c.id
        WHERE cp.id = ? AND c.usuario_id = ?
    ");
    $stmt->bind_param("ii", $carrito_producto_id, $usuario_id);
    $stmt->execute();
    
    if ($stmt->get_result()->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado en tu carrito']);
        return;
    }
    
    $stmt = $conn->prepare("UPDATE carritoproductos SET cantidad = ? WHERE id = ?");
    $stmt->bind_param("ii", $cantidad, $carrito_producto_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cantidad actualizada']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar cantidad']);
    }
}

function eliminarProducto($conn, $usuario_id, $data) {
    $carrito_producto_id = $data['carrito_producto_id'] ?? 0;
    
    if (!$carrito_producto_id) {
        echo json_encode(['success' => false, 'message' => 'ID inválido']);
        return;
    }
    
    // Verificar que el producto del carrito pertenece al usuario
    $stmt = $conn->prepare("
        SELECT cp.id 
        FROM carritoproductos cp
        JOIN carrito c ON cp.carrito_id = c.id
        WHERE cp.id = ? AND c.usuario_id = ?
    ");
    $stmt->bind_param("ii", $carrito_producto_id, $usuario_id);
    $stmt->execute();
    
    if ($stmt->get_result()->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado en tu carrito']);
        return;
    }
    
    $stmt = $conn->prepare("DELETE FROM carritoproductos WHERE id = ?");
    $stmt->bind_param("i", $carrito_producto_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Producto eliminado del carrito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar producto']);
    }
}

function vaciarCarrito($conn, $usuario_id) {
    $carrito_id = obtenerOCrearCarrito($conn, $usuario_id);
    if (!$carrito_id) {
        echo json_encode(['success' => true, 'message' => 'Carrito ya está vacío']);
        return;
    }
    
    $stmt = $conn->prepare("DELETE FROM carritoproductos WHERE carrito_id = ?");
    $stmt->bind_param("i", $carrito_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Carrito vaciado']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al vaciar carrito']);
    }
}
?>
