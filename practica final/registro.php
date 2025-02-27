<<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<?php


// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'controldiabetes', 3307);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $nombre = $_POST['nombre'];
   // Cifrar la contraseña
    $stmt= $conn->prepare("SELECT username from usuario where username=?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $resul = $stmt->get_result();
                if ($resul->num_rows > 0) {
                    echo "<p class='text-danger'>El usuario ya existe</p>";

                }
                else{
         $apellido = $_POST['apellido'];
         $fechaNac = $_POST['fechaNac'];
        
         $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $sql = "INSERT INTO usuario (nombre, apellido, fechaNac, username, password) VALUES ('$nombre', '$apellido', '$fechaNac', '$username', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Usuario registrado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
</head>
<body>
    <h1>Registro de Usuario</h1>
    <form method="POST" action="">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <input type="date" name="fechaNac" placeholder="Fecha de Nacimiento" required>
        <input type="text" name="username" placeholder="Nombre de Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrar</button>
    </form>

</body>
</html>

