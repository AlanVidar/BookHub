<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        /* Estilos CSS aquí */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            box-sizing: border-box;
        }
        form {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            width: 300px;
        }
        .input-container {
            margin-bottom: 10px;
        }
        .input-container label {
            display: block;
        }
        .input-container input[type="email"],
        .input-container input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .button-container {
            text-align: center;
        }
        .button-container button[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button-container button[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <form action="procesar_login.php" method="POST">
        <h2>Iniciar Sesión</h2>
        <div class="input-container">
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>
        </div>
        <div class="input-container">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="button-container">
            <button type="submit">Iniciar Sesión</button>
        </div>
    </form>
</body>
</html>

