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
$servername = "localhost"; // Cambia esto al servidor de tu base de datos
$username = "id21368371_root"; // Cambia esto a tu nombre de usuario de la base de datos
$password = "Pitufos123."; // Cambia esto a tu contraseña de la base de datos
$database = "id21368371_bookhub"; // Cambia esto al nombre de tu base de datos

try {
// Crear una conexión utilizando PDO
$conexion = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

// Establecer el modo de error para PDO en excepciones
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//echo "Conexión exitosa"; // Este mensaje se mostrará si la conexión se establece correctamente
} catch (PDOException $e) {
die("Conexión fallida: " . $e->getMessage());
}

$sql="select * from libro";

$stmt = $conexion->prepare($sql);
$resultado = $stmt->execute();

?>
<div class="fondo">
<header>
<h1> LIBROS</h1>    
</header>

<nav>
        <ul>
            <li><a href="index_sesion.html">Inicio</a></li>
            <li><a href="muestras.php">Catalogo</a></li>
            <li><a href="catalogo.php">Altas</a></li>
            <li><a href="listar_libros.php">Ver Lista de Libros</a><li>
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
    <thread>
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
    </thread>
    <tbody>
        <?php
        while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
            ?>
        <tr>
            <td><?php echo $fila['titulo']?></td>
            <td><?php echo $fila['descripcion']?></td>
            <td><?php echo $fila['year']?></td>
            <td><?php echo $fila['autor']?></td>
            <td><?php echo $fila['genero']?></td>
            <td><?php echo $fila['editorial']?></td>
            <td><?php echo $fila['estado']?></td>
            <td><?php echo $fila['cant_disp']?></td>
            <td><?php echo $fila['id_libro']?></td>
            <td>
                <?php echo "<a href ='mod.php?id_libro=".$fila['id_libro']."'>Editar</a>"; ?> ||
                <?php echo "<a href='bajas.php?id_libro=".$fila['id_libro']."'>ELIMINAR</a>"; ?>
            </td>
        </tr>
        <?php
        }
        ?>

    </tbody>
</table>
</table>

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
