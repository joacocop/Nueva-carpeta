<?php
require_once "conexion.php";
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION["id"])) {
    header("Location:../html/inicio.html"); // Redirigir a la página de inicio de sesión y registro
    exit();
}

$id = $_SESSION["id"];
$descripcion = $_POST["descripcion"];

// Verificar si se ha subido una imagen
if (isset($_FILES['imagen']) && $_FILES["imagen"]["error"] == 0) {
    // Información de la imagen
    $nombre_imagen = $_FILES["imagen"]["name"];
    $tipo_imagen = $_FILES["imagen"]["type"];
    $ruta_temporal = $_FILES["imagen"]["tmp_name"];
    $tamaño_imagen = $_FILES["imagen"]["size"];

    // Validar el tamaño de la imagen
    if ($tamaño_imagen > 2000000) { // 2 MB
        echo "<script>alert(\"El tamaño de la imagen no debe exceder 2 MB.\"); window.history.back();</script>";
        exit();
    }

    // Validar el tipo de archivo
    $tipos_permitidos = ["image/jpeg", "image/png", "image/gif"];
    if (!in_array($tipo_imagen, $tipos_permitidos)) {
        echo "<script>alert(\"Solo se permiten imágenes en formato JPG, PNG o GIF.\"); </script>";
        exit();
    }

    // Definir ruta donde guardar la imagen
    $ruta_destino = "imagenes_foro/" . uniqid() . "_" . $nombre_imagen;

    // Mover la imagen del directorio temporal al destino final
    if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
        // Insertar la imagen y la descripción en la tabla de imágenes
        $sql_insert_imagen = "INSERT INTO imagenes (id_imagen, descripcion, ruta_imagen)
                              VALUES (?, ?, ?)";
        $stmt_insert_imagen = $conn->prepare($sql_insert_imagen);
        $stmt_insert_imagen->bind_param("iss", $id, $descripcion, $ruta_destino);

        if ($stmt_insert_imagen->execute()) {
            echo "Imagen subida con éxito.";
            header("Location: foro.php");
        } else {
            echo "Error al subir la imagen: " . $stmt_insert_imagen->error;
        }
        $stmt_insert_imagen->close();
    } else {
        echo "Error al mover la imagen.";
    }
} else {
    echo "No se ha subido ninguna imagen.";
}

$conn->close();
?>