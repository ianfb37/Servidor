<?php
// Establecer la conexión a la base de datos
$conexion = new mysqli('fdb1028.awardspace.net', '4597017_dbdiabetes', 'Diabetes1', '4597017_dbdiabetes');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Iniciar la sesión
session_start();

// Obtener los parámetros de la URL
$idUsuario = $_GET['idUsuario'];
$fecha = $_GET['fecha'];

// Consulta para obtener el tipo de comida desde la tabla comidas
$queryTipoComida = "
    SELECT tipoComida 
    FROM comidas 
    WHERE idUsuario = $idUsuario AND fecha = '$fecha';
";

$resultadoTipoComida = $conexion->query($queryTipoComida);

// Verificar si hay resultados
if ($resultadoTipoComida && $resultadoTipoComida->num_rows > 0) {
    $filaTipoComida = $resultadoTipoComida->fetch_assoc();
    $tipoComida = $filaTipoComida['tipoComida'];
} else {
    die("Error: No se encontró un tipo de comida para el idUsuario y fecha especificados.");
}

// Consulta para obtener los datos existentes
$query = "
    SELECT c.fecha, c.idUsuario, c.glucosa1, c.glucosa2, c.racion, c.insulina, c.tipoComida,
           g.lenta, g.deporte,
           h.tipoComida AS tipoComidaHiper, h.hora AS horaHiper, h.glucosa AS glucosaHiper, h.correccion,
           i.tipoComida AS tipoComidaHipo, i.hora AS horaHipo, i.glucosa AS glucosaHipo
    FROM comidas c 
    LEFT JOIN controlGlucosa g ON c.idUsuario = g.idUsuario AND c.fecha = g.fecha
    LEFT JOIN hiper h ON c.idUsuario = h.idUsuario AND c.fecha = h.fecha AND c.tipoComida = h.tipoComida
    LEFT JOIN hipo i ON c.idUsuario = i.idUsuario AND c.fecha = i.fecha AND c.tipoComida = i.tipoComida
    WHERE c.idUsuario = $idUsuario AND c.fecha = '$fecha' AND c.tipoComida = '$tipoComida';
";

$resultado = $conexion->query($query);

