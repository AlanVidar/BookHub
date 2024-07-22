<html>
<head>
    <link rel="stylesheet" href="muestras.css">
    <link rel="stylesheet" href="menu.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</head>
<body>

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

    // Consulta para obtener la lista de libros
    $stmt_libros = $conexion->query("SELECT * FROM libro");
    $libros = $stmt_libros->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error en la conexión a la base de datos: " . $e->getMessage();
    exit();
}

?>
<div class="fondo">
    <header>
        <h1> LIBROS</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index_usuario.html">Inicio</a></li>
            <li><a href="perfil_usuario.php">Mis Libros</a></li>
        </ul>
    </nav>

    <div class="container mt-3">
        <form class="d-flex">
            <input class="form-control me-2 light-table-filter" data-table="table-id" type="text"
                   placeholder="Buscar libro">
            <hr>
        </form>
    </div>

    <table class="table-id container mt-3">
        <thead>
        <tr>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Year</th>
            <th>Autor</th>
            <th>Genero</th>
            <th>Editorial</th>
            <th>Estado</th>
            <th>CantidadDisponible</th>
            <th>ID_Libro</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($libros as $libro) : ?>
            <tr>
                <td><?php echo $libro['titulo'] ?></td>
                <td><?php echo $libro['descripcion'] ?></td>
                <td><?php echo $libro['year'] ?></td>
                <td><?php echo $libro['autor'] ?></td>
                <td><?php echo $libro['genero'] ?></td>
                <td><?php echo $libro['editorial'] ?></td>
                <td><?php echo $libro['estado'] ?></td>
                <td><?php echo $libro['cant_disp'] ?></td>
                <td><?php echo $libro['id_libro'] ?></td>
                <td>
                    <form action="pedir_libro.php" method="get">
                        <input type="hidden" name="id_libro" value="<?php echo $libro['id_libro'] ?>">
                        <button type="submit" class="btn btn-primary">PEDIR</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>

</html>