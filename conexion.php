<?php
// Datos de conexión
$host = '127.0.0.1'; // Dirección del servidor
$port = '3306';      // Puerto del servidor MySQL
$user = 'root';      // Usuario de MySQL
$password = 'root';  // Contraseña de MySQL
$database = 'hardware_store_v2'; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $user, $password, $database, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Si la conexión es exitosa
// echo "Conexión exitosa a la base de datos";
?>
