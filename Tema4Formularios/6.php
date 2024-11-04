<html>
<head>
    <title>Formulario de Cajas de Texto</title>
</head>
<body>
    <h1>Formulario de Cajas de Texto</h1>

    <form  action='#' method='post'>
        
    <input type="number" id="caja0" value="id" name="NU"><br><br>
    <input type="submit" value="Aceptar" name="acep"> 
    </form>
    <?php
    if(isset($_POST['acep'])){
        echo "Hola";
    for($i=0;$i<$_POST['NU'];$i++){

  echo <<<_END
  <form  action='#' method='post'>
        <label for="$i">$i:</label>

        <input type="text" id="caja0" name="$i"><br><br>
_END;
     
    
     }
      echo <<<_END
    <input type="submit" value="Enviar"> 
_END;
    }
          

?>
    </form>
    
</body>
</html>

