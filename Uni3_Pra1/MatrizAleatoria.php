<?php
$ar = array (array(),
             array(),
             array(),
             array());

for($i=0;$i<=4;$i++){
    for($j=0;$j<=4;$j++){
    $ar[$i][$j]=rand(1, 100);
    echo $ar[$i][$j];
    echo " ";
    }
}
for ($i = 0; $i <4; $i++){
        $suma+=$ar[$i][$i];
    
        $suma1+=$ar[3-$i][$i];
}
    echo "<br>";
    echo " El resultado de la suma de la diagonal principal es $suma";
    echo "<br>";
    echo "El resultado de la diagonal invertida es $suma1";

?>