<?php
session_start(); // Inicia la sesión al principio

// Conectar a la base de datos
$conn = new mysqli('fdb1028.awardspace.net', '4597017_dbdiabetes', 'Diabetes1', '4597017_dbdiabetes');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_POST["Entrar"])) {
    $username = $_POST['username']; 
    $password = $_POST['password']; 
    $stmt = $conn->prepare("SELECT password, idUsuario FROM usuario WHERE nombre = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $resul = $stmt->get_result();

    // Verificar si se encontró un usuario
    if ($resul->num_rows > 0) {
        $row = $resul->fetch_assoc();
        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $row['idUsuario'];
            header("Location: menu.html");
            exit(); // Detener la ejecución después de redirigir
        } else {
            $error_message = "Contraseña incorrecta.";
        }
    } else {
        $error_message = "Usuario no encontrado.";
    }

    // Cerrar la consulta
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow" style="width: 400px;">
            <div class="card-body">
                <h2 class="card-title text-center">Iniciar Sesión</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Usuario:</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="Entrar" class="btn btn-primary w-100">Entrar</button>
                </form>
                <form method="get" action="registro.php" class="mt-3">
                    <button type="submit" name="Registrarse" class="btn btn-secondary w-100">Registrarse</button>
                </form>
                <?php if (isset($error_message)): ?>
                    <div class='alert alert-danger mt-3'><?= $error_message ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
