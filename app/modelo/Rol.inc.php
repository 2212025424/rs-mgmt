<?php

class Rol {

    private $clave;
    private $rol;

    function __construct($clave, $rol) {
        $this->clave = $clave;
        $this->rol = $rol;
    }

    function getClave() {
        return $this->clave;
    }

    function getRol() {
        return $this->rol;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setRol($rol) {
        $this->rol = $rol;
    }

}
