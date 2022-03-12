<?php

class AreaProduccion {

    private $clave;
    private $area;

    function __construct($clave, $area) {
        $this->clave = $clave;
        $this->area = $area;
    }

    function getClave() {
        return $this->clave;
    }

    function getArea() {
        return $this->area;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setArea($area) {
        $this->area = $area;
    }

}
