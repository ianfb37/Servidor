<?php
$ar = array (array(),
array(),
array(),
array());
$mayor=0;

for($i=0;$i<=4;$i++){
for($j=0;$j<=5;$j++){
$ar[$i][$j]=rand(1, 100);
echo $ar[$i][$j];
echo " ";
if($ar[$i][$j]>$mayor){
    $mayor =$ar[$i][$j];
}
}
}
echo "<br>";
echo "El numero mayor es $mayor"

?>