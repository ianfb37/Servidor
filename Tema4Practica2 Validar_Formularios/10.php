<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form  action='#' method='post'>
    <input type="text" id="Web" name="Website"><br><br>
    <input type="submit" value="Aceptar" name="acep"> 
</form>
    <?php
    if(isset($_POST['acep'])){
        echo "<br>";
        $url=$_POST['Website'];
        validar_url($url);
    }
    function validar_url($url){
        if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|](\.)[a-z]{2}/i",$_POST['Website'])) {
            echo "$url es una Url valida";
        }
        else {
            echo("$url no es una URL valida");
        }
    }

    ?>
    
</body>
</html>