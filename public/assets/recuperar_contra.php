<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../src/controller/RecuperarPasswordController.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new RecuperarPasswordController($conn);

    // Verificación de código (AJAX)
    if (isset($_POST['verificar_codigo'])) {
        $correo = $_POST['correo'] ?? '';
        $codigo = $_POST['codigo'] ?? '';
        $result = $controller->verificarCodigo($correo, $codigo);
        echo $result['message'];
        exit;
    }

    // Solicitar recuperación (AJAX)
    if (isset($_POST['correo']) && !isset($_POST['verificar_codigo']) && !isset($_POST['cambiar_contrasena'])) {
        $correo = $_POST['correo'] ?? '';
        $result = $controller->solicitarRecuperacion($correo);
        echo $result['message'];
        exit;
    }

    // Cambio de contraseña (AJAX)
    if (isset($_POST['cambiar_contrasena'])) {
        $correo = $_POST['correo'] ?? '';
        $nuevaContrasena = $_POST['nuevaContrasena'] ?? '';
        $result = $controller->cambiarContrasena($correo, $nuevaContrasena);
        echo $result['message'];
        exit;
    }
    $correo = $_POST['correo'] ?? '';
    $result = $controller->solicitarRecuperacion($correo);
    $msg = $result['message'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="css/recuperar_contra.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background: url('./img/fondoLogin.png') no-repeat center center fixed; background-size: cover;">
    <div class="registro-card-split">
        <div class="registro-left">
            <div class="profile-icon-bg">
                <i class="fas fa-unlock-alt"></i>
            </div>
            <h2>¿Olvidaste tu contraseña?</h2>
            <p>Recupera el acceso a tu cuenta ingresando tu correo institucional o personal.</p>
        </div>
        <div class="registro-right">
            <form id="loginForm" class="login-form">
                <!-- El JS inserta aquí el input de correo/código/nueva contraseña -->
            </form>
            <div id="emailError" style="color:#ef4444; font-size:0.98em; margin-top:4px;"></div>
        </div>
    </div>
    <!-- Modal de éxito -->
    <div id="exitoModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" id="closeExitoModal">&times;</span>
            <div class="modal-success-icon"><i class="fas fa-check-circle"></i></div>
            <h2>¡Contraseña actualizada!</h2>
            <p>Tu contraseña ha sido cambiada exitosamente. Ahora puedes iniciar sesión.</p>
        </div>
    </div>
    <!-- Modal de carga -->
    <div id="loadingModal" class="modal">
        <div class="modal-content">
            <div class="modal-loading-icon"><i class="fas fa-spinner fa-spin"></i></div>
            <h2>Verificando código...</h2>
            <p>Por favor espera un momento.</p>
        </div>
    </div>
    <!-- Modal de mensaje general -->
    <div id="mensajeModal" class="modal">
        <div class="modal-content" style="max-width:350px;text-align:center;">
            <span class="close-modal" id="closeMensajeModal">&times;</span>
            <div id="mensajeModalIcon" style="font-size:2.5em;margin-bottom:10px;"></div>
            <h3 id="mensajeModalTitulo" style="margin-bottom:10px;"></h3>
            <p id="mensajeModalTexto"></p>
        </div>
    </div>
    <script src="./js/recuperar_contra.js"></script>
</body>
</html>
