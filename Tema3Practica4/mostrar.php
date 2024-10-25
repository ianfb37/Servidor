<?php
include '3.php';
$coche=new Coche("verde",1400);
echo $coche;
echo "<br>";
$coche->añadir_persona(140);
echo $coche->circula();
echo "<br>";
echo $coche;
$coche->repintar("rojo");
$coche->añadir_cadenas_nieve(2);
echo "<br>";
echo $coche;
$coche_dos=new Dos_ruedas("negro",120);
$coche_dos->añadir_persona(80);
$coche_dos->poner_gasolina(20);
echo "<br>";
echo $coche_dos;
$camion=new Camion(10,"Azul",10000,2);
$camion->añadir_remolque(5);
$camion->añadir_persona(80);
echo "<br>";
echo $camion;
?>