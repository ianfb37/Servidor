<?php
$conn = new mysqli('localhost', 'root', '', 'controldiabetes', 3307);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $id = $_SESSION['id'];
    $deporte = $_POST['deporte'];
    $lenta = $_POST['indice_actividad'];
    $fecha = date('Y-m-d');

    // Verificar si ya existe un registro para hoy
    $checkSql = "SELECT COUNT(*) FROM controlglucosa WHERE idUsuario = ? AND DATE(fecha) = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("is", $id, $fecha);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        // Si ya hay un registro para hoy, mostrar alerta y redirigir
        echo "<script>
                alert('Ya has registrado datos para hoy.');
                window.location.href = 'formulario.html'; // Cambia esto a la ruta de tu formulario
              </script>";
    } else {
        // Si no hay registro, insertar los datos
        $sql = "INSERT INTO controlglucosa (idUsuario, fecha, lenta, deporte) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issi", $id, $fecha, $lenta, $deporte);
        
        if ($stmt->execute()) {
            echo '<script>alert("Control de glucosa registrado exitosamente"); window.location.href="formulario.html";</script>';

        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
        
        $stmt->close();
    }
}

$conn->close();
?>
