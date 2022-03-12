<?php

class Caja {

    private $clave;
    private $caja;
    private $estado;

    function __construct($clave, $caja, $estado) {
        $this->clave = $clave;
        $this->caja = $caja;
        $this->estado = $estado;
    }

    function getClave() {
        return $this->clave;
    }

    function getCaja() {
        return $this->caja;
    }

    function getEstado() {
        return $this->estado;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setCaja($caja) {
        $this->caja = $caja;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

}
