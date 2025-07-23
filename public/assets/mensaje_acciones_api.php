<?php
session_start();
require_once '../../config/config.php';

header('Content-Type: application/json');

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no logueado']);
    exit;
}

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener datos JSON
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['accion']) || !isset($input['mensaje_id'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

$accion = $input['accion'];
$mensaje_id = intval($input['mensaje_id']);

try {
    if ($accion === 'marcar_leido') {
        // Marcar mensaje como leído
        $query = "UPDATE mensajes SET leido = 1 WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $mensaje_id);
        $result = $stmt->execute();
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Mensaje marcado como leído']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo marcar el mensaje']);
        }
        $stmt->close();
        
    } elseif ($accion === 'eliminar') {
        // Eliminar mensaje
        $query = "DELETE FROM mensajes WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $mensaje_id);
        $result = $stmt->execute();
        
        if ($result && $stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Mensaje eliminado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el mensaje']);
        }
        $stmt->close();
        
    } else {
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
    
} catch (Exception $e) {
    error_log("Error en mensaje_acciones_api: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error en el servidor']);
}
?>
