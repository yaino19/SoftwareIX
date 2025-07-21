<?php
session_start();

require_once(__DIR__ . '/../config/config.php');
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

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