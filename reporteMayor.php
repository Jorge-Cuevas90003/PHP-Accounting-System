<?php
require_once 'config.php'; // Incluye el archivo de configuración
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el ID del registro a editar
$id = $_POST["NumCuenta"];

$sql = "SELECT Polizas.NumPoliza, Polizas.Fecha, Polizas.Descripcion, DetallePoliza.NumCuenta, DetallePoliza.DebeHaber, DetallePoliza.Valor, Cuentas.NombreCuenta 
        FROM Polizas 
        INNER JOIN DetallePoliza ON Polizas.NumPoliza = DetallePoliza.NumPoliza
        INNER JOIN Cuentas ON DetallePoliza.NumCuenta = Cuentas.NumCuenta
        WHERE DetallePoliza.NumCuenta = $id";
$resultado = $conexion->query($sql);

// Verificar si se encontró el registro
if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "No se encontró el registro.";
    exit;
}

// Variables para almacenar el total del haber y el total del debe
$totalHaber = 0;
$totalDebe = 0;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Mayor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <div class="card-header bg-transparent mb-4">
                    <h3 class="text-center">Reporte Mayor</h3>
                    <h6 class="text-center">Contadores Galileanos</h6>
                </div>
                <div class="card-body">
                    <h5 class="mb-4">Cuenta Seleccionada: <?php echo $fila["NombreCuenta"]; ?></h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Número de Póliza</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Consulta para obtener los detalles de las pólizas relacionadas con la cuenta seleccionada
                            $sqlDetalles = "SELECT Polizas.NumPoliza, Polizas.Fecha, Polizas.Descripcion, DetallePoliza.DebeHaber, DetallePoliza.Valor 
                                            FROM Polizas 
                                            INNER JOIN DetallePoliza ON Polizas.NumPoliza = DetallePoliza.NumPoliza
                                            WHERE DetallePoliza.NumCuenta = {$fila['NumCuenta']}";
                            $resultadoDetalles = $conexion->query($sqlDetalles);

                            if ($resultadoDetalles->num_rows > 0) {
                                while ($detalle = $resultadoDetalles->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$detalle['NumPoliza']}</td>";
echo "<td>" . date('d/m/Y', strtotime($fila["Fecha"])) . "</td>";
                                    echo "<td>{$detalle['Descripcion']}</td>";
                                    echo "<td>{$detalle['DebeHaber']}</td>";
                                    echo "<td>{$detalle['Valor']} Q</td>";
                                    echo "</tr>";
                                    
                                    // Sumar al total del haber o del debe según corresponda
                                    if ($detalle['DebeHaber'] == 'H') {
                                        $totalHaber += $detalle['Valor'];
                                    } elseif ($detalle['DebeHaber'] == 'D') {
                                        $totalDebe += $detalle['Valor'];
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='5'>No hay detalles disponibles para esta cuenta.</td></tr>";
                            }

                            // Calcular el saldo
                            $saldo = $totalDebe - $totalHaber;
                            
                            ?>
                        </tbody>
                    </table>
                    <div>
                        <p>Total Haber: <?php echo $totalHaber." Q"; ?></p>
                        <p>Total Debe: <?php echo $totalDebe." Q"; ?></p>
                        <p>Saldo: <?php echo $saldo." Q"; ?></p>
                    </div>
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
