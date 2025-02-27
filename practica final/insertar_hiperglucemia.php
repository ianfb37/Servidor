<?php
$conn = new mysqli('localhost', 'root', '', 'controldiabetes', 3307);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION['id'];
    $tipo_comida = $_POST['tipo_comida'];
    $fecha = $_POST['fecha'];
    $hoy = date('Y-m-d H:i:s');
    $glucosa = $_POST['glucosa'];
    $hora = $_POST['hora'];
    $correccion = $_POST['correccion'];

    // Validación de glucosa
    if (!is_numeric($glucosa) || $glucosa < 0 || $glucosa > 500) {
        echo '<script>alert("Valor de glucosa no válido."); window.location.href="formulario.html";</script>';
        exit;
    }

    // Verificar que la fecha no sea futura
    if ($fecha > date('Y-m-d')) {
        echo '<script>alert("La fecha no puede ser superior a hoy."); window.location.href="formulario.html";</script>';
        exit;
    }

    // Establecer la zona horaria
    date_default_timezone_set('Europe/Madrid'); // Cambia esto a tu zona horaria
    $hora_local = date('H:i:s');

    // Verificar si la hora es válida
    if ($hora > $hora_local) {
        echo '<script>alert("Error: no puede insertar datos a futuro."); window.location.href="formulario.html";</script>';
        exit;
    }

    // Verificar si hay datos de control de glucosa para la fecha
    $stmt = $conn->prepare("SELECT * FROM controlglucosa WHERE idUsuario = ? AND DATE(fecha) = DATE(?)");
    $stmt->bind_param("is", $id, $fecha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Verificar si hay comidas registradas para el usuario y la fecha
        $stmt = $conn->prepare("SELECT * FROM Comidas WHERE idUsuario = ? AND DATE(fecha) = DATE(?)");
        $stmt->bind_param("is", $id, $fecha);
        $stmt->execute();
        $resultComidas = $stmt->get_result();

        if ($resultComidas->num_rows > 0) {
            // Insertar hiperglucemia
            $sql = "INSERT INTO hiper (idUsuario, tipoComida, fecha, glucosa, hora, correccion) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssss", $id, $tipo_comida, $fecha, $glucosa, $hora, $correccion);
            
            if ($stmt->execute()) {
                echo '<script>alert("Hiperglucemia registrada exitosamente"); window.location.href="formulario.html";</script>';
            } else {
                echo '<script>alert("Error al registrar hiperglucemia."); window.location.href="formulario.html";</script>';
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


