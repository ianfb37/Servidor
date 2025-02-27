<?php
session_start();

// Verificar si el ID del usuario está en la sesión
if (!isset($_SESSION['id'])) {
    die("Acceso no autorizado. Por favor inicia sesión.");
}


$conn = new mysqli('localhost', 'root', '', 'controldiabetes', 3307);

if ($conn->connect_error) die("Fatal Error");

// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['id'];

// Establecer período de tiempo (por defecto: último mes)
$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : '1month';

switch ($periodo) {
    case '1week':
        $fecha_inicio = date('Y-m-d', strtotime('-1 week'));
        $titulo_periodo = "última semana";
        break;
    case '2weeks':
        $fecha_inicio = date('Y-m-d', strtotime('-2 weeks'));
        $titulo_periodo = "últimas 2 semanas";
        break;
    case '1month':
        $fecha_inicio = date('Y-m-d', strtotime('-1 month'));
        $titulo_periodo = "último mes";
        break;
    case '3months':
        $fecha_inicio = date('Y-m-d', strtotime('-3 months'));
        $titulo_periodo = "últimos 3 meses";
        break;
    case '6months':
        $fecha_inicio = date('Y-m-d', strtotime('-6 months'));
        $titulo_periodo = "últimos 6 meses";
        break;
    case '1year':
        $fecha_inicio = date('Y-m-d', strtotime('-1 year'));
        $titulo_periodo = "último año";
        break;
    default:
        $fecha_inicio = date('Y-m-d', strtotime('-1 month'));
        $titulo_periodo = "último mes";
}

$fecha_fin = date('Y-m-d');

// Consultar datos para estadísticas
$sql = "SELECT 
            c.fecha, 
            c.lenta, 
            c.deporte, 
            cm.tipoComida, 
            cm.glucosa1, 
            cm.glucosa2, 
            cm.racion, 
            cm.insulina,
            hipo.glucosa AS hipo_glucosa, 
            hipo.hora AS hipo_hora, 
            hiper.glucosa AS hiper_glucosa, 
            hiper.hora AS hiper_hora
        FROM controlglucosa c
        LEFT JOIN comidas cm ON c.fecha = cm.fecha AND c.idUsuario = cm.idUsuario
        LEFT JOIN hipo ON cm.fecha = hipo.fecha AND cm.tipoComida = hipo.tipoComida AND cm.idUsuario = hipo.idUsuario
        LEFT JOIN hiper ON cm.fecha = hiper.fecha AND cm.tipoComida = hiper.tipoComida AND cm.idUsuario = hiper.idUsuario
        WHERE c.idUsuario = ? AND c.fecha BETWEEN ? AND ?
        ORDER BY c.fecha ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $id_usuario, $fecha_inicio, $fecha_fin);
$stmt->execute();
$result = $stmt->get_result();

// Inicializar arrays para estadísticas
$datos_por_dia = [];
$glucosa_1h = [];
$glucosa_2h = [];
$hipoglucemias = [];
$hiperglucemias = [];
$insulina_total = [];
$raciones_total = [];
$deporte_minutos = [];
$insulina_lenta = [];

// Procesar resultados
while ($row = $result->fetch_assoc()) {
    $fecha = $row['fecha'];
    
    // Inicializar arrays para cada fecha si no existen
    if (!isset($datos_por_dia[$fecha])) {
        $datos_por_dia[$fecha] = [
            'deporte' => $row['deporte'],
            'lenta' => $row['lenta'],
            'comidas' => []
        ];
    }
    
    // Agregar datos de comida
    if (!empty($row['tipoComida'])) {
        $datos_por_dia[$fecha]['comidas'][$row['tipoComida']] = [
            'glucosa1' => $row['glucosa1'],
            'glucosa2' => $row['glucosa2'],
            'racion' => $row['racion'],
            'insulina' => $row['insulina'],
            'hipo_glucosa' => $row['hipo_glucosa'],
            'hipo_hora' => $row['hipo_hora'],
            'hiper_glucosa' => $row['hiper_glucosa'],
            'hiper_hora' => $row['hiper_hora']
        ];
        
        // Recopilar datos para estadísticas
        if (!empty($row['glucosa1'])) $glucosa_1h[] = $row['glucosa1'];
        if (!empty($row['glucosa2'])) $glucosa_2h[] = $row['glucosa2'];
        if (!empty($row['hipo_glucosa'])) $hipoglucemias[] = ['fecha' => $fecha, 'valor' => $row['hipo_glucosa'], 'hora' => $row['hipo_hora'], 'comida' => $row['tipoComida']];
        if (!empty($row['hiper_glucosa'])) $hiperglucemias[] = ['fecha' => $fecha, 'valor' => $row['hiper_glucosa'], 'hora' => $row['hiper_hora'], 'comida' => $row['tipoComida']];
        if (!empty($row['insulina'])) {
            if (!isset($insulina_total[$fecha])) $insulina_total[$fecha] = 0;
            $insulina_total[$fecha] += $row['insulina'];
        }
        if (!empty($row['racion'])) {
            if (!isset($raciones_total[$fecha])) $raciones_total[$fecha] = 0;
            $raciones_total[$fecha] += $row['racion'];
        }
    }
    
    // Datos de deporte e insulina lenta
    if (!empty($row['deporte'])) $deporte_minutos[$fecha] = $row['deporte'];
    if (!empty($row['lenta'])) $insulina_lenta[$fecha] = $row['lenta'];
}

