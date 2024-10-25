<?php
class Vehiculo{
private $color;
private $peso;

public function circula(){

}
public function añadir_persona($peso_persona){
    $this->peso= $peso_persona;
}
public function Setcolor($color){

}
}

class Cuatro_Ruedas extends Vehiculo{
    private $numero_puertas;
   public function repintar($color){
    
    }
   
}
class Coche extends Cuatro_Ruedas{
    private $numero_cadenas_nieve;
    public function añadir_cadenas_nieve($num){

    }
    public function quitar_cadenas_nieve($num){
        
    }
}
class Camion extends Cuatro_Ruedas{
    private $longitud;
    public function añadir_remolque($longitud){

    }
}
class Dos_ruedas extends Vehiculo{
    private $cilindrada;
    public function poner_gasolina($litros){

    }
}
?>