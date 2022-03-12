<?php

class Mesa {

    private $clave;
    private $mesa;
    private $estado;

    function __construct($clave, $mesa, $estado) {
        $this->clave = $clave;
        $this->mesa = $mesa;
        $this->estado = $estado;
    }

    function getClave() {
        return $this->clave;
    }

    function getMesa() {
        return $this->mesa;
    }

    function getEstado() {
        return $this->estado;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setMesa($mesa) {
        $this->mesa = $mesa;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

}
