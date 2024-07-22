<html>
<link rel="stylesheet" href="bajas.css">
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
    
    echo "Conexión exitosa"; // Este mensaje se mostrará si la conexión se establece correctamente
} catch (PDOException $e) {
    die("Conexión fallida: " . $e->getMessage());
}
$id=$_GET['id_libro'];
$sql="delete from libro where id_libro=$id";
$stmt = $conexion->prepare($sql);
$resultado = $stmt->execute();

if ($resultado) {
    echo "<script language='JavaScript'>
            alert('Los datos fueron actualizados');
            window.location.href = 'muestras.php';
          </script>";
} else {
    echo "Error al ejecutar la consulta: " . implode(" ", $stmt->errorInfo());
}

?>



</body>
</html>