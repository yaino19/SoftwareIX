<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . '/../../config/config.php');

// Verificar que sea admin
$isAdmin = false;
if (isset($_SESSION['usuario_id'])) {
    $conn = new mysqli($host, $username, $password, $database);
    if (!$conn->connect_error) {
        $stmt = $conn->prepare("SELECT tipo_usuario_id FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['usuario_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if (isset($row['tipo_usuario_id']) && $row['tipo_usuario_id'] == 1) {
                $isAdmin = true;
            }
        }
        $stmt->close();
        $conn->close();
    }
}

if (!$isAdmin) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
    exit;
}

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'listar':
        listarProductos();
        break;
    case 'obtener':
        obtenerProducto();
        break;
    case 'crear':
        crearProducto();
        break;
    case 'actualizar':
        actualizarProducto();
        break;
    case 'eliminar':
        eliminarProducto();
        break;
    case 'categorias':
        obtenerCategorias();
        break;
    case 'exportar':
        exportarProductos();
        break;
    case 'cambiar_estado':
        cambiarEstadoProducto();
        break;
    case 'estadisticas':
        obtenerEstadisticas();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}

function listarProductos() {
    global $host, $username, $password, $database;
    
    // Obtener filtros de GET parameters
    $buscar = $_GET['buscar'] ?? '';
    $categoria = $_GET['categoria'] ?? '';
    $precio = $_GET['precio'] ?? '';
    $orden_campo = $_GET['orden_campo'] ?? 'id';
    $orden_direccion = $_GET['orden_direccion'] ?? 'desc';
    $pagina = (int)($_GET['pagina'] ?? 1);
    $porPagina = (int)($_GET['entries_per_page'] ?? 10);
    
    // Validar campos de ordenamiento permitidos
    $campos_permitidos = ['id', 'nombre', 'precio', 'categoria'];
    if (!in_array($orden_campo, $campos_permitidos)) {
        $orden_campo = 'id';
    }
    
    // Validar dirección de ordenamiento
    $orden_direccion = strtoupper($orden_direccion);
    if (!in_array($orden_direccion, ['ASC', 'DESC'])) {
        $orden_direccion = 'DESC';
    }
    
    // Debug: Log de filtros recibidos
    error_log("Filtros recibidos - Buscar: '$buscar', Categoria: '$categoria', Precio: '$precio', Orden: '$orden_campo $orden_direccion', Pagina: $pagina");
    
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        return;
    }
    
    // Construir consulta con filtros
    $where = "WHERE 1=1";
    $params = [];
    $types = "";
    
    if (!empty($buscar)) {
        $where .= " AND p.nombre LIKE ?";
        $params[] = "%$buscar%";
        $types .= "s";
    }
    
    if (!empty($categoria)) {
        $where .= " AND p.categoria_id = ?";
        $params[] = $categoria;
        $types .= "i";
    }
    
    if (!empty($precio)) {
        switch ($precio) {
            case '0-10':
                $where .= " AND p.precio BETWEEN 0 AND 10";
                break;
            case '10-20':
                $where .= " AND p.precio BETWEEN 10 AND 20";
                break;
            case '20-50':
                $where .= " AND p.precio BETWEEN 20 AND 50";
                break;
            case '50+':
                $where .= " AND p.precio > 50";
                break;
        }
    }
    
    // Construir ORDER BY
    $order_by = "";
    switch ($orden_campo) {
        case 'nombre':
            $order_by = "ORDER BY p.nombre $orden_direccion";
            break;
        case 'precio':
            $order_by = "ORDER BY p.precio $orden_direccion";
            break;
        case 'categoria':
            $order_by = "ORDER BY c.nombre $orden_direccion";
            break;
        default:
            $order_by = "ORDER BY p.id $orden_direccion";
            break;
    }
    
    // Contar total de productos
    $countQuery = "SELECT COUNT(*) as total FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id $where";
    
    $stmt = $conn->prepare($countQuery);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 0;
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row && isset($row['total'])) {
            $total = $row['total'];
        }
    }
    $totalPaginas = ceil($total / $porPagina);
    
    // Obtener productos paginados
    $offset = ($pagina - 1) * $porPagina;
    $query = "SELECT p.*, c.nombre as categoria_nombre, 
              COALESCE(p.activo, 1) as activo
              FROM productos p 
              LEFT JOIN categorias c ON p.categoria_id = c.id 
              $where 
              $order_by 
              LIMIT ? OFFSET ?";
    
    $params[] = (int)$porPagina;
    $params[] = (int)$offset;
    $types .= "ii";

    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $productos = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
    }

    // Calcular estadísticas completas (sin filtros de paginación)
    $conn2 = new mysqli($host, $username, $password, $database);
    
    // Total de productos en toda la BD
    $totalProductosQuery = "SELECT COUNT(*) as total FROM productos";
    $totalProductosResult = $conn2->query($totalProductosQuery);
    $totalProductosCompleto = $totalProductosResult->fetch_assoc()['total'];
    
    // Total de categorías
    $totalCategoriasQuery = "SELECT COUNT(*) as total FROM categorias";
    $totalCategoriasResult = $conn2->query($totalCategoriasQuery);
    $totalCategorias = $totalCategoriasResult->fetch_assoc()['total'];
    
    // Precio promedio
    $precioPromedioQuery = "SELECT AVG(precio) as promedio FROM productos WHERE precio > 0";
    $precioPromedioResult = $conn2->query($precioPromedioQuery);
    $precioPromedio = $precioPromedioResult->fetch_assoc()['promedio'] ?? 0;
    
    // Como no hay fecha de creación, productosMes será igual al total de productos
    $productosMes = $totalProductosCompleto;
    
    $conn2->close();
    $conn->close();

    echo json_encode([
        'success' => true,
        'productos' => $productos,
        'totalPaginas' => $totalPaginas,
        'paginaActual' => $pagina,
        'totalProductos' => $totalProductosCompleto, // total general
        'total' => $total, // total filtrado
        'estadisticas' => [
            'totalProductos' => $totalProductosCompleto,
            'totalCategorias' => $totalCategorias,
            'precioPromedio' => round($precioPromedio, 2),
            'productosMes' => $productosMes
        ]
    ]);
}

