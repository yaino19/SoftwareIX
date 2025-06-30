<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../src/controller/RecuperarPasswordController.php';
header('Content-Type: application/json');

$controller = new RecuperarPasswordController($conn);
$action = $_POST['action'] ?? '';
$response = ['success' => false, 'message' => 'Acción no válida'];

switch ($action) {
    case 'solicitar':
        $correo = $_POST['correo'] ?? '';
        $response = $controller->solicitarRecuperacion($correo);
        break;
    case 'verificar':
        $correo = $_POST['correo'] ?? '';
        $codigo = $_POST['codigo'] ?? '';
        $response = $controller->verificarCodigo($correo, $codigo);
        break;
    case 'cambiar':
        $correo = $_POST['correo'] ?? '';
        $nueva = $_POST['nueva'] ?? '';
        $response = $controller->cambiarContrasena($correo, $nueva);
        break;
}
echo json_encode($response);
