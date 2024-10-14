<?php

$palabra="ala";
function cadena ($palabra){
$cadenainvertida = strrev($palabra);
if($palabra==$cadenainvertida){
echo "La palabra $palabra es un polindromo";
}
else{
    echo "La palabra $palabra no es un polindromo";
}
}
$res=cadena($palabra);
echo $res;
?>