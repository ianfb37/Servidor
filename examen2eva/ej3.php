<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<form method="post">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" required>
            
            <input type="submit" name="Entrar" value="Entrar">
        </form>
        <h1>Agenda del dia</h1>
        <div class="row">
<?php

$conn = new mysqli('localhost', 'root', '', 'pictogramas', 3307);

// Verificar conexión

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
if(isset($_POST['Entrar'])){
$username=$_POST['username'];
if(isset($_POST['username'])){
$stmt = $conn->query("SELECT nombre,idpersona FROM personas  WHERE nombre = '$username'");
$rowar = $stmt->fetch_assoc();
    
// Verificar si se encontró un usuario y validar la contraseña
session_start();
if ($rowar) {
    $id=$rowar['idpersona'];
    $fecha=$_POST['fecha'];
    
    $stmts =$conn->query ("SELECT hora,idimagen FROM agenda WHERE idpersona = '$id' and fecha= '$fecha' ");
   

    while( $rowars = $stmts->fetch_assoc()){
        $idimagen=$rowars['idimagen'];
      $stmte =  $conn->query("SELECT imagen ,descripcion FROM imagenes WHERE idimagen = '$idimagen'  ");
      
      while($roware = $stmte->fetch_assoc()){
        if ($roware["imagen"] != NULL) {
            echo '<div class="col-md-5 mb-5">';
            echo '  <div class="card h-100">';
            if ($roware["imagen"] != NULL) {
                echo '<img src="' . $roware["imagen"] . '" class="card-img-top" alt="' . $roware["descripcion"] . '">';
            } else {
                echo '<div class="card-img-top bg-light d-flex justify-content-center align-items-center" style="height: 200px;">';
                echo '<h5 class="text-muted">'. $roware["descripcion"] .'</h5>';
                echo '</div>';
            }
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $roware["descripcion"] . '</h5>';
            echo '<h5 class="card-title">' .$roware["imagen"]. $rowars["hora"] . '</h5>';
            
            echo '</div>';
            echo '</div>';
            echo '</div>';
      }
    }
}
}
}
}
?>
        </div>
