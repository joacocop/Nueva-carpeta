<?php
session_start();

include("conexion.php");
// Obtener datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql_check_email = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql_check_email);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('El email ya está registrado en el sistema.'); window.history.back();</script>"; // Alerta si el email ya existe
} else {
    // Si el email no está registrado, insertar el nuevo usuario
    $sql_insert = "INSERT INTO usuarios (nombre, apellido, fecha_nacimiento, telefono, direccion, email, password)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssssssss", $nombre, $apellido, $fecha_nacimiento, $telefono, $direccion, $email, $password);
    if ($stmt_insert->execute()) {
        $nuevo_id = $stmt_insert->insert_id; // Guardar la ID del nuevo usuario en la sesión
        $_SESSION['id'] = $nuevo_id;
        header("Location: comentarios.php");
        exit();
    } else {
        echo "Error: " . $stmt_insert->error;
    }

    $stmt_insert->close();
}

$stmt->close();
$conn->close();
?>