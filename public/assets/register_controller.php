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
if ($conn->connect_error) {
    header('Location: registro_usuario.php?error=' . urlencode('No se pudo conectar a la base de datos.'));
    exit;
}

$usuarios = new Usuarios($conn);

$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$password = trim($_POST['password'] ?? '');

if (!$nombre || !$apellido || !$correo || !$password) {
    header('Location: registro_usuario.php?error=' . urlencode('Faltan campos del formulario.'));
    exit;
}

// Validación de contraseña fuerte en backend
if (
    strlen($password) < 7 ||
    !preg_match('/[A-Z]/', $password) ||
    !preg_match('/[!@#$%^&*()_\-\=\[\]{};\\:\"\'\|,.<>\/?]/', $password)
) {
    header('Location: registro_usuario.php?error=' . urlencode('La contraseña debe tener al menos 7 caracteres, una mayúscula y un símbolo.'));
    exit;
}

$resultado = $usuarios->registrarUsuario($nombre, $apellido, $correo, $password);

if ($resultado['success']) {
    header('Location: registro_usuario.php?success=' . urlencode('¡Registro exitoso! Ahora puedes iniciar sesión.'));
    exit;
} else {
    header('Location: registro_usuario.php?error=' . urlencode($resultado['message'] ?? 'Error desconocido al registrar usuario.'));
    exit;
}
