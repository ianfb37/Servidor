<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Glucosa</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <h2 class="text-center">Registro de Glucosa</h2>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Control Diabetes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../formulario.html">Agregar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Eliminar/eliminar.html">Eliminar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mostrar.php">Modificar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../mostrar.php">Mostrar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Fecha</th>
                    <th>ID Usuario</th>
                    <th>Glucosa1</th>
                    <th>Glucosa2</th>
                    <th>Ración</th>
                    <th>Insulina</th>
                    <th>Tipo Comida</th>
                    <th>Lenta</th>
                    <th>Deporte</th>
                    <th>Tipo Comida Hiper</th>
                    <th>Hora Hiper</th>
                    <th>Glucosa Hiper</th>
                    <th>Corrección</th>
                    <th>Tipo Comida Hipo</th>
                    <th>Hora Hipo</th>
                    <th>Glucosa Hipo</th>
                    <th>Acciones</th> <!-- Nueva columna para acciones -->
                </tr>
            </thead>
            <tbody>
                <?php
                
                // Suponiendo que ya tienes una conexión a la base de datos
                $conexion = new mysqli('localhost', 'root', '', 'controldiabetes', 3307);

                // Verificar la conexión
                if ($conexion->connect_error) {
                    die("Conexión fallida: " . $conexion->connect_error);
                }
                session_start();
                $id = $_SESSION['id'];

                $query = "
                    SELECT c.fecha, c.idUsuario, c.glucosa1, c.glucosa2, c.racion, c.insulina, c.tipoComida,
                           g.lenta, g.deporte,
                           h.tipoComida AS tipoComidaHiper, h.hora AS horaHiper, h.glucosa AS glucosaHiper, h.correccion,
                           i.tipoComida AS tipoComidaHipo, i.hora AS horaHipo, i.glucosa AS glucosaHipo
                    FROM comidas c 
                    LEFT JOIN controlglucosa g ON c.idUsuario = g.idUsuario AND c.fecha = g.fecha
                    LEFT JOIN hiper h ON c.idUsuario = h.idUsuario AND c.fecha = h.fecha
                    LEFT JOIN hipo i ON c.idUsuario = i.idUsuario AND c.fecha = i.fecha
                    WHERE c.idUsuario = $id
                    ORDER BY c.fecha;
                ";

                $resultado = $conexion->query($query);

                // Rellenar la tabla con datos
                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        // Validaciones adicionales
                        $glucosaHiper = $fila['glucosaHiper'];
                        $glucosaHipo = $fila['glucosaHipo'];

                        // Verificar que no haya ambos registros de hipo e hiper
                        if (!empty($glucosaHiper) && !empty($glucosaHipo)) {
                            echo "<tr class='table-danger'>"; // Resaltar si hay hipo e hiper
                        } else {
                            echo "<tr>";
                        }

                        echo "<td>{$fila['fecha']}</td>
                              <td>{$fila['idUsuario']}</td>
                              <td>{$fila['glucosa1']}</td>
                              <td>{$fila['glucosa2']}</td>
                              <td>{$fila['racion']}</td>
                              <td>{$fila['insulina']}</td>
                              <td>{$fila['tipoComida']}</td>
                              <td>{$fila['lenta']}</td>
                              <td>{$fila['deporte']}</td>
                              <td>{$fila['tipoComidaHiper']}</td>
                              <td>{$fila['horaHiper']}</td>
                              <td>{$fila['glucosaHiper']}</td>
                              <td>{$fila['correccion']}</td>
                              <td>{$fila['tipoComidaHipo']}</td>
                              <td>{$fila['horaHipo']}</td>
                              <td>{$fila['glucosaHipo']}</td>
                              <td>
                                  <a href='editar.php?idUsuario={$fila['idUsuario']}&fecha={$fila['fecha']}' class='btn btn-warning btn-sm'>Modificar</a>
                              </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='16'>No se encontraron registros</td></tr>";
                }

                // Cerrar la conexión
                $conexion->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
