<html>
<head>
    <title>Formulario de Cajas de Texto</title>
</head>
<body>
    <h1>Formulario de Cajas de Texto</h1>
    <?php
    if(isset($_POST['enviar'])){
        $cont=0;

        for($i=0;$i<2;$i++){
            for($j=0;$j<3;$j++){
                $h++;
                if($_POST[$h]>100 || $_POST[$h]<0 ){
                    echo "Hay numero invalidos ";
                    echo $h;
                    echo "</br>";
                }
                else{
                $num[$i][$j]=$_POST[$h];
                $binario[$i][$j]= decbin($num[$i][$j]);
                echo "</br>";
                echo "El numero ". $num [$i][$j]." en binario es ". $binario[$i][$j];
            }
        }
        }
        }
        else
        echo "hola";
    $h=0;
    for($i=0;$i<2;$i++){
        for($j=0;$j<3;$j++){
            $h++;
            
  echo <<<_END
  <form  action='#' method='post'>
        <label for="$i"> $i.$j:</label>

        <input type="text" id="caja0" name="$h"><br><br>
_END;
        }
    }
      echo <<<_END
    <input type="submit" value="enviar" name="enviar"> 
_END;


?>
    </form>
    
</body>
</html>
