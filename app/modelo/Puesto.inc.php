<?php

class Puesto {

    private $clave;
    private $puesto;
    private $nota;

    function __construct($clave, $puesto, $nota) {
        $this->clave = $clave;
        $this->puesto = $puesto;
        $this->nota = $nota;
    }

    function getClave() {
        return $this->clave;
    }

    function getPuesto() {
        return $this->puesto;
    }

    function getNota() {
        return $this->nota;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setPuesto($puesto) {
        $this->puesto = $puesto;
    }

    function setNota($nota) {
        $this->nota = $nota;
    }

}
