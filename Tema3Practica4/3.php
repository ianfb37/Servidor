<?php
class Vehiculo{
private $color;
private $peso;
public function __construct($color,$peso){
$this->color=$color;
$this->peso=$peso;
}
public function __toString()
{
return "Color y peso"."  ".$this->color."  ".$this->peso;
}
public function circula(){
return "El vehiculo circula";
}

public function setcolor($color){
$this->color=$color;
}
public function getcolor(){
return $this->color;
}
public function setpeso($peso_persona){
    $this->peso= $peso_persona;
}
public function getpeso(){
    return $this->peso;
    }
public function añadir_persona($peso_persona){
    $this->peso=$this->peso+$peso_persona;
}
}


class Cuatro_Ruedas extends Vehiculo{
    private $numero_puertas;
   public function repintar($color){
    $this->setcolor($color);
    }
    public function setnumero_puertas($numero_puertas){
        $this->numero_puertas= $numero_puertas;
    }
    public function getnumero_puertas(){
        return $this->numero_puertas;
        }
   
}
class Coche extends Cuatro_Ruedas{
    private $numero_cadenas_nieve;
    public function setnumero_cadenas_nieve($numero_cadenas_nieve){
        $this->numero_cadenas_nieve= $numero_cadenas_nieve;
    }
    public function getnumero_cadenas_nieve(){
        return $this->numero_cadenas_nieve;
        }
    public function añadir_cadenas_nieve($num){
        $this->setnumero_cadenas_nieve($this->numero_cadenas_nieve+$this->getnumero_cadenas_nieve($num));
    }
    
    public function quitar_cadenas_nieve($num){
        $this->setnumero_cadenas_nieve($this->numero_cadenas_nieve-$this->getnumero_cadenas_nieve($num));
    }
}
class Camion extends Cuatro_Ruedas{
    private $longitud;
    public function __construct($longitud,$color,$peso,$numero_puertas){
        $this->longitud=$longitud;
        $this->setcolor($color);
        $this->setpeso($peso);
        $this->setnumero_puertas($numero_puertas);
    }
    public function __toString() {
        return "La longitud es " . $this->longitud . ", el color es " . $this->getcolor() . ", el peso es " . $this->getpeso() . ", y el número de puertas es " . $this->getnumero_puertas() . ".";
    }
    public function setlongitud($longitud){
        $this->longitud= $longitud;
    }
    public function getlongitud(){
        return $this->longitud;
        }
    public function añadir_remolque($longitud_remolque){
        $this->setlongitud($this->getlongitud($this->longitud+$longitud_remolque));
    }
}
class Dos_ruedas extends Vehiculo{
    private $cilindrada;
    public function setlongitud($cilindrada){
        $this->cilindrada= $cilindrada;
    }
    public function getlongitud(){
        return $this->cilindrada;
        }
    public function poner_gasolina($litros){
        $this->setpeso($this->getpeso()+$litros);
    }
}
?>