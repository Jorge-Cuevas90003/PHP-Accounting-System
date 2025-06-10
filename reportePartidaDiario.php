<?php
require_once 'config.php'; // Incluye el archivo de configuración
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para obtener el tipo de cuenta
function getTipoCuenta($tipo) {
    $tiposCuenta = array(
        'A' => 'Activo',
        'P' => 'Pasivo',
        'C' => 'Capital',
        'I' => 'Ingreso',
        'G' => 'Gasto'
    );
    return isset($tiposCuenta[$tipo]) ? $tiposCuenta[$tipo] : '';
}

// Verificar si se ha enviado un número de póliza específico o se deben mostrar todas
if (isset($_GET['numPoliza'])) {
    $numPoliza = $_GET['numPoliza'];
    $query = "SELECT p.NumPoliza, p.Fecha, p.Descripcion, c.NombreCuenta, c.Tipo, dp.DebeHaber, dp.Valor
              FROM Polizas p
              INNER JOIN DetallePoliza dp ON p.NumPoliza = dp.NumPoliza
              INNER JOIN Cuentas c ON dp.NumCuenta = c.NumCuenta
              WHERE p.NumPoliza = $numPoliza";
} else {
    $query = "SELECT p.NumPoliza, p.Fecha, p.Descripcion, c.NombreCuenta, c.Tipo, dp.DebeHaber, dp.Valor
              FROM Polizas p
              INNER JOIN DetallePoliza dp ON p.NumPoliza = dp.NumPoliza
              INNER JOIN Cuentas c ON dp.NumCuenta = c.NumCuenta";
}

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo '<div class="report-container">';
    echo '<header class="report-header">';
    echo '<h1 class="report-title">Reporte de Partida de Diario</h1>';
    echo '<div class="company-info">
            <h2>Contadores Galileanos</h2>
            <p>Calle Principal #123, Ciudad Guatemala</p>
            <p>Tel: (+502) 1123-4567</p>
            <p>contadores@galileanos.com</p>
          </div>';
    echo '</header>';
    echo '<table class="report-table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Póliza</th>';
    echo '<th>Fecha</th>';
    echo '<th>Descripción</th>';
    echo '<th>Cuenta</th>';
    echo '<th>Tipo</th>';
    echo '<th>Movimiento</th>';
    echo '<th>Valor</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    $totalDebe = 0;
    $totalHaber = 0;

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['NumPoliza'] . '</td>';
        echo '<td>' . date('d/m/Y', strtotime($row['Fecha'])) . '</td>';
        echo '<td>' . $row['Descripcion'] . '</td>';
        echo '<td>' . $row['NombreCuenta'] . '</td>';
        echo '<td>' . getTipoCuenta($row['Tipo']) . '</td>';
        echo '<td class="movimiento">' . ($row['DebeHaber'] == 'D' ? 'Debe' : 'Haber') . '</td>';
        echo '<td class="valor">' . number_format($row['Valor'], 2) . 'Q</td>';
        echo '</tr>';

        if ($row['DebeHaber'] == 'D') {
            $totalDebe += $row['Valor'];
        } else {
            $totalHaber += $row['Valor'];
        }
    }

    echo '</tbody>';
    echo '<tfoot>';
    echo '<tr>';
    echo '<th colspan="6" class="total-label">Total Debe:</th>';
    echo '<th class="total-valor">' . number_format($totalDebe, 2) . 'Q</th>';
    echo '</tr>';
    echo '<tr>';
    echo '<th colspan="6" class="total-label">Total Haber:</th>';
    echo '<th class="total-valor">' . number_format($totalHaber, 2) . 'Q</th>';
    echo '</tr>';
    echo '</tfoot>';
    echo '</table>';
    echo '</div>';

} else {
    echo '<p class="no-records">No se encontraron registros</p>';
}

$conn->close();
?>
<div class="center">
    <a href="index.html" class="button">Regresar al Inicio</a>
</div>
<style>
    /* Estilos generales */
    body {
        font-family: 'Montserrat', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }

    /* Contenedor del reporte */
    .report-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    /* Encabezado del reporte */
    .report-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 10px;
        border-bottom: 2px solid #333;
    }

    .report-title {
        color: #333;
        margin-bottom: 10px;
        font-size: 28px;
        font-weight: bold;
    }

    .company-info {
        color: #777;
        font-size: 14px;
    }

    /* Tabla del reporte */
    .report-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        overflow: hidden;
    }

    .report-table th,
    .report-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .report-table th {
        background-color: #333;
        color: #fff;
        font-weight: bold;
    }

    .report-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .report-table tbody tr:hover {
        background-color: #e6e6e6;
    }

    .report-table .movimiento {
        text-transform: uppercase;
        font-weight: bold;
    }

    .report-table .valor {
        text-align: right;
        font-weight: bold;
    }

    .report-table tfoot th {
        background-color: #f9f9f9;
        font-weight: bold;
    }

    .report-table .total-label {
                background-color: #333;

        text-align: right;
        padding-right: 30px;
    }

    .report-table .total-valor {
        background-color: #333;
        color: #fff;
        font-weight: bold;
    }

    /* Mensaje de "No hay registros" */
    .no-records {
        text-align: center;
        color: #777;
        font-style: italic;
        margin-top: 20px;
    }


.center {
    text-align: center;
    margin-top: 20px; /* Espacio superior para separar el botón del contenido */
}

.button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.button:hover {
    background-color: #0056b3;
}


</style>