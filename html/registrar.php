<?php
// Configuración de la base de datos
$servername = "localhost"; // Cambia esto al servidor de tu base de datos
$username = "id21368371_root"; // Cambia esto a tu nombre de usuario de la base de datos
$password = "Pitufos123."; // Cambia esto a tu contraseña de la base de datos
$database = "id21368371_bookhub"; // Cambia esto al nombre de tu base de datos

try {
    // Crear una conexión PDO
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

    // Configurar PDO para que lance excepciones en caso de errores
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los valores del formulario
    $id_usuario = $_POST["id_usuario"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $rol = $_POST["rol"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $cant_libros = $_POST["cant_libros"];
    
    // Validar el correo electrónico (puedes agregar más validaciones según tus requisitos)
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Correo electrónico no válido");
    }

    // Preparar la consulta SQL
    $sql = "INSERT INTO usuarios (id_usuario, nombre, correo, rol, cant_libros, password) 
            VALUES (:id_usuario, :nombre, :correo, :rol, :cant_libros, :password)";
    
    // Preparar la sentencia PDO
    $stmt = $conn->prepare($sql);
    
    // Vincular parámetros
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':rol', $rol);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':cant_libros', $cant_libros);


    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo "Cuenta creada con éxito.";
    } else {
        echo "Error al crear la cuenta.";
    }
} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
