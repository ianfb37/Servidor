<?php
$conn = new mysqli('fdb1028.awardspace.net', '4597017_dbdiabetes', 'Diabetes1', '4597017_dbdiabetes');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION['id'];
    $tipo_comida = $_POST['tipo_comida'];
    $fecha = $_POST['fecha'];
    $hoy = date('Y-m-d H:i:s');
    $glucosa = $_POST['glucosa'];
    $hora = $_POST['hora'];

    // Validación de fecha
    if ($fecha > date('Y-m-d')) {
        echo '<script>alert("La fecha no puede ser superior a hoy."); window.location.href="formulario.html";</script>';
        exit;
    }

    // Validación de glucosa
    if (!is_numeric($glucosa) || $glucosa < 0 || $glucosa > 500) {
        echo '<script>alert("Valor de glucosa no válido. Debe ser un número entre 0 y 500."); window.location.href="formulario.html";</script>';
        exit;
    }

    // Verificar si hay datos de control de glucosa
    $stmt = $conn->prepare("SELECT * FROM controlGlucosa WHERE idUsuario = ? AND DATE(fecha) = DATE(?)");
    $stmt->bind_param("is", $id, $fecha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        date_default_timezone_set('Europe/Madrid'); 
        $hora_local = date('H:i:s');

        // Verificar que la hora no sea futura
        if ($hora > $hora_local) {
            echo '<script>alert("Error: no puede insertar datos a futuro."); window.location.href="formulario.html";</script>';
            exit;
        }

        // Verificar si hay comidas registradas
        $stmt = $conn->prepare("SELECT * FROM comidas WHERE idUsuario = ? AND DATE(fecha) = DATE(?) AND tipoComida = ?");
        $stmt->bind_param("iss", $id, $fecha, $tipo_comida);
        $stmt->execute();
        $resultComidas = $stmt->get_result();

        if ($resultComidas->num_rows > 0) {
            // Insertar hipoglucemia
            $sql = "INSERT INTO hipo (idUsuario, tipoComida, fecha, glucosa, hora) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issss", $id, $tipo_comida, $fecha, $glucosa, $hora);

            if ($stmt->execute()) {
                echo '<script>alert("Hipoglucemia registrada exitosamente"); window.location.href="formulario.html";</script>';
            } else {
                echo '<script>alert("Error al registrar hipoglucemia."); window.location.href="formulario.html";</script>';
            }
        } else {
            echo '<script>alert("Inserte primero comida."); window.location.href="formulario.html";</script>';
            exit();
        }
    } else {
        echo '<script>alert("No hay datos de control de glucosa para esta fecha."); window.location.href="formulario.html";</script>';
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
