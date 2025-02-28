<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    $conn = new mysqli('fdb1028.awardspace.net', '4597017_dbdiabetes', 'Diabetes1', '4597017_dbdiabetes');
    
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $fecha = $_POST['fecha'];
    $idUsuario = $_SESSION['id'];
    $tipoComida = $_POST['tipoComida']; // Asegúrate de que este campo esté en tu formulario

    // Verificar si existen registros
    $tablas = ['hiper', 'hipo', 'comidas'];
    $fecha_existe = false;

    foreach ($tablas as $tabla) {
        $sql = "SELECT COUNT(*) FROM $tabla WHERE idUsuario = ? AND fecha = ? AND tipoComida = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("iss", $idUsuario, $fecha, $tipoComida);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($count);
            $stmt->fetch();

            if ($count > 0) {
                $fecha_existe = true;
                break;
            }
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error . "<br>";
        }
    }

    if (!$fecha_existe) {
        echo '<script>alert("Error: No se encontraron registros para la fecha $fecha, tipo de comida $tipoComida en las tablas especificadas."); window.location.href="../formulario.html";</script>';
    } else {
        // Eliminar registros de las tablas dependientes primero
        foreach (['hiper', 'hipo'] as $tabla) {
            $sql = "DELETE FROM $tabla WHERE idUsuario = ? AND fecha = ? AND tipoComida = ?";
            $stmt = $conn->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("iss", $idUsuario, $fecha, $tipoComida);

                if ($stmt->execute()) {
                    echo "Registros eliminados de la tabla $tabla exitosamente.<br>";
                } else {
                    echo "Error al eliminar registros de la tabla $tabla: " . $stmt->error . "<br>";
                }
                $stmt->close();
            } else {
                echo "Error al preparar la consulta de eliminación: " . $conn->error . "<br>";
            }
        }

        // Finalmente, eliminar registros de la tabla principal
        $sql = "DELETE FROM comidas WHERE idUsuario = ? AND fecha = ? AND tipoComida = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("iss", $idUsuario, $fecha, $tipoComida);

            if ($stmt->execute()) {
                echo "Registros eliminados de la tabla comidas exitosamente.<br>";
            } else {
                echo "Error al eliminar registros de la tabla comidas: " . $stmt->error . "<br>";
            }
            $stmt->close();
        } else {
            echo "Error al preparar la consulta de eliminación de comidas: " . $conn->error . "<br>";
        }
    }
}

$conn->close();
?>
