
<html>
<link rel="stylesheet" href="catalogophp.css">
<link rel="stylesheet" href="menu.css">

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
 

    if(isset($_POST['enviar'])){
        
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $year = $_POST['year'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $editorial = $_POST['editorial'];
    $estado = $_POST['estado'];
    $cant_disp = $_POST['cant_disp'];
    $id_libro = $_POST['id_libro'];
// Consultar si el id_libro ya existe
    $consulta_existencia = "SELECT COUNT(*) FROM libro WHERE id_libro = :id_libro";
    $stmt_existencia = $conexion->prepare($consulta_existencia);
    $stmt_existencia->bindParam(':id_libro', $id_libro);
    $stmt_existencia->execute();
    $libro_existente = $stmt_existencia->fetchColumn();

    if ($libro_existente > 0) {
        echo "<script language= 'JavaScript'>
                alert ('El ID del libro ya está en uso. Por favor, elige otro ID.');
            </script>";
    } else {

    // Consulta SQL utilizando PDO
    $sql = "INSERT INTO libro (titulo, descripcion, year, autor, genero, editorial, estado, cant_disp, id_libro) 
            VALUES (:titulo, :descripcion, :year, :autor, :genero, :editorial, :estado, :cant_disp, :id_libro)";

    $stmt = $conexion->prepare($sql);

    // Enlazar parámetros
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':editorial', $editorial);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':cant_disp', $cant_disp);
    $stmt->bindParam(':id_libro', $id_libro);


    // Ejecutar la consulta
    $resultado = $stmt->execute();

    if($resultado){
        echo "<script language= 'JavaScript'>
            alert ('Los datos fueron ingresados');
            window.location.href = 'muestras.php';
        </script>";
    } else {
        echo "Error al ejecutar la consulta: " . implode(" ", $stmt->errorInfo());
    }

        if ($resultado) {
            echo "<script language= 'JavaScript'>
                alert ('Los datos fueron ingresados');
                window.location.href = 'muestras.php';
            </script>";
        } else {
            echo "Error al ejecutar la consulta: " . implode(" ", $stmt->errorInfo());
        }
    }


    }else

    ?>
    <div class="fondo">
        <header>
                <h1>Agregar nuevo libro</h1>
        </header>
    </div>
    
    <nav>
        <ul>
            <li><a href="index_sesion.html">Inicio</a></li>
            <li><a href="muestras.php">Catalogo</a></li>
        </ul>
    </nav>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post"">
            <label> Titulo</label>
            <input type="text" name="titulo"><br>
            <label> Descripcion</label>
            <input type="text" name="descripcion"><br>
            <label> Year</label>
            <input type="text" name="year"><br>
            <label> Autor</label>
            <input type="text" name="autor"><br>
            <label> Genero</label>
            <input type="text" name="genero"><br>
            <label> Editorial</label>
            <input type="text" name="editorial"><br>
            <label> Estado</label>
            <input type="text" name="estado"><br>
            <label> CantidadDisponible</label>
            <input type="text" name="cant_disp"><br>
            <label> IDLibro</label>
            <input type="text" name="id_libro"><br>

            <input type="submit" name="enviar"value="AGREGAR">


        </form>
    
    </body>

</html> 


