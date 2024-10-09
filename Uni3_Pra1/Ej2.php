<?php
$idioma= array(array(1,14,8,3),
                array(6,19,7,2),
                array(3,13,4,1));
for($i=0;$i<count($idioma);$i++){
    for($j=0;$j<count($idioma[$i]);$j++){
        echo $idioma[$i][$j];
        echo " ";
    }
    echo "<br>";

}


?>