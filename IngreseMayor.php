<!DOCTYPE html>
<html lang="es">

<html>
<head>
      <meta charset="UTF-8">
    <title>Reporte de Partida de Diario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .search-form {
            margin-bottom: 30px;
        }
        .report-table {
            border-collapse: collapse;
            width: 100%;
        }
        .report-table th, .report-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .report-table tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="report-header">
            <h1>Reporte Mayor</h1>

        </div>
        <div class="search-form">
            <form method="post" action="reporteMayor.php">
                <div class="input-group mb-3">

 <div class="mb-3">
                            <label for="NumCuenta" class="form-label">Selecciona la cuenta</label>
                            <center>
                            <select class="form-select" id="NumCuenta" name="NumCuenta" required>
                                <?php
require_once 'config.php'; // Incluye el archivo de configuración
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);                                if ($conexion->connect_error) {
                                    die("Error en la conexión: " . $conexion->connect_error);
                                }
                                
                                $query = "SELECT NumCuenta, NombreCuenta FROM cuentas";
                                $result = $conexion->query($query);
                                
                                // Itera sobre los resultados y muestra las opciones de la lista desplegable
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['NumCuenta'] . "'>" . $row['NombreCuenta'] . "</option>";
                                }
                                ?>
                            </select></center>
                        </div>

                                            <button class="btn btn-primary" type="submit" style="margin-left: 10px;">Buscar</button>

                </div>
            </form>
        </div>
    
    </div>
</body>
</html>