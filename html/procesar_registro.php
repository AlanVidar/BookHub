<?php
$servername = "localhost";
$username = "id21368371_root";
$password = "Pitufos123.";
$database = "id21368371_bookhub";

try {
    $conexion = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_usuario = $_POST["id_usuario"];
        $nombre = $_POST["nombre"];
        $correo = $_POST["correo"];
        $rol = $_POST["rol"];
        $password = $_POST["password"];
        $cant_libros = $_POST["cant_libros"];

        // Validar si el id_usuario ya existe
        $consulta_existencia_usuario = "SELECT COUNT(*) FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt_existencia_usuario = $conexion->prepare($consulta_existencia_usuario);
        $stmt_existencia_usuario->bindParam(':id_usuario', $id_usuario);
        $stmt_existencia_usuario->execute();
        $usuario_existente = $stmt_existencia_usuario->fetchColumn();

        // Validar si el correo ya está en uso
        $consulta_existencia_correo = "SELECT COUNT(*) FROM usuarios WHERE correo = :correo";
        $stmt_existencia_correo = $conexion->prepare($consulta_existencia_correo);
        $stmt_existencia_correo->bindParam(':correo', $correo);
        $stmt_existencia_correo->execute();
        $correo_existente = $stmt_existencia_correo->fetchColumn();

        if ($usuario_existente > 0) {
            echo "<script language= 'JavaScript'>
                    alert ('El ID del usuario ya está en uso. Por favor, elige otro ID.');
                    window.location.href = 'formulario_registro.html';
                </script>";
        } elseif ($correo_existente > 0) {
            echo "<script language= 'JavaScript'>
                    alert ('El correo ya está en uso. Por favor, elige otro correo.');
                    window.location.href = 'formulario_registro.html';
                </script>";
        } else {
            // Si el id_usuario y el correo no existen, proceder con la inserción
            $sql = "INSERT INTO usuarios (id_usuario, nombre, correo, rol, password, cant_libros) 
                    VALUES (:id_usuario, :nombre, :correo, :rol, :password, :cant_libros)";
            
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':cant_libros', $cant_libros);
            
            if ($stmt->execute()) {
                echo "<script language= 'JavaScript'>
                        alert ('Los datos fueron ingresados');
                        window.location.href = 'index.html';
                    </script>";
            } else {
                echo "Error al registrar usuario: " . $stmt->errorInfo()[2];
            }
        }
    }
} catch (PDOException $e) {
    echo "Error en la conexión a la base de datos: " . $e->getMessage();
}
?>
