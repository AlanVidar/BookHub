<?php
session_start();
$servername = "localhost";
$username = "id21368371_root";
$password = "Pitufos123.";
$database = "id21368371_bookhub";

try {
    $conexion = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $correo = $_POST["correo"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM usuarios WHERE correo = :correo AND password = :password";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $usuario = $stmt->fetch();
            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["rol"] = $usuario["rol"];
            
           if ($usuario["rol"] == "administrador") {
                header("Location: index_sesion.html");
                 exit();
            } else {
                header("Location: index_usuario.html");
                 exit();
            }
            //header("Location: index_sesion.html"); // Redirigir al "index" después de iniciar sesión
            exit(); // Asegurarse de que el script se detenga después de la redirección
        } else {
            echo "Correo o contraseña incorrectos. <a href='formulario_login.html'>Volver al inicio de sesión</a>";
        }
    }
} catch (PDOException $e) {
    echo "Error en la conexión a la base de datos: " . $e->getMessage();
}
?>
