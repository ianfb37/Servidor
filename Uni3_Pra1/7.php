<?php
$ar = array (array(),
array(),
array(),
array());
$mayor=0;
$mayores=array();
$promedio=array();
$acu=0;

for($i=0;$i<=4;$i++){
for($j=0;$j<=5;$j++){
$ar[$i][$j]=rand(1, 100);
echo $ar[$i][$j];
echo " ";
if($ar[$i][$j]>$mayor){
    $mayor =$ar[$i][$j];
}
$promedi=$promedi+$ar[$i][$j];
}
$promedio[$i]=$promedi/5;
$mayores[$i]=$mayor;
}
for($i=0;$i<=4;$i++){
echo"<br>";
echo "El mayor de cada fila es ";
echo $mayores[$i];
echo"<br>";
echo "El promedio de cada fila es ";
echo $promedio[$i];
}
?>