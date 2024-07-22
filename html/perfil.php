<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["id_usuario"])) {
    header("Location: index_usuario.html");
    exit();
}

// Muestra el mensaje si se ha pedido un libro
$libro_pedido = isset($_GET['libro_pedido']) ? $_GET['libro_pedido'] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>

    <h1>LIBRO REGISTRADO</h1>

    <?php
    if ($libro_pedido) {
        echo "<p>¡Libro pedido con éxito!</p>";
    }
    ?>

    <!-- Botón para regresar a la página anterior -->
    <button onclick="history.back()">Regresar</button>

    <!-- Resto del contenido del perfil -->

</body>
</html>
