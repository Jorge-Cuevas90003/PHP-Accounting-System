<?php
require_once 'config.php'; // Incluye el archivo de configuración
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el ID del registro a editar
$id = $_POST["id"];

$sql = "SELECT * FROM cuentas WHERE NumCuenta = $id";
$resultado = $conexion->query($sql);

// Verificar si se encontró el registro
if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "No se encontró el registro.";
    exit;
}

// Manejar el envío del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $NumCuenta = $_POST["NumCuenta"];
    $NombreCuenta = $_POST["NombreCuenta"];
    $Tipo = $_POST["Tipo"];

    $sql = "UPDATE cuentas SET NumCuenta='$NumCuenta', NombreCuenta='$NombreCuenta', Tipo='$Tipo' WHERE NumCuenta=$id";

    if ($conexion->query($sql) === TRUE) {
          echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éxito!</title>
    <style>
        body {
            background-color: #f8f9fa; /* Light background */
            font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            display: flex; /* Center content vertically */
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Fill viewport height */
        }

        .container {
            text-align: center;
            background-color: #fff; /* White container background */
            border-radius: 10px; /* Rounded corners */
            padding: 30px; /* Spacing for content */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        .alert-success {
            color: #3c763d; /* Green text color */
            background-color: #dff0d8; /* Light green background */
            border-color: #d6e9c6; /* Green border */
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #38a3a5; /* Teal button background */
            border-color: #38a3a5;
            color: #fff; /* White text */
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            transition: all 0.2s ease-in-out; /* Smooth transition */
        }

        .btn-primary:hover {
            background-color: #2980b9; /* Darker teal on hover */
            border-color: #2980b9;
            transform: translateY(2px); /* Slight bounce on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="alert alert-success" role="alert">
Registro actualizado correctamente.        </div>
        <div class="text-center">
            <a href="CRUD2.php" class="btn btn-primary">Regresar al Inicio</a>
        </div>
    </div>
</body>
</html>';
    } else {
        echo "Error al actualizar el registro: " . $conexion->error;
    }
}
$conexion->close();
?>