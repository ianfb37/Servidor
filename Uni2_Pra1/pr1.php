<?php
$x=6;
$y=6;
$resul;
if($x==$y){
$resul=$x*$y;
}
else{
    if($x>$y){
        $resul=$x-$y;
    }
    else{
        $resul=$x+$y;
    }
}
echo "El resultado es $resul" ;

?>