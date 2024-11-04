<html>
<head>
    <title>Formulario de Cajas de Texto</title>
</head>
<body>
    <h1>Formulario de Cajas de Texto</h1>

    <form  action='resultadoformdinamico.php' method='get'>
        
    <?php
    for($i=0;$i<3;$i++){
  echo <<<_END
        <label for="$i">$i:</label>

        <input type="text" id="caja0" name="$i"><br><br>
_END;
     }   
     echo <<<_END
    <input type="submit" value="Enviar"> 
_END;
       
          

?>
    </form>
    
</body>
</html>

