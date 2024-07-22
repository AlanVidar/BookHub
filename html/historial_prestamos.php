<?php

// Configuración de la base de datos
$servername = "localhost";
$username = "id21368371_root";
$password = "Pitufos123.";
$database = "id21368371_bookhub";

try {
    // Crear una conexión utilizando PDO
    $conexion = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

    // Establecer el modo de error para PDO en excepciones
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener la lista de préstamos
    $stmt_prestamos = $conexion->query("SELECT * FROM prestamo");
    $prestamos = $stmt_prestamos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error en la conexión a la base de datos: " . $e->getMessage();
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="muestras.css">
    <link rel="stylesheet" href="menu.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <title>Historial de Préstamos</title>
</head>
<body>

<div class="fondo">
    <header>
        <h1> HISTORIAL DE PRÉSTAMOS</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index_sesion.html">Inicio</a></li>
            <li><a href="muestras.php">CATALOGO</a></li>
        </ul>
    </nav>

    <div class="container mt-3">
        <form class="d-flex">
<input class="form-control me-2 light-table-filter" data-table="table-id" type="text" placeholder="Buscar préstamo">
                   
            <hr>
        </form>
    </div>

<table class="table table-id container mt-3">
        <thead>
        <tr>
            <th>ID Préstamo</th>
            <th>ID Libro</th>
            <th>Tiempo Inicio</th>
            <th>Tiempo Final</th>
            <th>Nombre Libro</th>
            <th>Penalización</th>
            <th>Nombre Usuario</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($prestamos as $prestamo) : ?>
            <tr>
                <td><?php echo $prestamo['id_prestamo']; ?></td>
                <td><?php echo $prestamo['id_libro']; ?></td>
                <td><?php echo $prestamo['tiempo_inicio']; ?></td>
                <td><?php echo $prestamo['tiempo_final']; ?></td>
                <td><?php echo $prestamo['nombre_libro']; ?></td>
                <td><?php echo $prestamo['penalizacion']; ?></td>
                <td><?php echo $prestamo['nombre_usuario']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    (function(document) {
        var LightTableFilter = (function(Arr) {
            var _input;

            function _onInputEvent(e) {
                _input = e.target;
                var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
                Arr.forEach.call(tables, function(table) {
                    Arr.forEach.call(table.tBodies, function(tbody) {
                        Arr.forEach.call(tbody.rows, _filter);
                    });
                });
            }

            function _filter(row) {
                var text = row.textContent.toLowerCase(),
                    val = _input.value.toLowerCase();
                row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
            }

            return {
                init: function() {
                    var inputs = document.getElementsByClassName('light-table-filter');
                    Arr.forEach.call(inputs, function(input) {
                        input.addEventListener('input', _onInputEvent);
                    });
                }
            };
        })(Array.prototype);

        document.addEventListener('DOMContentLoaded', function() {
            LightTableFilter.init();
        });

    })(document);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js
