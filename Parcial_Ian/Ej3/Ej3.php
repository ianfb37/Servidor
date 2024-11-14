<?php
session_start();

$_SESSION['num']=$_POST['numero'];

if(isset($_POST['random'])){
    $x = rand(1, 100);
    $_SESSION['ran']=$x;
 }
if(isset($_POST['enviar'])){
   echo $_SESSION['ran'];
        if($_SESSION['ran']<$_SESSION['num']){
            echo "Tu numero es ".$_SESSION['num'];
            echo "<br>";
        echo "El numero es menor";
        $inten++;
        }
        else
        if($_SESSION['ran']>$_SESSION['num']){
            echo "Tu numero es ".$_SESSION['num'];
            echo "<br>";
            echo "El numero es mayor";
            $inten++;
            }
            else{
        echo "Tu numero es ".$_SESSION['num'];
        echo "Enorabuena";
            }
        }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Simple</title>
</head>
<body>
    <h1>Formulario de Registro</h1>
    
     <form action="#" method="post">
        <input type="text" id="numero" name="numero" value="">
        <input type="submit" name="enviar" value="Enviar">
        <input type="submit" name="random" value="random">
    </form>
</body>
</html>
