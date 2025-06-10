<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Datos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .card {
      border-radius: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    }
    .table-responsive {
      overflow-x: auto;
    }
    .btn-primary {
      background-color: #6c757d;
      border-color: #6c757d;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #5a6268;
      border-color: #5a6268;
      transform: translateY(-2px);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }
    .home-icon {
      position: absolute;
      font-size: 24px;
      top: 10px;
      left: 10px;
      color: black;
    }
    .home-icon:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card p-4">
          <a href="index.html" class="home-icon"><i class="fas fa-home"></i></a>
          <div class="card-header bg-transparent mb-4">
            <h3 class="text-center">
              <i class="fas fa-database"></i> Gestión de Datos
            </h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Número de Póliza</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
require_once 'config.php'; // Incluye el archivo de configuración
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                  if ($conexion->connect_error) {
                    die("Error de conexión: " . $conexion->connect_error);
                  }

                  $sql = "SELECT * FROM Polizas";
                  $resultado = $conexion->query($sql);

                  // Mostrar los datos en la tabla
                  if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $fila["NumPoliza"] . "</td>";
echo "<td>" . date('d/m/Y', strtotime($fila["Fecha"])) . "</td>";
                      echo "<td>" . $fila["Descripcion"] . "</td>";
                      echo "<td>
                              <a href='actualizarPartidas.php?id=" . $fila["NumPoliza"] . "' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i></a>
                              <a href='borrarPolizas.php?id=" . $fila["NumPoliza"] . "' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a>
                            </td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='4'>No hay datos disponibles</td></tr>";
                  }

                  $conexion->close();
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
