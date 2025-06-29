<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de Datos</title>
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

        .animated-icon {
            animation: rotate 2s infinite linear;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .home-icon:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .home-icon {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 24px;
            color: black;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <a href="index.html" class="home-icon"><i class="fas fa-home"></i></a>
                <div class="card-header bg-transparent mb-4">
                    <h3 class="text-center">
                        <i class="fas fa-database animated-icon"></i> Ingreso de Datos
                    </h3>
                </div>
                <div class="card-body">
                    <form action="submitPartidas.php" method="post">
                        <div class="mb-3">
                            <label for="numPoliza" class="form-label">Número de Póliza</label>
                            <input type="number" class="form-control" name="numPoliza" id="numPoliza" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" required>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="cuentaHaber" class="form-label">Cuenta Haber</label>
                            <select class="form-select" id="cuentaHaber" name="cuentaHaber" required>
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
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="cuentaDebe" class="form-label">Cuenta Debe</label>
                            <select class="form-select" id="cuentaDebe" name="cuentaDebe" required>
                                <?php
                                // Reinicia el puntero de resultados para recorrer nuevamente los resultados
                                $result->data_seek(0);
                                
                                // Itera sobre los resultados y muestra las opciones de la lista desplegable
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['NumCuenta'] . "'>" . $row['NombreCuenta'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="valorHaber" class="form-label">Valor(Haber)</label>
                            <input type="number" step="0.01" class="form-control" name="valorHaber" id="valorHaber" required>
                        </div>
                        <div class="mb-3">
                            <label for="valorDebe" class="form-label">Valor(Debe)</label>
                            <input type="number" step="0.01" class="form-control" name="valorDebe" id="valorDebe" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function redirectToIndex() {
        window.location.href = 'index.html';
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
