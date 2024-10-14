<?php
$numeros=array(1,2,3,4,5,6,7,8,9,10,11,12);
$nuevos=array();
$limite=6;
function impr($numeros,$nuevos,$limite){
    $cont=0;
for($i=0;$i<count($numeros);$i++){
if($numeros[$i]<$limite){
    $cont++;
$nuevos[$cont]=$numeros[$i];
}
}
return $nuevos;
}
$resultado=impr($numeros,$nuevos,$limite);
var_dump($resultado);
?>