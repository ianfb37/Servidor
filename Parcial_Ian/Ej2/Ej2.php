<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Simple</title>
</head>
<body>
    <h1>Formulario de Registro</h1>

    <?php
    session_start();
    for($i=0;$i<=4;$i++){
        $ialeatorio[$i]=rand(0,1);
    }
    ?>
     <form action="contador.php" method="post">
        <input type="submit" name="restar" value="Restar">
        
        <input type="submit" name="sumar" value="Sumar">
        <input type="submit" name="enviar" value="Enviar">

        <form action="contador.php" method="post">
         <img src="Uno.jpg" alt="" />
        <img src="dos.jpg" alt="" />
         <img src="cuatro.jpg" alt="" />
       <img src="ocho.jpg" alt="" value="ocho"/>
        <input type="submit" name="enviar" value="Enviar">
    </form>
</body>
</html>