// Inicializar la variable $stats
$stats = [
    'promedio_gl_1h' => 0,
    'promedio_gl_2h' => 0,
    'total_hipoglucemias' => 0,
    'total_hiperglucemias' => 0,
    'promedio_insulina_diaria' => 0,
    'promedio_raciones_diarias' => 0,
    'promedio_deporte' => 0,
    'promedio_insulina_lenta' => 0
];

// Calcular estadísticas
$stats['promedio_gl_1h'] = !empty($glucosa_1h) ? array_sum($glucosa_1h) / count($glucosa_1h) : 0;
$stats['promedio_gl_2h'] = !empty($glucosa_2h) ? array_sum($glucosa_2h) / count($glucosa_2h) : 0;
$stats['total_hipoglucemias'] = count($hipoglucemias);
$stats['total_hiperglucemias'] = count($hiperglucemias);
$stats['promedio_insulina_diaria'] = !empty($insulina_total) ? array_sum($insulina_total) / count($insulina_total) : 0;
$stats['promedio_raciones_diarias'] = !empty($raciones_total) ? array_sum($raciones_total) / count($raciones_total) : 0;
$stats['promedio_deporte'] = !empty($deporte_minutos) ? array_sum($deporte_minutos) / count($deporte_minutos) : 0;
$stats['promedio_insulina_lenta'] = !empty($insulina_lenta) ? array_sum($insulina_lenta) / count($insulina_lenta) : 0;

// Preparar datos para gráficos
$fechas_grafico = array_keys($datos_por_dia);
$datos_gl_1h = [];
$datos_gl_2h = [];
$datos_insulina = [];
$datos_raciones = [];

foreach ($fechas_grafico as $fecha) {
    $gl_1h_dia = [];
    $gl_2h_dia = [];
    $insulina_dia = 0;
    $raciones_dia = 0;
    
    foreach ($datos_por_dia[$fecha]['comidas'] as $comida) {
        if (!empty($comida['glucosa1'])) $gl_1h_dia[] = $comida['glucosa1'];
        if (!empty($comida['glucosa2'])) $gl_2h_dia[] = $comida['glucosa2'];
        if (!empty($comida['insulina'])) $insulina_dia += $comida['insulina'];
        if (!empty($comida['racion'])) $raciones_dia += $comida['racion'];
    }
    
    $datos_gl_1h[$fecha] = !empty($gl_1h_dia) ? array_sum($gl_1h_dia) / count($gl_1h_dia) : null;
    $datos_gl_2h[$fecha] = !empty($gl_2h_dia) ? array_sum($gl_2h_dia) / count($gl_2h_dia) : null;
    $datos_insulina[$fecha] = $insulina_dia;
    $datos_raciones[$fecha] = $raciones_dia;
}

// Determinar rangos ideales
$rango_ideal_min = 70;
$rango_ideal_max = 180;

// Calcular porcentaje de lecturas en rango
$total_lecturas = count($glucosa_1h) + count($glucosa_2h);
$lecturas_en_rango = 0;

foreach ($glucosa_1h as $gl) {
    if ($gl >= $rango_ideal_min && $gl <= $rango_ideal_max) $lecturas_en_rango++;
}

foreach ($glucosa_2h as $gl) {
    if ($gl >= $rango_ideal_min && $gl <= $rango_ideal_max) $lecturas_en_rango++;
}

