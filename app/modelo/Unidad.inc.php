<?php

class Unidad {

    private $clave;
    private $unidad;

    function __construct($clave, $unidad) {
        $this->clave = $clave;
        $this->unidad = $unidad;
    }

    function getClave() {
        return $this->clave;
    }

    function getUnidad() {
        return $this->unidad;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setUnidad($unidad) {
        $this->unidad = $unidad;
    }

}
