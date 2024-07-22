

<html>
<link rel="stylesheet" href="mod.css">
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
    
    $sql = "UPDATE libro SET titulo = :titulo, descripcion = :descripcion, year = :year, autor = :autor, genero = :genero, editorial = :editorial, estado = :estado, cant_disp = :cant_disp, id_libro = :id_libro WHERE id_libro = :id_libro";

    $stmt = $conexion->prepare($sql);
    
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':editorial', $editorial);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':cant_disp', $cant_disp);
    $stmt->bindParam(':id_libro', $id_libro);
    
    $resultado = $stmt->execute();
    
    if ($resultado) {
        echo "<script language='JavaScript'>
                alert('Los datos fueron actualizados');
                window.location.href = 'muestras.php';
              </script>";
    } else {
        echo "Error al ejecutar la consulta: " . implode(" ", $stmt->errorInfo());
    }
    
}else{

    $id=$_GET['id_libro'];
    $sql= "select * from libro where id_libro='".$id."'";
    $stmt = $conexion->prepare($sql);
    $resultado = $stmt->execute();

    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $titulo = $fila["titulo"];
    $descripcion = $fila["descripcion"];
    $year = $fila["year"];
    $autor = $fila["autor"];
    $genero = $fila["genero"];
    $editorial = $fila["editorial"];
    $estado = $fila["estado"];
    $cant_disp = $fila["cant_disp"];
    $id_libro = $fila["id_libro"];


?>
<div class="fondo">
    <header>
        <h1>Modificacion</h1>
    </header>
</div>
    <nav>
        <ul>
            <li><a href="index_sesion.html">Inicio</a></li>
            <li><a href="muestras.php">Catalogo</a></li>
            <li><a href="catalogo.php">Altas</a></li>

        </ul>
    </nav>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <label> Titulo</label>
            <input type="text" name="titulo" value="<?php echo $titulo; ?>"><br>
            <label> Descripcion</label>
            <input type="text" name="descripcion" value="<?php echo $descripcion; ?>"><br>
            <label> Year</label>
            <input type="text" name="year" value="<?php echo $year; ?>"><br>
            <label> Autor</label>
            <input type="text" name="autor" value="<?php echo $autor; ?>"><br>
            <label> Genero</label>
            <input type="text" name="genero" value="<?php echo $genero; ?>"><br>
            <label> Editorial</label>
            <input type="text" name="editorial" value="<?php echo $editorial; ?>"><br>
            <label> Estado</label>
            <input type="text" name="estado" value="<?php echo $estado; ?>"><br>
            <label> CantidadDisponible</label>
            <input type="text" name="cant_disp" value="<?php echo $cant_disp; ?>"><br>
            <!--<label> IDLibro</label>-->
            <input type="hidden" name="id_libro" value="<?php echo $id_libro; ?>"><br>
            
            <input type="submit" name="enviar"value="ACTUALIZAR">
            <a href="muestras.php" class="button">Regresar</a>

</form>
<?php
}
?>
</body>
</html>