<?php
session_start();
require_once '../../src/model/Usuario.php';
require_once '../../config/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$correo = isset($data['email']) ? $data['email'] : null;
$uidGoogle = isset($data['uid']) ? $data['uid'] : null;
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

if (!$correo || !$uidGoogle) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

$conn = $GLOBALS['conn'];
$usuarios = new Usuarios($conn);

// Buscar usuario por correo y/o UID Google
$stmt = $conn->prepare("SELECT * FROM Usuarios WHERE correo = ? OR uid_google = ?");
$stmt->bind_param("ss", $correo, $uidGoogle);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if ($usuario) {
    // Iniciar sesión PHP
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nombre'] = $usuario['nombre'];
    $_SESSION['usuario_correo'] = $usuario['correo'];
    $_SESSION['tipo_usuario'] = $usuario['tipo_usuario_id'];
    $usuarios->registrarSesion($usuario['id'], $ip, $user_agent);
    echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso']);
} else {
    echo json_encode(['success' => false, 'message' => 'No existe una cuenta asociada a este Google. Por favor regístrate.']);
}
