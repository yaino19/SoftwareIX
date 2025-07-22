<?php

/*Configuración de Jason PTY*/
define("urlsite", "http://localhost/SoftwareIX/");


$host = "localhost";
$username = "jasonpty";
$password = "jason27278";
$database = "db_zonautp";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die('Error de conexión a la base de datos: ' . $conn->connect_error);
}

/* Configuración de Freddy
define("urlsite", "http://localhost:3000/SoftwareIX/");
$host = "127.0.0.1";
$username = "freddy";
$password = "12345root";
$database = "db_zonautp";*/
?>