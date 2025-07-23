<?php
session_start();
require_once '../../config/config.php';

header('Content-Type: application/json');

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no logueado']);
    exit;
}

try {
    // Si se solicita verificar mensajes no leídos
    if (isset($_GET['check_unread'])) {
        $query = "SELECT COUNT(*) as total FROM mensajes WHERE leido = 0";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        
        echo json_encode([
            'success' => true, 
            'mensajes_no_leidos' => (int)$row['total']
        ]);
        exit;
    }
    
    // Obtener mensajes con información del usuario (usando JOIN)
    $query = "SELECT m.id, m.usuario_id, m.asunto, m.mensaje, m.fecha_envio, m.leido,
                     u.nombre, u.correo 
              FROM mensajes m 
              JOIN usuarios u ON m.usuario_id = u.id 
              ORDER BY m.fecha_envio DESC";
    
    $result = $conn->query($query);
    $mensajes = [];
    
    while ($row = $result->fetch_assoc()) {
        $mensajes[] = [
            'id' => $row['id'],
            'usuario_id' => $row['usuario_id'],
            'asunto' => $row['asunto'],
            'mensaje' => $row['mensaje'],
            'fecha_envio' => $row['fecha_envio'],
            'leido' => (bool)$row['leido'],
            'usuario_nombre' => $row['nombre'],
            'usuario_email' => $row['correo']
        ];
    }
    
    echo json_encode(['success' => true, 'mensajes' => $mensajes]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
}

$conn->close();
?>