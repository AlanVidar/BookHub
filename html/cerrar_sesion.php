<?php
// Cerrar la sesión del usuario
session_start();
session_destroy();
header("Location: index.html"); // Redirigir al inicio del sitio web
?>