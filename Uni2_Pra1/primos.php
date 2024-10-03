<?php
for($i=0;$i<=50;$i++){
    echo "<br>";
if($i%2!=0){
    echo "El numero $i es primo";
}
else{
    if($i==2){
    echo "El numero 2 es primo";
    }
    else{
        echo "El numero $i no es primo ";
    }
}
}
?>