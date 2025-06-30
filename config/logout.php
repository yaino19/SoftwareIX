<?php
session_start();

require_once(__DIR__ . '/../config/config.php');

// Registrar el fin de sesión en la base de datos
if (isset($_SESSION['gestion_sesion_id'])) {
    $stmt = $conn->prepare("UPDATE GestionSesion SET fecha_fin = NOW() WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['gestion_sesion_id']);
    $stmt->execute();
    $stmt->close();
}

session_unset();
session_destroy();

// Redirige al login de tu proyecto usando redirect POST-REDIRECT-GET
header("Location: " . urlsite . "public/assets/login.php?logout=1");
exit();
// NOTA: El mensaje de logout se muestra solo una vez porque el parámetro ?logout=1 solo está en la URL tras el redirect. Si recargas, desaparece.