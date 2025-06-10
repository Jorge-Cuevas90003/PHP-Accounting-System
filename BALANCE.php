<?php
require_once 'config.php'; // Incluye el archivo de configuración
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener la lista de tipos de cuenta con datos
$sqlTiposCuenta = "SELECT DISTINCT Tipo FROM Cuentas INNER JOIN DetallePoliza ON Cuentas.NumCuenta = DetallePoliza.NumCuenta";
$resultadoTiposCuenta = $conexion->query($sqlTiposCuenta);

// Variable para almacenar el total general del haber y del debe
$totalHaberGeneral = 0;
$totalDebeGeneral = 0;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Balance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <div class="card-header bg-transparent mb-4">
                    <h3 class="text-center">Reporte de Balance</h3>
                    <h6 class="text-center">Contadores Galileanos</h6>
                </div>
                <div class="card-body">
                    <?php
                    // Iterar sobre cada tipo de cuenta
                    while ($filaTipoCuenta = $resultadoTiposCuenta->fetch_assoc()) {
                        $tipoCuentaAbreviado = $filaTipoCuenta['Tipo'];
                        
                        $tiposCuentaNombres = array(
                            'A' => 'Activo',
                            'P' => 'Pasivo',
                            'C' => 'Capital',
                            'I' => 'Ingreso',
                            'G' => 'Gasto'
                        );

                        $tipoCuentaNombre = $tiposCuentaNombres[$tipoCuentaAbreviado];

                        // Consulta para obtener las cuentas del tipo actual con datos
                        $sqlCuentas = "SELECT Cuentas.NumCuenta, Cuentas.NombreCuenta FROM Cuentas INNER JOIN DetallePoliza ON Cuentas.NumCuenta = DetallePoliza.NumCuenta WHERE Tipo = '$tipoCuentaAbreviado'";
                        $resultadoCuentas = $conexion->query($sqlCuentas);
// Verificar si la consulta fue exitosa
if (!$resultadoCuentas) {
    die("Error en la consulta SQL: " . $conexion->error);
}
                        // Si no hay cuentas para este tipo, continuamos con el siguiente tipo de cuenta
                        if ($resultadoCuentas->num_rows == 0) {
                            continue;
                        }

                        echo "<h4>$tipoCuentaNombre</h4>";
                        echo "<table class='table table-bordered'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Cuenta</th>";
                        echo "<th>Total Haber</th>";
                        echo "<th>Total Debe</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        // Variables para almacenar el total del haber y el total del debe por tipo de cuenta
                        $totalHaberTipoCuenta = 0;
                        $totalDebeTipoCuenta = 0;

                        // Iterar sobre las cuentas del tipo actual
                        while ($filaCuenta = $resultadoCuentas->fetch_assoc()) {
                            $numCuenta = $filaCuenta['NumCuenta'];
                            $nombreCuenta = $filaCuenta['NombreCuenta'];

                            // Consulta para obtener el total del haber por cuenta
                            $sqlTotalHaberCuenta = "SELECT SUM(Valor) AS TotalHaber FROM DetallePoliza WHERE NumCuenta = '$numCuenta' AND DebeHaber = 'H'";
                            $resultadoTotalHaberCuenta = $conexion->query($sqlTotalHaberCuenta);
                            $filaTotalHaberCuenta = $resultadoTotalHaberCuenta->fetch_assoc();
                            $totalHaberCuenta = $filaTotalHaberCuenta['TotalHaber'];

                            // Consulta para obtener el total del debe por cuenta
                            $sqlTotalDebeCuenta = "SELECT SUM(Valor) AS TotalDebe FROM DetallePoliza WHERE NumCuenta = '$numCuenta' AND DebeHaber = 'D'";
                            $resultadoTotalDebeCuenta = $conexion->query($sqlTotalDebeCuenta);
                            $filaTotalDebeCuenta = $resultadoTotalDebeCuenta->fetch_assoc();
                            $totalDebeCuenta = $filaTotalDebeCuenta['TotalDebe'];

                            echo "<tr>";
                            echo "<td>$nombreCuenta</td>";
                            echo "<td>$totalHaberCuenta</td>";
                            echo "<td>$totalDebeCuenta</td>";
                            echo "</tr>";

                            // Sumar al total del haber y del debe por tipo de cuenta
                            $totalHaberTipoCuenta += $totalHaberCuenta;
                            $totalDebeTipoCuenta += $totalDebeCuenta;
                        }

                        // Mostrar el total del haber y del debe por tipo de cuenta
                        echo "<tr>";
                        echo "<td>Total $tipoCuentaNombre</td>";
                        echo "<td>$totalHaberTipoCuenta Q</td>";
                        echo "<td>$totalDebeTipoCuenta Q</td>";
                        echo "</tr>";

                        echo "</tbody>";
                        echo "</table>";

                        // Sumar al total general del haber y del debe
                        $totalHaberGeneral += $totalHaberTipoCuenta;
                        $totalDebeGeneral += $totalDebeTipoCuenta;
                    }

                    // Mostrar el total general del haber y del debe
                    echo "<h4>Total General</h4>";
                    echo "<table class='table table-bordered'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Total Haber General</th>";
                    echo "<th>Total Debe General</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    echo "<tr>";
                    echo "<td>$totalHaberGeneral Q</td>";
                    echo "<td>$totalDebeGeneral Q</td>";
                    echo "</tr>";
                    echo "</tbody>";
                    echo "</table>";
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
<center>
<a href="index.html" class="btn btn-primary">Regresar al Inicio</a>
</center>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conexion->close();
?>