// Verificar si hay resultados
if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "<div class='alert alert-warning'>No se encontraron registros para la fecha y tipo de comida especificados.</div>";
    $fila = []; // Inicializa $fila como un array vacío
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $glucosa1 = $_POST['glucosa1'];
    $glucosa2 = $_POST['glucosa2'];
    $racion = $_POST['racion'];
    $insulina = $_POST['insulina'];
    $tipoComida = $_POST['tipoComida'];
    $lenta = $_POST['lenta'];
    $deporte = $_POST['deporte'];
    $tipoComidaHiper = $_POST['tipoComidaHiper'];
    $horaHiper = $_POST['horaHiper'];
    $glucosaHiper = $_POST['glucosaHiper'];
    $correccion = $_POST['correccion'];
    $tipoComidaHipo = $_POST['tipoComidaHipo'];
    $horaHipo = $_POST['horaHipo'];
    $glucosaHipo = $_POST['glucosaHipo'];

    // Validaciones
    $errores = [];
    date_default_timezone_set('Europe/Madrid'); // Configurar la zona horaria
    $hora_local = date('H:i:s');
    $hoy = date('Y-m-d H:i:s');

    // Validar que los valores no sean negativos
    if ($glucosa1 < 0 || $glucosa2 < 0 || $racion < 0 || $insulina < 0) {
        $errores[] = "Los valores de glucosa, ración e insulina no pueden ser negativos.";
    }

    // Verificar que no haya hipo e hiper al mismo tiempo
    if (!empty($glucosaHiper) && !empty($glucosaHipo)) {
        $errores[] = "No se pueden registrar valores de hipo y hiper al mismo tiempo.";
    }
    if ((!empty($glucosaHiper) && $glucosaHiper < 0) || (!empty($glucosaHipo) && $glucosaHipo < 0)) {
        $errores[] = "No se pueden registrar valores negativos en hipo o hiper.";
    }
    if ($fecha == $hoy) {
        if ($horaHiper > $hora_local || $horaHipo > $hora_local) {
            $errores[] = "No se pueden registrar datos a futuro (hora superior a la actual).";
        }
    }

    // Si hay errores, mostrarlos
    if (count($errores) > 0) {
        foreach ($errores as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        // Actualizar los datos en la base de datos
        $updateQuery = "
            UPDATE comidas 
            SET glucosa1 = '$glucosa1', glucosa2 = '$glucosa2', racion = '$racion', insulina = '$insulina' 
            WHERE idUsuario = $idUsuario AND fecha = '$fecha' AND tipoComida = '$tipoComida';
        ";
        
        if ($conexion->query($updateQuery) === TRUE) {
            echo "Actualización en comidas exitosa.<br>";
        } else {
            echo "Error en comidas: " . $conexion->error . "<br>";
        }

        $updateGlucosaQuery = "
            UPDATE controlGlucosa 
            SET lenta = '$lenta', deporte = '$deporte' 
            WHERE idUsuario = $idUsuario AND fecha = '$fecha';
        ";
        
        if ($conexion->query($updateGlucosaQuery) === TRUE) {
            echo "Actualización en controlGlucosa exitosa.<br>";
        } else {
            echo "Error en controlGlucosa: " . $conexion->error . "<br>";
        }

        $updateHiperQuery = "
            UPDATE hiper 
            SET hora = '$horaHiper', glucosa = '$glucosaHiper', correccion = '$correccion' 
            WHERE idUsuario = $idUsuario AND fecha = '$fecha' AND tipoComida = '$tipoComidaHiper';
        ";
        
        if ($conexion->query($updateHiperQuery) === TRUE) {
            echo "Actualización en hiper exitosa.<br>";
        } else {
            echo "Error en hiper: " . $conexion->error . "<br>";
        }

        $updateHipoQuery = "
            UPDATE hipo 
            SET hora = '$horaHipo', glucosa = '$glucosaHipo' 
            WHERE idUsuario = $idUsuario AND fecha = '$fecha' AND tipoComida = '$tipoComidaHipo';
        ";
        
        if ($conexion->query($updateHipoQuery) === TRUE) {
            echo "Actualización en hipo exitosa.<br>";
        } else {
            echo "Error en hipo: " . $conexion->error . "<br>";
        }

        echo "<div class='alert alert-success'>Registro actualizado con éxito.</div>";
    }
}

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro de Glucosa</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <h2 class="text-center">Editar Registro de Glucosa</h2>
        <form method="POST" action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="glucosa1">Glucosa 1:</label>
                        <input type="text" class="form-control" id="glucosa1" name="glucosa1" value="<?php echo isset($fila['glucosa1']) ? $fila['glucosa1'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="glucosa2">Glucosa 2:</label>
                        <input type="text" class="form-control" id="glucosa2" name="glucosa2" value="<?php echo isset($fila['glucosa2']) ? $fila['glucosa2'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="racion">Ración:</label>
                        <input type="text" class="form-control" id="racion" name="racion" value="<?php echo isset($fila['racion']) ? $fila['racion'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="insulina">Insulina:</label>
                        <input type="text" class="form-control" id="insulina" name="insulina" value="<?php echo isset($fila['insulina']) ? $fila['insulina'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tipoComida">Tipo de Comida:</label>
                        <input type="text" class="form-control" id="tipoComida" name="tipoComida" value="<?php echo isset($fila['tipoComida']) ? $fila['tipoComida'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="lenta">Lenta:</label>
                        <input type="text" class="form-control" id="lenta" name="lenta" value="<?php echo isset($fila['lenta']) ? $fila['lenta'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="deporte">Deporte:</label>
                        <input type="text" class="form-control" id="deporte" name="deporte" value="<?php echo isset($fila['deporte']) ? $fila['deporte'] : ''; ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipoComidaHiper">Tipo de Comida Hiper:</label>
                        <input type="text" class="form-control" id="tipoComidaHiper" name="tipoComidaHiper" value="<?php echo isset($fila['tipoComidaHiper']) ? $fila['tipoComidaHiper'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="horaHiper">Hora Hiper:</label>
                        <input type="time" class="form-control" id="horaHiper" name="horaHiper" value="<?php echo isset($fila['horaHiper']) ? $fila['horaHiper'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="glucosaHiper">Glucosa Hiper:</label>
                        <input type="text" class="form-control" id="glucosaHiper" name="glucosaHiper" value="<?php echo isset($fila['glucosaHiper']) ? $fila['glucosaHiper'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="correccion">Corrección:</label>
                        <input type="text" class="form-control" id="correccion" name="correccion" value="<?php echo isset($fila['correccion']) ? $fila['correccion'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="tipoComidaHipo">Tipo de Comida Hipo:</label>
                        <input type="text" class="form-control" id="tipoComidaHipo" name="tipoComidaHipo" value="<?php echo isset($fila['tipoComidaHipo']) ? $fila['tipoComidaHipo'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="horaHipo">Hora Hipo:</label>
                        <input type="time" class="form-control" id="horaHipo" name="horaHipo" value="<?php echo isset($fila['horaHipo']) ? $fila['horaHipo'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="glucosaHipo">Glucosa Hipo:</label>
                        <input type="text" class="form-control" id="glucosaHipo" name="glucosaHipo" value="<?php echo isset($fila['glucosaHipo']) ? $fila['glucosaHipo'] : ''; ?>">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="menu.html" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


