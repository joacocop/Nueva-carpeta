<?php
session_start();

include("conexion.php");
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Primero verifica si el usuario es un usuario
    $query_usuario = $conn->prepare('SELECT id, email, password FROM usuarios WHERE email = ?');
    $query_usuario->bind_param('s', $email);
    $query_usuario->execute();
    $result_usuario = $query_usuario->get_result();
    $user_usuario = $result_usuario->fetch_assoc();

    // Si el usuario es un usuario y la contraseña es correcta
    if ($user_usuario && $password == $user_usuario['password']) {
        $_SESSION['id'] = $user_usuario['id'];
        header("Location: comentarios.php"); // Redirige a la página de usuarios
        exit();
    }
} else {
    echo "<script>alert('Por favor, complete todos los campos');window.history.back();</script>";
}
?>