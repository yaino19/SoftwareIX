<?php
define("urlsite", "http://localhost:3000/SoftwareIX/");

$host = "127.0.0.1";
$username = "freddy";
$password = "12345root";
$database = "db_zonautp";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>