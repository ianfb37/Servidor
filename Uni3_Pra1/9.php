<?php
$ar = array (array(),
array(),
array(),
array());
$mayor=0;
$suma=array();
$pos1=0;


for($i=0;$i<=20;$i++){
for($j=0;$j<=20;$j++){
$ar[$i][$j]=rand(1, 100);
echo " ";
    $suma[$i]=$suma[$i]+$ar[$i][$j];

}
echo "<br>";
if($suma[$i]>$mayor){
    $mayor=$suma[$i];
    $pos1=$i;
}
}
    for($j=0;$j<=20;$j++){
        
   echo $ar[$pos1][$j];
    echo "<br>";

    }
    echo "La suma es $mayor";
?>