<?php
define("urlsite", "http://localhost/SoftwareIX/");

$host = "localhost";
$username = "jasonpty";
$password = "jason27278";
$database = "db_zonautp";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>