<?php
$paga=20;
$horas=50;
$total=0;
if($horas>40){
    $total=40*$paga;
    $horas=$horas-40;
    if($horas>8){
        $horas=$horas-8;
        $total=(($paga*8)*2)+$total;
        $total=(($paga*$horas)*3)+$total;
    }
}
echo "El total de ganacias es " . $total;
?>