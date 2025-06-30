<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit();
}

require_once(__DIR__ . '/../../src/model/Usuario.php');
$host = "localhost";
$username = "jasonpty";
$password = "jason27278";
$database = "db_zonautp";
$conn = new mysqli($host, $username, $password, $database);
$usuarios = new Usuarios($conn);

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$uidGoogle = trim($_POST['uidGoogle'] ?? '');

if (!$nombre || !$correo || !$uidGoogle) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos del usuario Google.']);
    exit;
}

$resultado = $usuarios->registrarGoogle($nombre, $correo, $uidGoogle);
echo json_encode($resultado);