<?php

class BiciElectrica {

    private $id;
    private $coordx;
    private $coordy;
    private $bateria;
    private $operativa;


    function __construct(int $id, int $coordx, int $coordy, int $bateria, bool $operativa) {

        $this->id = $id;
        $this->coordx = $coordx;
        $this->coordy = $coordy;
        $this->bateria = $bateria;
        $this->operativa = $operativa;
    }

    function __set($name, $value) {

        if (property_exists($this, $name)) {

            $this->$name = $value;
        }
    }

    function __get($name) {

        if (property_exists($this, $name)) {

            return $this->$name;
        }
    }

    function __toString() {

        return $this->id . " : " . $this->bateria. "%";
    }

    function distancia($x, $y): int {

        $distanciaX = $x - $this->coordx;
        $distanciaY = $y - $this->coordy;

        return intval(sqrt($distanciaX ** 2 + $distanciaY ** 2));
    }
}

?>