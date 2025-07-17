<?php
session_start();
require_once(__DIR__ . '/../model/Usuario.php');
require_once(__DIR__ . '/../services/LoggerService.php');

$MAX_ATTEMPTS = 3;
$BLOCK_DURATION = 700; // Duración del bloqueo en segundos

$host = "127.0.0.1";
$username = "freddy";
$password = "12345root";
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
        if ($usuario && password_verify($pass, $usuario['password'])) {
            $usuarios->resetearIntentos($usuario_id);

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];

            // Registrar sesión (IP y agente de usuario) solo si el usuario_id es válido y distinto de 0
            if ($usuario_id && $usuario_id > 0) {
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                $usuarios->registrarSesion($usuario_id, $ip_address, $user_agent);
                // Log de acceso exitoso
                LoggerService::log('accesos.log', 'Usuario ' . $correo . ' inició sesión correctamente desde IP ' . $ip_address);
            }

            header("Location: ../../index.php");
            exit();
        } else {
            if ($usuario_id) {
                $usuarios->registrarIntento($usuario_id, 0, $_SERVER['REMOTE_ADDR']);
                // Log de intento fallido
                LoggerService::log('error.log', 'Intento fallido de login para ' . $correo . ' desde IP ' . $_SERVER['REMOTE_ADDR']);
            }
            $_SESSION['showModal'] = true;
            header("Location: ../../public/assets/login.php");
            exit();
        }
    }
}
?>