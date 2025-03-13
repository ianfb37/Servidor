<?php
session_start(); // Mover al principio
$conn = new mysqli('fdb1028.awardspace.net', '4597017_dbdiabetes', 'Diabetes1', '4597017_dbdiabetes');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION['id'];
    $tipo_comida = $_POST['tipo_comida'];
    $raciones = $_POST['raciones'];
    $glucosa_1 = $_POST['glucosa_1'];
    $glucosa_2 = $_POST['glucosa_2'];
    $insulina = $_POST['insulina'];
    $fecha = date('Y-m-d');

    // Validación de glucosa y raciones
    if (!is_numeric($glucosa_1) || $glucosa_1 < 0 || $glucosa_1 > 500 ||
        !is_numeric($glucosa_2) || $glucosa_2 < 0 || $glucosa_2 > 500 ||
        !is_numeric($raciones) || $raciones < 0) {
        echo '<script>alert("Valores no válidos. Los valores de glucosa deben estar entre 0 y 500 y las raciones no pueden ser negativas."); window.location.href="formulario.html";</script>';
        exit;
    }

    // Consulta corregida
    $stmt = "SELECT * FROM controlGlucosa WHERE idUsuario=? AND fecha=?";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("is", $id, $fecha);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        $sql = "INSERT INTO comidas (idUsuario, fecha, glucosa1, glucosa2, racion, insulina, tipoComida) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isiiiis", $id, $fecha, $glucosa_1, $glucosa_2, $raciones, $insulina, $tipo_comida);
        
        if ($stmt->execute()) {
            echo '<script>alert("Comida registrada exitosamente"); window.location.href="formulario.html";</script>';
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
    } else {
        // Mostrar mensaje de alerta y redirigir usando JavaScript
        echo '<script>alert("Inserte primero control glucosa"); window.location.href="formulario.html";</script>';
        exit(); // Asegúrate de salir después de redirigir
    }
    $stmt->close();
}

$conn->close();
?>