function obtenerProducto() {
    global $host, $username, $password, $database;
    
    $id = $_GET['id'] ?? 0;
    
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        return;
    }
    
    $stmt = $conn->prepare("SELECT p.*, c.nombre as categoria_nombre, COALESCE(p.activo, 1) as activo FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE p.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($producto = $result->fetch_assoc()) {
        echo json_encode(['success' => true, 'producto' => $producto]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
    }
    
    $conn->close();
}

function crearProducto() {
    global $host, $username, $password, $database;
    
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $categoria_id = $_POST['categoria_id'] ?? null;
    
    if (empty($nombre) || $precio <= 0) {
        echo json_encode(['success' => false, 'message' => 'Nombre y precio son requeridos']);
        return;
    }
    
    $imagen_url = '';
    
    // Manejar subida de imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen_url = subirImagen($_FILES['imagen']);
        if (!$imagen_url) {
            echo json_encode(['success' => false, 'message' => 'Error al subir la imagen']);
            return;
        }
    }
    
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        return;
    }
    
    $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, categoria_id, imagen_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $nombre, $descripcion, $precio, $categoria_id, $imagen_url);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Producto creado correctamente', 'id' => $conn->insert_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al crear el producto']);
    }
    
    $stmt->close();
    $conn->close();
}

function actualizarProducto() {
    global $host, $username, $password, $database;
    
    $id = $_POST['id'] ?? 0;
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $categoria_id = $_POST['categoria_id'] ?? null;
    
    if (empty($nombre) || $precio <= 0 || $id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        return;
    }
    
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        return;
    }
    
    // Obtener imagen actual
    $stmt = $conn->prepare("SELECT imagen_url FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto_actual = $result->fetch_assoc();
    $imagen_url = $producto_actual['imagen_url'] ?? '';
    
    // Manejar nueva imagen si se subió
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nueva_imagen = subirImagen($_FILES['imagen']);
        if ($nueva_imagen) {
            // Eliminar imagen anterior si existe
            if (!empty($imagen_url) && file_exists(__DIR__ . '/' . $imagen_url)) {
                unlink(__DIR__ . '/' . $imagen_url);
            }
            $imagen_url = $nueva_imagen;
        }
    }
    
    $stmt = $conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, categoria_id = ?, imagen_url = ? WHERE id = ?");
    $stmt->bind_param("ssdisi", $nombre, $descripcion, $precio, $categoria_id, $imagen_url, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Producto actualizado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el producto']);
    }
    
    $stmt->close();
    $conn->close();
}

