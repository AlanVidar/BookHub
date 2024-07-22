<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index_usuario.html");
    exit();
}

$id_libro = $_GET['id_libro'];
$id_usuario = $_SESSION["id_usuario"];

$servername = "localhost";
$username = "id21368371_root";
$password = "Pitufos123.";
$database = "id21368371_bookhub";

try {
    $conexion = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener información del libro
    $stmt_libro = $conexion->prepare("SELECT * FROM libro WHERE id_libro = :id_libro");
    $stmt_libro->bindParam(':id_libro', $id_libro);
    $stmt_libro->execute();
    $info_libro = $stmt_libro->fetch(PDO::FETCH_ASSOC);

    // Verificar si la clave 'tiempo_prestamo' existe
    $tiempo_prestamo = isset($info_libro['tiempo_prestamo']) ? $info_libro['tiempo_prestamo'] : 7; // Valor predeterminado de 7 días

    // Verificar si hay disponibilidad del libro
    $cantidad_disponible = $info_libro['cant_disp'];
    if ($cantidad_disponible <= 0) {
        echo "<script language='JavaScript'>
            alert('No hay disponibilidad.');
            window.location.href = 'catalogo_usuario2.0.php'; // Cambia 'catalogo.php' por la URL de tu catálogo
          </script>";
        exit();
    }

    // Verificar si el usuario ya tiene un préstamo para este libro
    $stmt_verificar_prestamo = $conexion->prepare("SELECT * FROM prestamo WHERE nombre_usuario = :nombre_usuario AND nombre_libro = :nombre_libro");
    $stmt_verificar_prestamo->bindParam(':nombre_usuario', $_SESSION["nombre"]);
    $stmt_verificar_prestamo->bindParam(':nombre_libro', $info_libro['titulo']);
    $stmt_verificar_prestamo->execute();

    if ($stmt_verificar_prestamo->rowCount() > 0) {
        // El usuario ya tiene un préstamo para este libro
        echo "<script language='JavaScript'>
            alert('Ya has pedido este libro anteriormente.');
            window.location.href = 'catalogo_usuario2.0.php'; // Cambia 'catalogo.php' por la URL de tu catálogo
          </script>";
        exit();
    }

    // Verificar la cantidad máxima de libros permitida por el usuario
    $stmt_cantidad_libros = $conexion->prepare("SELECT cant_libros FROM usuarios WHERE id_usuario = :id_usuario");
    $stmt_cantidad_libros->bindParam(':id_usuario', $id_usuario);
    $stmt_cantidad_libros->execute();
    $cantidad_libros_usuario = $stmt_cantidad_libros->fetchColumn();

    if ($cantidad_libros_usuario >= 6) {
        echo "<script language='JavaScript'>
            alert('Libros maximos prestados.');
            window.location.href = 'catalogo_usuario2.0.php'; // Cambia 'catalogo.php' por la URL de tu catálogo
          </script>";
        exit();
    }

// Calcular la fecha de finalización del préstamo
$fecha_fin_prestamo = date('Y-m-d H:i:s', strtotime("+" . $tiempo_prestamo . " days"));

// Calcular el tiempo restante (en segundos) desde ahora hasta la fecha de finalización
$tiempo_restante_segundos = strtotime($fecha_fin_prestamo) - time();

// Establecer la penalización inicial
$penalizacion_inicial = 0;

// Insertar un nuevo registro en la tabla de préstamos
$stmt_prestamo = $conexion->prepare("INSERT INTO prestamo (id_prestamo, id_libro, tiempo_inicio, tiempo_final, nombre_libro, penalizacion, nombre_usuario, tiempo_restante, tiempo_prestamo) VALUES (:id_prestamo, :id_libro, NOW(), :fecha_fin_prestamo, :nombre_libro, :penalizacion_inicial, :nombre_usuario, :tiempo_restante_segundos, :tiempo_prestamo)");
$stmt_prestamo->bindParam(':id_prestamo', $id_usuario);
$stmt_prestamo->bindParam(':id_libro', $id_libro);
$stmt_prestamo->bindParam(':fecha_fin_prestamo', $fecha_fin_prestamo);
$stmt_prestamo->bindParam(':nombre_libro', $info_libro['titulo']);
$stmt_prestamo->bindParam(':penalizacion_inicial', $penalizacion_inicial);
$stmt_prestamo->bindParam(':nombre_usuario', $_SESSION["nombre"]);
$stmt_prestamo->bindParam(':tiempo_restante_segundos', $tiempo_restante_segundos);
$stmt_prestamo->bindParam(':tiempo_prestamo', $tiempo_prestamo);
$stmt_prestamo->execute();

// Insertar un nuevo registro en la tabla de préstamos
$stmt_prestamo = $conexion->prepare("INSERT INTO historial_prestamo (id_prestamo, id_libro, tiempo_inicio, tiempo_final, nombre_libro, penalizacion, nombre_usuario, tiempo_restante, tiempo_prestamo) VALUES (:id_prestamo, :id_libro, NOW(), :fecha_fin_prestamo, :nombre_libro, :penalizacion_inicial, :nombre_usuario, :tiempo_restante_segundos, :tiempo_prestamo)");
$stmt_prestamo->bindParam(':id_prestamo', $id_usuario);
$stmt_prestamo->bindParam(':id_libro', $id_libro);
$stmt_prestamo->bindParam(':fecha_fin_prestamo', $fecha_fin_prestamo);
$stmt_prestamo->bindParam(':nombre_libro', $info_libro['titulo']);
$stmt_prestamo->bindParam(':penalizacion_inicial', $penalizacion_inicial);
$stmt_prestamo->bindParam(':nombre_usuario', $_SESSION["nombre"]);
$stmt_prestamo->bindParam(':tiempo_restante_segundos', $tiempo_restante_segundos);
$stmt_prestamo->bindParam(':tiempo_prestamo', $tiempo_prestamo);
$stmt_prestamo->execute();

    // Actualizar la cantidad disponible del libro
    $stmt_actualizar_libro = $conexion->prepare("UPDATE libro SET cant_disp = cant_disp - 1 WHERE id_libro = :id_libro");
    $stmt_actualizar_libro->bindParam(':id_libro', $id_libro);
    $stmt_actualizar_libro->execute();

    // Incrementar la cantidad de libros prestados por el usuario
    $stmt_incrementar_cantidad_libros = $conexion->prepare("UPDATE usuarios SET cant_libros = cant_libros + 1 WHERE id_usuario = :id_usuario");
    $stmt_incrementar_cantidad_libros->bindParam(':id_usuario', $id_usuario);
    $stmt_incrementar_cantidad_libros->execute();

    header("Location: perfil_usuario.php");
    exit();
} catch (PDOException $e) {
    echo "Error en la conexión a la base de datos: " . $e->getMessage();
    exit();
}
?>
