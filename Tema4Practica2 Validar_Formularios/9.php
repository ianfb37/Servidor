<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form  action='#' method='post'>
    <input type="text" id="email" name="E-mail"><br><br>
    <input type="submit" value="Aceptar" name="acep"> 
</form>
    <?php
    if(isset($_POST['acep'])){
        //Este preg_Math lo que hace es validar
        /*
    ^: Indica el inicio de la cadena.
    ([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,18}:
    ([A-Za-zÑñ]+: Coincide con uno o más caracteres alfabéticos (incluyendo letras con tilde).
    [áéíóú]?: Permite opcionalmente una vocal acentuada.
    [A-Za-z]*: Permite cero o más caracteres alfabéticos.
    {3,18}: Indica que el grupo anterior debe ocurrir entre 3 y 18 veces.
    \s+: Coincide con uno o más espacios en blanco.
    ([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,36}: Similar al primer grupo, pero permite entre 3 y 36 repeticiones.
    $: Indica el final de la cadena.
    iu: Modificadores que indican que la búsqueda es insensible a mayúsculas y minúsculas y que se debe hacer de manera Unicode
        */
        $mail= $_POST['E-mail'];
        validar_email($mail);
    }
    function validar_email($mail){
        if (preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $_POST['E-mail'])) {
            // El correo es válido
            echo 'Email valido';
            echo "<br/>";
        } else {
            // El correo no es válido
            echo ' email Incorrecto';
            echo "<br/>";
        } 
    }
?>