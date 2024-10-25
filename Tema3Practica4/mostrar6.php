<?php
include '6.php'; 
$coche = new Coche("verde", 2100, 4);
$coche->añadir_cadenas_nieve(2);
echo $coche->añadir_persona(80) . "\n"; 
$coche->setcolor("azul");
$coche->quitar_cadenas_nieve(4);
$coche->setcolor("negro");
echo Vehiculo::ver_atributo($coche) . "\n";
echo "Número de cambios de color: " . Vehiculo::getNumeroCambioColor() . "\n";
?>