$porcentaje_en_rango = $total_lecturas > 0 ? ($lecturas_en_rango / $total_lecturas) * 100 : 0;

// Calcular HbA1c estimada (fórmula aproximada basada en promedios de glucosa)
$promedio_glucosa = ($stats['promedio_gl_1h'] + $stats['promedio_gl_2h']) / 2;
$hba1c_estimada = ($promedio_glucosa + 46.7) / 28.7;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Estadísticas de Diabetes</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .chart-container {
            position: relative;
            margin: auto;
            height: 40vh;
            width: 80vw;
        }
    </style>
</head>
<body>
    <div class="container mt-4 mb-5">
        <h1 class="text-center mb-4">Estadísticas de Diabetes</h1>
        
        <!-- Selector de período -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Seleccionar período</h5>
            </div>
            <div class="card-body">
                <form method="get" class="row g-3">
                    <div class="col-md-8">
                        <select name="periodo" class="form-select">
                            <option value="1week" <?= $periodo == '1week' ? 'selected' : '' ?>>Última semana</option>
                            <option value="2weeks" <?= $periodo == '2weeks' ? 'selected' : '' ?>>Últimas 2 semanas</option>
                            <option value="1month" <?= $periodo == '1month' ? 'selected' : '' ?>>Último mes</option>
                            <option value="3months" <?= $periodo == '3months' ? 'selected' : '' ?>>Últimos 3 meses</option>
                            <option value="6months" <?= $periodo == '6months' ? 'selected' : '' ?>>Últimos 6 meses</option>
                            <option value="1year" <?= $periodo == '1year' ? 'selected' : '' ?>>Último año</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Gráficos -->
        <div class="row">
            <!-- Gráfico de Glucosa -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Tendencia de Glucosa</h5>
                    </div>
                    <div class="card-body chart-container">
                        <canvas id="glucosaChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Gráfico de Insulina y Raciones -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Insulina y Raciones</h5>
                    </div>
                    <div class="card-body chart-container">
                        <canvas id="insulinaRacionesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabla de eventos -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Eventos de Hipoglucemia e Hiperglucemia</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Tipo</th>
                                <th>Comida</th>
                                <th>Glucosa (mg/dl)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hipoglucemias as $hipo): ?>
                                <tr class="table-danger">
                                    <td><?= $hipo['fecha'] ?></td>
                                    <td><?= $hipo['hora'] ?></td>
                                    <td>Hipoglucemia</td>
                                    <td><?= $hipo['comida'] ?></td>
                                    <td><?= $hipo['valor'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php foreach ($hiperglucemias as $hiper): ?>
                                <tr class="table-warning">
                                    <td><?= $hiper['fecha'] ?></td>
                                    <td><?= $hiper['hora'] ?></td>
                                    <td>Hiperglucemia</td>
                                    <td><?= $hiper['comida'] ?></td>
                                    <td><?= $hiper['valor'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts para gráficos -->
    <script>
        // Datos para gráficos
        const fechas = <?= json_encode($fechas_grafico) ?>;
        const glucosa1h = <?= json_encode(array_values($datos_gl_1h)) ?>;
        const glucosa2h = <?= json_encode(array_values($datos_gl_2h)) ?>;
        const insulina = <?= json_encode(array_values($datos_insulina)) ?>;
        const raciones = <?= json_encode(array_values($datos_raciones)) ?>;

        // Gráfico de Glucosa
        const ctxGlucosa = document.getElementById('glucosaChart').getContext('2d');
        new Chart(ctxGlucosa, {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [
                    {
                        label: 'Glucosa 1h (mg/dl)',
                        data: glucosa1h,
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.2)',
                        fill: true,
                        tension: 0.1
                    },
                    {
                        label: 'Glucosa 2h (mg/dl)',
                        data: glucosa2h,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        fill: true,
                        tension: 0.1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Glucosa (mg/dl)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha'
                        }
                    }
                }
            }
        });
        // Gráfico de Insulina y Raciones
        const ctxInsulinaRaciones = document.getElementById('insulinaRacionesChart').getContext('2d');
        new Chart(ctxInsulinaRaciones, {
            type: 'bar',
            data: {
                labels: fechas,
                datasets: [
                    {
                        label: 'Insulina (UI)',
                        data: insulina,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Raciones',
                        data: raciones,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

