<?php
session_start(); // Asegúrate de que esto esté al principio

// Conexión a la base de datos
$conn = new mysqli('fdb1028.awardspace.net', '4597017_dbdiabetes', 'Diabetes1', '4597017_dbdiabetes');
if ($conn->connect_error) die("Fatal Error");

// Consulta SQL para obtener los datos
$sql = "SELECT 
    c.fecha, 
    c.deporte, 
    c.lenta, 
    cm.tipoComida, 
    cm.glucosa1 AS gl_1h, 
    cm.glucosa2 AS gl_2h, 
    cm.racion AS raciones, 
    cm.insulina, 
    hipo.glucosa AS hipo_glucosa, 
    hipo.hora AS hipo_hora, 
    hiper.glucosa AS hiper_glucosa, 
    hiper.hora AS hiper_hora,
    hiper.correccion AS correccion 
FROM 
    controlGlucosa c
LEFT JOIN 
    comidas cm ON c.fecha = cm.fecha AND c.idUsuario = cm.idUsuario
LEFT JOIN 
    hipo ON cm.fecha = hipo.fecha AND cm.tipoComida = hipo.tipoComida AND cm.idUsuario = hipo.idUsuario
LEFT JOIN 
    hiper ON cm.fecha = hiper.fecha AND cm.tipoComida = hiper.tipoComida AND cm.idUsuario = hiper.idUsuario
ORDER BY 
    c.fecha ASC;";

$result = $conn->query($sql);

$data = [];
$tipo_comidas = [];
while ($row = $result->fetch_assoc()) {
    $data[$row['fecha']][$row['tipoComida']] = $row;
    if (!in_array($row['tipoComida'], $tipo_comidas)) {
        $tipo_comidas[] = $row['tipoComida'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9ecef; /* Fondo gris claro */
            margin: 20px; 
        }
        .navbar {
            background-color: #007bff; /* Azul para la barra de navegación */
        }
        .table {
            margin: 20px;
            border-radius: 10px; /* Bordes redondeados */
            overflow: hidden; /* Para bordes redondeados */
        }
        .table th {
            background-color: #6c757d; /* Fondo gris oscuro para encabezados */
            color: white; /* Texto blanco */
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa; /* Color de fondo para filas impares */
        }
        .table-striped tbody tr:nth-of-type(even) {
            background-color: #ffffff; /* Color de fondo para filas pares */
        }
        .btn-primary {
            background-color: #28a745; /* Verde para el botón */
            border: none; /* Sin borde */
        }
        .btn-primary:hover {
            background-color: #218838; /* Color al pasar el mouse */
        }
        h2 {
            color: #007bff; /* Color del título */
        }
    </style>
</head>
<body class="container-fluid mt-4"> 
    <h2 class="text-center mb-4">Historial de Datos</h2>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Control Diabetes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="formulario.html">Agregar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="eliminar.html">Eliminar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mostrarmod.php">Modificar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Mostrar.php">Mostrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Estadisticas.php">Estadisticas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div> 
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center align-middle">Día</th>
                    <th rowspan="2" class="text-center align-middle">Deporte</th>
                    <th rowspan="2" class="text-center align-middle">Insulina Lenta</th>
                    <?php foreach ($tipo_comidas as $tipo): ?>
                        <th colspan="9" class="text-center"> <?= htmlspecialchars($tipo) ?> </th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($tipo_comidas as $tipo): ?>
                        <th>Glucosa 1h</th>
                        <th>Glucosa 2h</th>
                        <th>Raciones</th>
                        <th>Insulina</th>
                        <th>Hipo Glucosa</th>
                        <th>Hipo Hora</th>
                        <th>Hiper Glucosa</th>
                        <th>Hiper Hora</th>
                        <th>Corrección</th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $fecha => $rows): ?>
                    <tr>
                        <td><?= htmlspecialchars($fecha) ?></td>
                        <td><?= htmlspecialchars($rows[array_key_first($rows)]["deporte"] ?? '') ?></td>
                        <td><?= htmlspecialchars($rows[array_key_first($rows)]["lenta"] ?? '') ?></td>
                        <?php foreach ($tipo_comidas as $tipo): ?>
                            <td><?= htmlspecialchars($rows[$tipo]["gl_1h"] ?? '') ?></td>
                            <td><?= htmlspecialchars($rows[$tipo]["gl_2h"] ?? '') ?></td>
                            <td><?= htmlspecialchars($rows[$tipo]["raciones"] ?? '') ?></td>
                            <td><?= htmlspecialchars($rows[$tipo]["insulina"] ?? '') ?></td>
                            <td><?= htmlspecialchars($rows[$tipo]["hipo_glucosa"] ?? '') ?></td>
                            <td><?= htmlspecialchars($rows[$tipo]["hipo_hora"] ?? '') ?></td>
                            <td><?= htmlspecialchars($rows[$tipo]["hiper_glucosa"] ?? '') ?></td>
                            <td><?= htmlspecialchars($rows[$tipo]["hiper_hora"] ?? '') ?></td>
                            <td><?= htmlspecialchars($rows[$tipo]["correccion"] ?? '') ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="Inicio/menuControl.php" class="btn btn-primary mt-2 w-100">Volver</a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
