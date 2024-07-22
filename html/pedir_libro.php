<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["id_usuario"])) {
    header("Location: index_usuario.html");
    exit();
}

try {
    // Agrega la lógica para conectar a la base de datos
    $servername = "localhost";
    $username = "id21368371_root";
    $password = "Pitufos123.";
    $database = "id21368371_bookhub";

    $conexion = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recibe el ID del libro desde la solicitud
    $id_libro = isset($_GET['id_libro']) ? $_GET['id_libro'] : null;

    if (!$id_libro) {
        throw new Exception("ID de libro no proporcionado");
    }

    // Realiza la actualización en la base de datos
    $stmt_actualizar_libro = $conexion->prepare("UPDATE libro SET cant_disp = cant_disp - 1 WHERE id_libro = :id_libro");
    $stmt_actualizar_libro->bindParam(':id_libro', $id_libro);
    $stmt_actualizar_libro->execute();

    // Agrega lógica adicional según tus necesidades

    // Redirige a la página de perfil con un mensaje
    header("Location: perfil.php?libro_pedido=1");
    exit();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
