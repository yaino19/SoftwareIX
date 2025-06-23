<?php
session_start();
require_once(__DIR__ . '/../model/Usuario.php');

$MAX_ATTEMPTS = 3;
$BLOCK_DURATION = 700; // Duración del bloqueo en segundos

$host = "localhost";
$username = "jasonpty";
$password = "jason27278";
$database = "db_zonautp";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$usuarios = new Usuarios($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';

    $usuario = $usuarios->obtenerUsuarioPorCorreo($correo);

    $usuario_id = $usuario ? $usuario['id'] : null;

    if ($usuario_id && $usuarios->estaBloqueado($usuario_id)) {
        // Calcula el tiempo restante de bloqueo
        $stmt = $conn->prepare("SELECT TIMESTAMPDIFF(SECOND, MAX(fecha_intento), NOW()) as tiempo_transcurrido FROM IntentosSesion WHERE usuario_id = ? AND exito = 0");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $remainingTime = $BLOCK_DURATION - ($row['tiempo_transcurrido'] ?? 0);

        $_SESSION['blockModal'] = true;
        $_SESSION['remainingTime'] = $remainingTime;
        header("Location: ../../public/assets/login.php");
        exit();
    } else {
        // Verificar si el usuario existe y la contraseña es correcta
        if ($usuario && $pass === $usuario['password']) {
            $usuarios->resetearIntentos($usuario_id);

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];

            // Registrar sesión (IP y agente de usuario)
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $usuarios->registrarSesion($usuario_id, $ip_address, $user_agent);

            header("Location: ../../index.php");
            exit();
        } else {
            if ($usuario_id) {
                $usuarios->registrarIntento($usuario_id, 0, $_SERVER['REMOTE_ADDR']);
            }
            $_SESSION['showModal'] = true;
            header("Location: ../../public/assets/login.php");
            exit();
        }
    }
}
?>