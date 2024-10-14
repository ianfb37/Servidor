<?php

function ecuacion($a,$b,$c){
    $sol1=0;

    $sol1=($b**2)-(4*$a*$c);
    if($sol1<0){
    echo "No hay soluciones";
    }
    else{
    if($sol1==0){
    echo -$b/(2*$a);
    }
    else{
    $sol1=(-$b+sqrt($b**2-(4*$a*$c)))/(2*$a);
    echo "<br>";
    $sol2=(-$b-sqrt($b**2-(4*$a*$c)))/(2*$a);
    return array($sol1,$sol2);    
}
    }
}
?>>