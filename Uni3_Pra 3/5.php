<?php
//Utilizacion de funciones por defecto
$valor=5;
//Si la variable esta inicializada devuelve true;
var_dump(isset($valor));
echo"<br>";
//Devuelve true si la variable es Null
var_dump(is_null($valor));
//Devuelve TRUE si la variable no esta inicializada o su valor es FALSE
echo"<br>";
echo "separacion ";
var_dump(empty($valor));
//Devuelve la longitud de una cadena
$cadena="Hola";
echo"<br>";
echo" La longitud de la palabra es ";
echo strlen($cadena);
//Devuelve una cadena en minusculas
echo"<br>";
echo" La cadena en minusculas es ";
echo strtolower($cadena);
//Compara dos cadenas devuelve 0 si son iguales
$cadena2="Hola";
echo"<br>";
echo "Comparacion ";
echo strcmp($cadena,$cadena2);
//Devuelve los valores de el array
$ar=array(1,2,3,4,5,6,8,7);
echo"<br>";
echo"Los valores de array son ";
sort($ar);
foreach ($ar as $clave => $valor) {
    echo "[" . $clave . "] = " . $valor . "\n";
}
//Devuelve los valores de el array ordenados por indice
echo"<br>";
echo"Los valores son ";
ksort($ar);
foreach ($ar as $clave => $valor) {
    echo "[" . $clave . "] = " . $valor . "\n";
}
//Devuelve los largo que es un array
echo"<br>";
echo"El array es de ";
echo count($ar);

?>