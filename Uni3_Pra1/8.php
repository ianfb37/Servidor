<?php
$ar = array (array(),
array(),
array(),
array());
$mayor=0;
$pos1=0;
$pos2=0;

for($i=0;$i<=10;$i++){
for($j=0;$j<=10;$j++){
$ar[$i][$j]=rand(1, 100);
echo $ar[$i][$j];
echo " ";
if($ar[$i][$j]>$mayor){
    $mayor=$ar[$i][$j];
    $pos1=$i;
    $pos2=$j;
}
}
echo "<br>";

}
echo"El numero mayor esta en la posicion $pos1 $pos2";

?>