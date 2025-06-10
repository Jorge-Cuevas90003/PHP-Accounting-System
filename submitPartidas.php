<?php
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numPoliza = $_POST["numPoliza"];
    $fecha = $_POST["fecha"];
    $descripcion = $_POST["descripcion"];
    $cuentaHaber = $_POST["cuentaHaber"];
    $cuentaDebe = $_POST["cuentaDebe"];
    $valorHaber = $_POST["valorHaber"];
    $valorDebe = $_POST["valorDebe"];
    
    // Verifica que el valor del debe sea igual al valor del haber
    if ($valorHaber != $valorDebe) {
        echo "El valor del debe debe ser igual al valor del haber.";
        exit;
    }
    
require_once 'config.php'; // Incluye el archivo de configuración
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }
    
    // Insertar datos en la tabla Polizas
    $queryPolizas = "INSERT INTO Polizas (NumPoliza, Fecha, Descripcion) VALUES ('$numPoliza', '$fecha', '$descripcion')";
    if ($conexion->query($queryPolizas) === TRUE) {
    } else {
        echo "Error al ingresar datos en la tabla Polizas: " . $conexion->error . "<br>";
    }
    
    // Insertar datos en la tabla DetallePoliza
    $queryDetallePoliza = "INSERT INTO DetallePoliza (NumPoliza, NumCuenta, DebeHaber, Valor) VALUES ('$numPoliza', '$cuentaHaber', 'H', '$valorHaber'), ('$numPoliza', '$cuentaDebe', 'D', '$valorDebe')";
    if ($conexion->query($queryDetallePoliza) === TRUE) {
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
            Datos ingresados correctamente
        </div>
        <div class="text-center">
            <a href="index.html" class="btn btn-primary">Regresar al Inicio</a>
        </div>
    </div>
</body>
</html>

';    } else {
        echo "Error al ingresar datos en la tabla DetallePoliza: " . $conexion->error . "<br>";
    }
    
    $conexion->close();
}
?>
