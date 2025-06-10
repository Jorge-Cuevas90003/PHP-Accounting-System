<?php
require_once 'config.php'; // Incluye el archivo de configuración
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el ID del registro a editar
$id = $_GET["id"];

$sql = "SELECT * FROM cuentas WHERE NumCuenta = $id";
$resultado = $conexion->query($sql);

// Verificar si se encontró el registro
if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "No se encontró el registro.";
    exit;
}


$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
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
        .form-control:focus {
            border-color: #6c757d;
            box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <div class="card-header bg-transparent mb-4">
                        <h3 class="text-center">
                            <i class="fas fa-edit"></i> Editar Registro
                        </h3>
                    </div>
                    <div class="card-body">
                    <form method="post" action="actualizar.php">
                            <div class="mb-3">
<!-- Campo oculto para enviar el id -->
    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <label for="NumCuenta" class="form-label">Número de Cuenta</label>
                                <input type="number" class="form-control" name="NumCuenta" id="NumCuenta" value="<?php echo $fila["NumCuenta"]; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="NombreCuenta" class="form-label">Nombre de Cuenta</label>
                                <input type="text" class="form-control" name="NombreCuenta" id="NombreCuenta" value="<?php echo $fila["NombreCuenta"]; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="Tipo" class="form-label">Tipo</label>
                                <select class="form-select" id="Tipo" name="Tipo" required>
                                    <option value="A" <?php if ($fila["Tipo"] == "A") echo "selected"; ?>>A</option>
                                    <option value="P" <?php if ($fila["Tipo"] == "P") echo "selected"; ?>>P</option>
                                    <option value="C" <?php if ($fila["Tipo"] == "C") echo "selected"; ?>>C</option>
                                    <option value="I" <?php if ($fila["Tipo"] == "I") echo "selected"; ?>>I</option>
                                    <option value="G" <?php if ($fila["Tipo"] == "G") echo "selected"; ?>>G</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist /js/bootstrap.bundle.min.js"></script>
</body>
</html>