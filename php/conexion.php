<?php
$servername = "localhost";
$username = "root";  // usuario 
$password = "";  // contraseña 
$dbname = "brawl_stars";  //  nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    echo "Conexión exitosa";
}

?>


