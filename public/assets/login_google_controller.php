<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (isset($_SESSION['usuario_id'])) {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'No tienes acceso a este recurso.']);
    exit();
}

require_once __DIR__ . '/../../src/model/Usuario.php';
require_once __DIR__ . '/../../config/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$correo = isset($data['email']) ? $data['email'] : null;
$uidGoogle = isset($data['uid']) ? $data['uid'] : null;
$nombre = isset($data['nombre']) ? $data['nombre'] : '';
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

if (!$correo || !$uidGoogle) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

// Inicializar conexión si no existe
if (!isset($conn) || !$conn) {
    $host = "localhost";
    $username = "jasonpty";
    $password = "jason27278";
    $database = "db_zonautp";
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos.']);
        exit;
    }
}
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
    // Registrar usuario Google automáticamente
    $resultado = $usuarios->registrarGoogle($nombre, $correo, $uidGoogle);
    if ($resultado['success']) {
        // Buscar el usuario recién creado
        $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE correo = ? OR uid_google = ?");
        $stmt->bind_param("ss", $correo, $uidGoogle);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        if ($usuario) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_correo'] = $usuario['correo'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario_id'];
            $usuarios->registrarSesion($usuario['id'], $ip, $user_agent);
            echo json_encode(['success' => true, 'message' => 'Registro y sesión con Google exitosos']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al obtener usuario tras registro con Google.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => $resultado['message'] ?? 'Error al registrar usuario Google.']);
    }
}