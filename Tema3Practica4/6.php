<?php
abstract class Vehiculo {
    private $color;
    private $peso;
    protected static $numero_cambio_color = 0; // Atributo estático protegido
    const SALTO_DE_LINEA = '<br />'; // Constante SALTO_DE_LINEA

    public function __construct($color, $peso) {
        $this->color = $color;
        $this->peso = $peso;
    }

    public function __toString() {
        return "Color y peso: " . $this->color . " " . $this->peso;
    }

    public function circula() {
        return "El vehiculo circula";
    }

    public static function ver_atributo($vehiculo) {
        $atributos = "Color: {$vehiculo->color}, Peso: {$vehiculo->peso}";
        if (method_exists($vehiculo, 'getnumero_puertas')) {
            $atributos .= ", Numero Puertas: {$vehiculo->getnumero_puertas()}";
        }
        if (method_exists($vehiculo, 'getcilindrada')) {
            $atributos .= ", Cilindrada: {$vehiculo->getcilindrada()}";
        }
        if (method_exists($vehiculo, 'getlongitud')) {
            $atributos .= ", Longitud: {$vehiculo->getlongitud()}";
        }
        if (method_exists($vehiculo, 'getnumero_cadenas_nieve')) {
            $atributos .= ", Numero Cadenas de nieve: {$vehiculo->getnumero_cadenas_nieve()}";
        }
        return str_replace("\n", self::SALTO_DE_LINEA, $atributos);
    }

    public function setcolor($color) {
        $this->color = $color;
        self::$numero_cambio_color++; // Incrementar contador de cambios de color
    }

    public function getcolor() {
        return $this->color;
    }

    public function setpeso($peso_persona) {
        if ($peso_persona > 2100) {
            $peso_persona = 2100; // Limitar el peso a un máximo de 2100 kg
        }
        $this->peso = $peso_persona;
    }

    public function getpeso() {
        return $this->peso;
    }

    public static function getNumeroCambioColor() {
        return self::$numero_cambio_color;
    }

    public abstract function añadir_persona($peso_persona);
}

class Cuatro_Ruedas extends Vehiculo {
    private $numero_puertas;

    public function __construct($color, $peso, $numero_puertas) {
        parent::__construct($color, $peso);
        $this->numero_puertas = $numero_puertas;
    }

    public function repintar($color) {
        $this->setcolor($color);
    }

    public function setnumero_puertas($numero_puertas) {
        $this->numero_puertas = $numero_puertas;
    }

    public function getnumero_puertas() {
        return $this->numero_puertas;
    }

    public function añadir_persona($peso_persona) {
        $this->setpeso($this->getpeso() + $peso_persona);
    }
}

class Coche extends Cuatro_Ruedas {
    private $numero_cadenas_nieve;

    public function __construct($color, $peso, $numero_puertas) {
        parent::__construct($color, $peso, $numero_puertas);
        $this->numero_cadenas_nieve = 0; // Inicializar número de cadenas de nieve
    }

    public function setnumero_cadenas_nieve($numero_cadenas_nieve) {
        $this->numero_cadenas_nieve = $numero_cadenas_nieve;
    }

    public function getnumero_cadenas_nieve() {
        return $this->numero_cadenas_nieve;
    }

    public function añadir_persona($peso_persona) {
        parent::añadir_persona($peso_persona);
        if ($this->getpeso() >= 1500 && $this->getnumero_cadenas_nieve() <= 2) {
            return "Atención, ponga 4 cadenas para la nieve.";
        }
        return "";
    }

    public function añadir_cadenas_nieve($num) {
        $this->setnumero_cadenas_nieve($this->getnumero_cadenas_nieve() + $num);
    }

    public function quitar_cadenas_nieve($num) {
        $this->setnumero_cadenas_nieve(max(0, $this->getnumero_cadenas_nieve() - $num));
    }
}

class Camion extends Cuatro_Ruedas {
    private $longitud;

    public function __construct($longitud, $color, $peso, $numero_puertas) {
        parent::__construct($color, $peso, $numero_puertas);
        $this->longitud = $longitud;
    }

    public function __toString() {
        return "La longitud es " . $this->longitud . ", el color es " . $this->getcolor() . ", el peso es " . $this->getpeso() . ", y el número de puertas es " . $this->getnumero_puertas() . ".";
    }

    public function setlongitud($longitud) {
        $this->longitud = $longitud;
    }

    public function getlongitud() {
        return $this->longitud;
    }

    public function añadir_remolque($longitud_remolque) {
        $this->setlongitud($this->getlongitud() + $longitud_remolque);
    }
}

class Dos_ruedas extends Vehiculo {
    private $cilindrada;

    public function setcilindrada($cilindrada) {
        $this->cilindrada = $cilindrada;
    }

    public function getcilindrada() {
        return $this->cilindrada;
    }

    public function poner_gasolina($litros) {
        $this->setpeso($this->getpeso() + $litros);
    }

    public function repintar($color) {
        $this->setcolor($color);
    }

    public function añadir_persona($peso_persona) {
        // Más 2K de casco
        $this->setpeso($this->getpeso() + $peso_persona + 2);
    }
}
?>