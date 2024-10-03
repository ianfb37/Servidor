<?php
$x=rand(1, 50);
if($x%2!=0){
    echo "El numero $x es primo";
}
else{
    if($x==2){
    echo "El numero 2 es primo";
    }
    else{
        echo "El numero $x no es primo ";
    }
}
?>