<?php
require_once 'config.php'; // Incluye el archivo de configuración
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener todas las pólizas
$query = "SELECT p.NumPoliza, p.Fecha, p.Descripcion, 
                 SUM(CASE WHEN dp.DebeHaber = 'D' THEN dp.Valor ELSE 0 END) AS TotalDebe,
                 SUM(CASE WHEN dp.DebeHaber = 'H' THEN dp.Valor ELSE 0 END) AS TotalHaber
          FROM Polizas p
          INNER JOIN DetallePoliza dp ON p.NumPoliza = dp.NumPoliza
          GROUP BY p.NumPoliza
          ORDER BY p.NumPoliza";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Mostrar el encabezado del reporte
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

    // Iterar sobre cada póliza
    while ($row = $result->fetch_assoc()) {
        $numPoliza = $row['NumPoliza'];
        $fecha = date('d/m/Y', strtotime($row['Fecha']));
        $descripcion = $row['Descripcion'];
        $totalDebe = $row['TotalDebe'];
        $totalHaber = $row['TotalHaber'];

        // Mostrar la información de la póliza
        echo '<div class="poliza-container">';
        echo '<div class="poliza-header">';
        echo '<h3>Póliza #' . $numPoliza . '</h3>';
        echo '<p>' . $fecha . '</p>';
        echo '<p>' . $descripcion . '</p>';
        echo '</div>';

        // Consulta para obtener los detalles de la póliza actual
        $detalleQuery = "SELECT c.NombreCuenta, c.Tipo, dp.DebeHaber, dp.Valor
                         FROM DetallePoliza dp
                         INNER JOIN Cuentas c ON dp.NumCuenta = c.NumCuenta
                         WHERE dp.NumPoliza = $numPoliza";

        $detalleResult = $conn->query($detalleQuery);

        if ($detalleResult->num_rows > 0) {
            // Mostrar la tabla de detalles de la póliza
            echo '<table class="report-table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Cuenta</th>';
            echo '<th>Tipo</th>';
            echo '<th>Movimiento</th>';
            echo '<th>Valor</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Iterar sobre cada detalle de la póliza
            while ($detalleRow = $detalleResult->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $detalleRow['NombreCuenta'] . '</td>';
                echo '<td>' . $detalleRow['Tipo'] . '</td>';
                echo '<td>' . ($detalleRow['DebeHaber'] == 'D' ? 'Debe' : 'Haber') . '</td>';
                echo '<td>Q ' . number_format($detalleRow['Valor'], 2) . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p class="no-records">No se encontraron detalles para esta póliza</p>';
        }

        // Mostrar el total de la póliza
        echo '<div class="poliza-totales">';
        echo '<div class="total-debe">Total Debe: <span>Q ' . number_format($totalDebe, 2) . '</span></div>';
        echo '<div class="total-haber">Total Haber: <span>Q ' . number_format($totalHaber, 2) . '</span></div>';
        echo '</div>';

        echo '</div>'; // Cierre del contenedor de póliza
    }

    echo '</div>'; // Cierre del contenedor del reporte

} else {
    echo '<p class="no-records">No se encontraron pólizas</p>';
}

$conn->close();
?>


<div class="center">
    <a href="index.html" class="button">Regresar al Inicio</a>
</div>

<style>
    body {
        font-family: 'Montserrat', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }

    /* Contenedor del reporte */
    .report-container {
        max-width: 900px;
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

    /* Contenedor de póliza */
    .poliza-container {
        margin-bottom: 30px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .poliza-header {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }

    .poliza-header h3 {
        margin: 0;
        color: #333;
        font-size: 20px;
    }

    .poliza-header p {
        margin: 5px 0;
        color: #777;
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

    /* Totales de póliza */
    .poliza-totales {
        margin-top: 20px;
        padding-top: 10px;
        border-top: 1px solid #ddd;
    }

    .total {
        font-weight: bold;
    }

    .total span {
        color: #333;
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
