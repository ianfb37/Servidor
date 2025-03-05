<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<form method="post">
           <label for="fecha">Fecha</label> 
           <?php
                     $hoy = date('Y-m-d H:i:s');
                     echo  '<input type="date" id="fecha" name="fecha" value='.$hoy.' required>'
                ?>
            
            
            <label for="fecha">hora</label>
            <input type="time" id="time" name="time" required>
            
            
        
        <div class="form-group">
                    <select name="tipo_comida" class="form-control" required>
<option value="" disabled selected>Persona</option>

                    <?php
                    $conn = new mysqli('localhost', 'root', '', 'pictogramas', 3307);

                    // Verificar conexión
                    
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }
                        $stmt = $conn->query("SELECT nombre FROM personas");
                           
            while( $rowar = $stmt->fetch_assoc()){
                echo '<option value="a">'. $rowar["nombre"] .' </option>';
            }
            
            ?><input type="submit" name="Entrar" value="Entrar">
          
        </form>
        <form method="POST">
        <input type="submit" name="Volver" value="Volver"></form>
        <div class="row">
            <?php
            if(isset($_POST['Entrar'])){
            $stmte =  $conn->query("SELECT imagen ,descripcion, idimagen FROM imagenes   ");
      
            while($roware = $stmte->fetch_assoc()){
              if ($roware["imagen"] != NULL) {
                  echo '<div class="col-md-3 mb-3">';
                  echo '  <div class="card h-20">';
                  if ($roware["imagen"] != NULL) {
                      echo '<img src="' . $roware["imagen"] . '" class="card-img-top" alt="' . $roware["descripcion"] . '">';
                      echo '<h5 class="text-muted">'. $roware["idimagen"] .'</h5>';
                  } 
                      echo '<div class="card-img-top bg-light d-flex justify-content-center align-items-center" style="height: 50px;">';
                      echo '<h5 class="text-muted">'. $roware["descripcion"] .'</h5>';
                      echo '<br>';
                     
                      echo '</div>';
                  
                  echo '<div class="card-body">';
                  
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                }
            }
          }
          if(isset($_POST['Volver'])){
            header("Location: ej2.php");
          }


?>

                    </select>
                </div>