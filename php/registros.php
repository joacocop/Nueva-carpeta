<?php
// Incluir el archivo de conexión
include("../php/conexion.php");


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "Datos recibidos: ";
    print_r($_POST);  // Esto mostrará los datos que llegan desde el formulario

}


// Verificar si se enviaron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Encriptar la contraseña

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO usuarios (nombre, apellido, fecha_nacimiento, telefono, direccion, email, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nombre, $apellido, $fecha_nacimiento, $telefono, $direccion, $email, $password);
    
    if ($stmt->execute()) {
        echo "Registro exitoso";
        // Redirigir a una página de éxito si deseas
        header("Location: ../index.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>