function eliminarProducto() {
    global $host, $username, $password, $database;
    
    $id = $_POST['id'] ?? 0;
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID inválido']);
        return;
    }
    
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        return;
    }
    
    // Obtener imagen para eliminarla
    $stmt = $conn->prepare("SELECT imagen_url FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
    
    // Eliminar producto
    $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Eliminar imagen si existe
        if ($producto && !empty($producto['imagen_url']) && file_exists(__DIR__ . '/' . $producto['imagen_url'])) {
            unlink(__DIR__ . '/' . $producto['imagen_url']);
        }
        echo json_encode(['success' => true, 'message' => 'Producto eliminado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el producto']);
    }
    
    $stmt->close();
    $conn->close();
}

function subirImagen($archivo) {
    $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $tamaño_maximo = 5 * 1024 * 1024; // 5MB
    
    $nombre_archivo = $archivo['name'];
    $tamaño_archivo = $archivo['size'];
    $archivo_temporal = $archivo['tmp_name'];
    
    // Validar extensión
    $extension = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
    if (!in_array($extension, $extensiones_permitidas)) {
        return false;
    }
    
    // Validar tamaño
    if ($tamaño_archivo > $tamaño_maximo) {
        return false;
    }
    
    // Crear directorio si no existe
    $directorio = __DIR__ . '/img/productos/';
    if (!is_dir($directorio)) {
        mkdir($directorio, 0755, true);
    }
    
    // Generar nombre único
    $nombre_unico = uniqid() . '_' . time() . '.' . $extension;
    $ruta_destino = $directorio . $nombre_unico;
    
    // Mover archivo
    if (move_uploaded_file($archivo_temporal, $ruta_destino)) {
        return 'img/productos/' . $nombre_unico;
    }
    
    return false;
}

function obtenerCategorias() {
    global $host, $username, $password, $database;
    
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        return;
    }
    
    $stmt = $conn->prepare("SELECT id, nombre FROM categorias ORDER BY nombre");
    $stmt->execute();
    $result = $stmt->get_result();
    
    $categorias = [];
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
    
    $stmt->close();
    $conn->close();
    
    echo json_encode($categorias);
}

