<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION["id_usuario"])) {
    // Si no está autenticado, redirigir a la página de inicio de sesión
    header("Location: index_usuario.html");
    exit();
}

// Configuración de la base de datos
$servername = "localhost";
$username = "id21368371_root";
$password = "Pitufos123.";
$database = "id21368371_bookhub";

try {
    $conexion = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener el nombre del libro desde la URL
    $nombre_libro = isset($_GET['nombre_libro']) ? $_GET['nombre_libro'] : null;

    if (!$nombre_libro) {
        echo "Error: No se proporcionó el nombre del libro.";
        exit();
    }

    // Obtener información del préstamo
    $stmt_prestamo = $conexion->prepare("SELECT * FROM prestamo WHERE nombre_libro = :nombre_libro AND penalizacion = 0 LIMIT 1");
    $stmt_prestamo->bindParam(':nombre_libro', $nombre_libro);
    $stmt_prestamo->execute();
    $prestamo = $stmt_prestamo->fetch(PDO::FETCH_ASSOC);

    if ($prestamo) {
        // Obtener el ID del libro
        $id_libro = $prestamo['id_libro'];
       /* if (!$id_libro) {
        echo "Error: No se proporcionó el id del libro.";
        exit();
        }*/
        // Eliminar el registro del libro devuelto utilizando el nombre del libro
        $stmt_eliminar_prestamo = $conexion->prepare("DELETE FROM prestamo WHERE nombre_libro = :nombre_libro AND penalizacion = 0 LIMIT 1");
        $stmt_eliminar_prestamo->bindParam(':nombre_libro', $nombre_libro);
        $stmt_eliminar_prestamo->execute();

        // Incrementar en 1 la cantidad disponible del libro devuelto
        $stmt_actualizar_libro = $conexion->prepare("UPDATE libro SET cant_disp = cant_disp + 1 WHERE id_libro = :id_libro");
        $stmt_actualizar_libro->bindParam(':id_libro', $id_libro);
        $stmt_actualizar_libro->execute();

        // Decrementar en 1 la cantidad de libros prestados del usuario
        $stmt_actualizar_usuario = $conexion->prepare("UPDATE usuarios SET cant_libros = cant_libros - 1 WHERE id_usuario = :id_usuario");
        $stmt_actualizar_usuario->bindParam(':id_usuario', $_SESSION["id_usuario"]);
        $stmt_actualizar_usuario->execute();

        // Redirigir al perfil del usuario
        header("Location: perfil_usuario.php");
        exit();
    } else {
        echo "No se encontró un préstamo activo para este libro.";
    }
} catch (PDOException $e) {
    echo "Error en la conexión a la base de datos: " . $e->getMessage();
    exit();
}
?>

