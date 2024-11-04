<?php
$valor = " Es tu nombre O\'reilly?";
$resultado = trim($valor);
echo $resultado;
$resultado = stripslashes($valor);
echo $resultado;

/*
$_SERVER['PHP_SELF'] en un script en la dirección 
http://example.com/foo/bar.php sería /foo/bar.php .
La constante __FILE__ contiene la ruta completa y 
el nombre del archivo actual (es decir, incluido). 
Si PHP se ejecuta como un procesador de línea de 
comandos, esta variable contiene el nombre del script.
*/
?>