function exportarProductos() {
    global $host, $username, $password, $database;
    
    // Obtener filtros de GET parameters
    $buscar = $_GET['buscar'] ?? '';
    $categoria = $_GET['categoria'] ?? '';
    $precio = $_GET['precio'] ?? '';
    $orden_campo = $_GET['orden_campo'] ?? 'id';
    $orden_direccion = $_GET['orden_direccion'] ?? 'desc';
    
    // Validar campos de ordenamiento permitidos
    $campos_permitidos = ['id', 'nombre', 'precio', 'categoria'];
    if (!in_array($orden_campo, $campos_permitidos)) {
        $orden_campo = 'id';
    }
    
    // Validar dirección de ordenamiento
    $orden_direccion = strtoupper($orden_direccion);
    if (!in_array($orden_direccion, ['ASC', 'DESC'])) {
        $orden_direccion = 'DESC';
    }
    
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        return;
    }
    
    // Construir consulta con filtros
    $where = "WHERE 1=1";
    $params = [];
    $types = "";
    
    if (!empty($buscar)) {
        $where .= " AND p.nombre LIKE ?";
        $params[] = "%$buscar%";
        $types .= "s";
    }
    
    if (!empty($categoria)) {
        $where .= " AND p.categoria_id = ?";
        $params[] = $categoria;
        $types .= "i";
    }
    
    if (!empty($precio)) {
        switch ($precio) {
            case '0-10':
                $where .= " AND p.precio BETWEEN 0 AND 10";
                break;
            case '10-20':
                $where .= " AND p.precio BETWEEN 10 AND 20";
                break;
            case '20-50':
                $where .= " AND p.precio BETWEEN 20 AND 50";
                break;
            case '50+':
                $where .= " AND p.precio > 50";
                break;
        }
    }
    
    // Construir ORDER BY
    $order_by = "";
    switch ($orden_campo) {
        case 'nombre':
            $order_by = "ORDER BY p.nombre $orden_direccion";
            break;
        case 'precio':
            $order_by = "ORDER BY p.precio $orden_direccion";
            break;
        case 'categoria':
            $order_by = "ORDER BY c.nombre $orden_direccion";
            break;
        default:
            $order_by = "ORDER BY p.id $orden_direccion";
            break;
    }
    
    // Obtener todos los productos para exportar
    $query = "SELECT p.id, p.nombre, p.descripcion, p.precio, c.nombre as categoria_nombre, p.imagen_url
              FROM productos p 
              LEFT JOIN categorias c ON p.categoria_id = c.id 
              $where 
              $order_by";
    
    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    // Configurar headers para descarga CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="productos_' . date('Y-m-d_H-i-s') . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Crear output stream
    $output = fopen('php://output', 'w');
    
    // Escribir BOM para UTF-8
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Escribir headers del CSV
    fputcsv($output, ['ID', 'Nombre', 'Descripción', 'Precio', 'Categoría', 'Imagen'], ';');
    
    // Escribir datos
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, [
                $row['id'],
                $row['nombre'],
                $row['descripcion'] ?? '',
                '$' . number_format($row['precio'], 2),
                $row['categoria_nombre'] ?? 'Sin categoría',
                $row['imagen_url'] ?? 'Sin imagen'
            ], ';');
        }
    }
    
    fclose($output);
    $conn->close();
    exit;
}

function cambiarEstadoProducto() {
    global $host, $username, $password, $database;
    
    $id = $_POST['id'] ?? 0;
    $estado = $_POST['estado'] ?? 1;
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID de producto no válido']);
        return;
    }
    
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        return;
    }
    
    $stmt = $conn->prepare("UPDATE productos SET activo = ? WHERE id = ?");
    $stmt->bind_param("ii", $estado, $id);
    
    if ($stmt->execute()) {
        $estadoTexto = $estado == 1 ? 'activado' : 'desactivado';
        echo json_encode(['success' => true, 'message' => "Producto $estadoTexto correctamente"]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al cambiar el estado del producto']);
    }
    
    $stmt->close();
    $conn->close();
}

function obtenerEstadisticas() {
    global $host, $username, $password, $database;
    
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        return;
    }
    
    // Total de productos (corregido: solo cuenta productos, sin join)
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM productos");
    $stmt->execute();
    $result = $stmt->get_result();
    $totalProductos = 0;
    if ($result && $row = $result->fetch_assoc()) {
        $totalProductos = $row['total'];
    }
    $stmt->close();
    
    // Total de categorías
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM categorias");
    $stmt->execute();
    $result = $stmt->get_result();
    $totalCategorias = 0;
    if ($result && $row = $result->fetch_assoc()) {
        $totalCategorias = $row['total'];
    }
    $stmt->close();
    
    // Precio promedio
    $stmt = $conn->prepare("SELECT AVG(p.precio) as promedio FROM productos p WHERE p.precio > 0");
    $stmt->execute();
    $result = $stmt->get_result();
    $precioPromedio = 0;
    if ($result && $row = $result->fetch_assoc()) {
        $precioPromedio = $row['promedio'] ?? 0;
    }
    $stmt->close();
    
    // Total de productos (para la tarjeta y para productosMes si no hay fecha_creacion)
    $productosMes = $totalProductos;
    
    $conn->close();
    
    echo json_encode([
        'success' => true,
        'estadisticas' => [
            'totalProductos' => (int)$totalProductos,
            'totalCategorias' => (int)$totalCategorias,
            'precioPromedio' => round($precioPromedio, 2),
            'productosMes' => (int)$productosMes
        ]
    ]);
}

// Crear directorio de uploads si no existe
if (!is_dir(__DIR__ . '/img/productos/')) {
    mkdir(__DIR__ . '/img/productos/', 0755, true);
}
