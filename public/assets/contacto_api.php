<?php
// Activar reporte de errores para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../../config/config.php';

header('Content-Type: application/json');

try {
    // Verificar que el usuario esté logueado
    if (!isset($_SESSION['usuario_id'])) {
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit;
    }

    // Verificar método POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        exit;
    }

    // Obtener datos del formulario
    $asunto = trim($_POST['asunto'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');
    $usuario_id = $_SESSION['usuario_id'];

    // Validar datos
    if (empty($asunto) || empty($mensaje)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
        exit;
    }

    // Insertar el mensaje (solo usuario_id, asunto y mensaje)
    $stmt = $conn->prepare("INSERT INTO mensajes (usuario_id, asunto, mensaje) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $usuario_id, $asunto, $mensaje);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Mensaje enviado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al insertar mensaje: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
}
?>
