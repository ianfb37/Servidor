<?php
$ar = array (array(),
array(),
array(),
array(),
array());
for($i=0;$i<=3;$i++){
    for($j=0;$j<=5;$j++){
    $ar[$i][$j]=rand(1, 100);
    echo $ar[$i][$j];
    echo " ";
    }
}
for($i=0;$i<=3;$i++){
    for($j=0;$j<=5;$j++){

    echo $ar[$i][$j];
    echo "<br> ";
    }
}
?>