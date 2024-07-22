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

    // Obtener información del usuario
    $id_usuario = $_SESSION["id_usuario"];
    // Obtener los préstamos asociados al usuario actual
    $stmt_prestamos = $conexion->prepare("SELECT * FROM prestamo WHERE nombre_usuario = :nombre_usuario");
    $stmt_prestamos->bindParam(':nombre_usuario', $_SESSION["nombre"]);
    $stmt_prestamos->execute();
    $prestamos = $stmt_prestamos->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error en la conexión a la base de datos: " . $e->getMessage();
}
?>

<!-- perfil_usuario.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css"> <!-- Enlaza tu archivo de estilos CSS si es necesario -->
    <link rel="stylesheet" href="catalogophp.css">
    <link rel="stylesheet" href="menu.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <title>Perfil de Usuario</title>
</head>
<body>

<header>
    <h1>Perfil de Usuario</h1>
</header>
<nav>
    <ul>
        <li><a href="index_usuario.html">Inicio</a></li>
        <li><a href="catalogo_usuario2.0.php">Catalogo</a></li>
    </ul>
</nav>

<div class="container mt-3">
    <section id="info-usuario">
        <h2>Bienvenido, <?php echo $_SESSION["nombre"]; ?>.</h2>
        <p>ID de usuario: <?php echo $_SESSION["id_usuario"]; ?></p>
        <p>Rol: <?php echo $_SESSION["rol"]; ?></p>
        <p>Libros Maximos: 5</p>
        <!-- Puedes agregar más detalles del usuario aquí -->
    </section>
</div>

<div class="container mt-5">
    <!-- Dentro de la sección de libros pedidos -->
<!-- Dentro de la sección libros-pedidos en perfil_usuario.php -->

<section id="libros-pedidos">
    <h2>Libros Pedidos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID Libro</th>
                <th>Fecha inicio</th>
                <th>Fecha de entrega</th>
                <th>Acciones</th> <!-- Nueva columna para el botón de devolución -->
                <th>Situacion</th>
                
                <!-- Agrega más columnas según sea necesario -->
            </tr>
        </thead>
        <tbody>
          <!-- Dentro del bucle foreach en la sección de libros-pedidos en perfil_usuario.php -->

<?php foreach ($prestamos as $prestamo): ?>
    <tr>
        <td><?php echo $prestamo['id_libro']; ?></td>
        <td><?php echo $prestamo['tiempo_inicio']; ?></td>
        <td><?php echo $prestamo['tiempo_final']; ?></td>
        <td>
            <?php
            // Verifica si hay una penalización activa
            if ($prestamo['penalizacion'] == 0) {
                // Si no hay penalización, muestra el botón de devolución y detalles del libro
                echo '<a href="devolver_libro.php?nombre_libro=' . urlencode($prestamo['nombre_libro']) . '">Devolver</a>';
                echo ' | Libro a devolver: ' . $prestamo['nombre_libro'];

            } else {
                // Si hay penalización, muestra un mensaje o lo que consideres apropiado
                echo 'Penalización activa';
            }
            ?>
        </td>
        <td>
        <?php
        
                // Compara la fecha de entrega con la fecha actual
                $fecha_entrega = strtotime($prestamo['tiempo_final']);
                $fecha_actual = time();

                // Si la fecha de entrega es próxima, muestra una alerta
                if ($fecha_entrega - $fecha_actual <= 604800) { // 86400 segundos en un día
                    echo '<span style="color: red;"> ¡Alerta! La fecha de entrega está próxima.</span>';
                
                      // Si la fecha actual supera la fecha de entrega, actualiza la penalización
                if ($fecha_actual > $fecha_entrega) {
                    // Realiza el update en la base de datos
                    $stmt_actualizar_penalizacion = $conexion->prepare("UPDATE prestamo SET penalizacion = 1 WHERE id_libro = :id_libro");
                    $stmt_actualizar_penalizacion->bindParam(':id_libro', $prestamo['id_libro']);
                    $stmt_actualizar_penalizacion->execute();

                    // También puedes agregar otras acciones relacionadas con la penalización si es necesario
                }
                }
                
        ?>
        </td>
            
        
        <!-- Agrega más celdas según sea necesario -->
    </tr>
<?php endforeach; ?>

        </tbody>
    </table>
</section>


</div>

<!-- Más contenido de la página de perfil -->

</body>
</html>
