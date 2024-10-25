<?php
include '5.php';
$dos_ruedas = new Dos_ruedas("rojo", 150);
$dos_ruedas->añadir_persona(70);
echo "Peso total después de añadir persona: " . $dos_ruedas->getpeso() . " kg\n";
$dos_ruedas->repintar("verde");
$dos_ruedas->setcilindrada(1000);

echo Vehiculo::ver_atributo($dos_ruedas) . "\n";

$camion = new Camion(10, "blanco", 6000, 2);
$camion->añadir_persona(84);
$camion->repintar("azul");
echo Vehiculo::ver_atributo($camion) . "\n";
?>