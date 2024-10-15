<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../html/inicio.html"); // Redirigir a la página de inicio de sesión y registro
    exit();
}

// Consulta para obtener todas las imágenes
$sql_imagenes = "SELECT imagenes.descripcion, imagenes.ruta_imagen, usuarios.nombre, usuarios.apellido 
                 FROM imagenes 
                 JOIN usuarios ON imagenes.id = usuarios.id"; // Asegúrate de que el nombre de la tabla y la columna ID sea correcta
$stmt_imagenes = $conn->prepare($sql_imagenes);
$stmt_imagenes->execute();
$result = $stmt_imagenes->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/comentarios.css">
    <title>Comentarios</title>
</head>
<body>
<div class="pri">  
<h1>¡Bienvenido al foro!</h1>
    <section>
        
        <h3>¿Quieres mostrar tu logro?</h3>
        <form action="subir_apartado.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="img">Seleciona tu imagen:</label>
                <input id="imagen" type="file" name="imagen" required>
            </div>
            <div>
                <label for="descripcion">Descripcion:</label>
                <input id="descripcion" type="text" name="descripcion" required>
            </div>
            <div>
                <button type="submit" class="btn">Subir</button>
            </div>
        </form>
    </section>
    <section>
        <h3>Publicaciones:</h3>
        <?php
            if ($result->num_rows > 0) {
                // Mostrar cada imagen
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="comment">';
                    echo '<h4>' . htmlspecialchars($row['nombre'] . ' ' . $row['apellido']) . '</h4>'; // Mostrar el nombre del usuario
                    echo '<img src="' . htmlspecialchars($row['ruta_imagen']) . '" alt="Imagen" />'; // Mostrar la imagen
                    echo '<p>' . htmlspecialchars($row['descripcion']) . '</p>'; // Mostrar la descripción
                    echo '</div><hr>';
                }
            } else {
                echo "<p>No hay imágenes disponibles.</p>";
            }
            $stmt_imagenes->close();
            $conn->close();
            ?>
</body>
</html>

