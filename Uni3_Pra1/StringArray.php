<?php
$confirmado= array(true, true, false, true, false, false);
for($i=0;$i<count($confirmado);$i++){
    echo $confirmado[$i];
    if($i==0){
        echo "El elemento en la posicion $i es $confirmado[$i] ";
        echo "<br>";
    }
    }

?>