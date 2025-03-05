<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<h1>Listado de pictogramas</h1>
      

<div class="row">
<?php

$conn = new mysqli('localhost', 'root', '', 'pictogramas', 3307);

// Verificar conexión

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
      $stmte =  $conn->query("SELECT imagen ,descripcion FROM imagenes   ");
      
      while($roware = $stmte->fetch_assoc()){
        if ($roware["imagen"] != NULL) {
            echo '<div class="col-md-3 mb-3">';
            echo '  <div class="card h-100">';
            if ($roware["imagen"] != NULL) {
                echo '<img src="' . $roware["imagen"] . '" class="card-img-top" alt="' . $roware["descripcion"] . '">';
            } 
                echo '<div class="card-img-top bg-light d-flex justify-content-center align-items-center" style="height: 200px;">';
                echo '<h5 class="text-muted">'. $roware["descripcion"] .'</h5>';
                
                echo '<h5 class="text-muted">'. $roware["imagen"] .'</h5>';
                echo '</div>';
                
            
            echo '<div class="card-body">';
            
            echo '</div>';
            echo '</div>';
            echo '</div>';
      }
    }
?>
</div>