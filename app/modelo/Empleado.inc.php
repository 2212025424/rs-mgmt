<?php

class Empleado {

    private $clave;
    private $cvl_puesto;
    private $nombre;
    private $apaterno;
    private $amaterno;
    private $fechaNac;
    private $fechaReg;

    function __construct($clave, $cvl_puesto, $nombre, $apaterno, $amaterno, $fechaNac, $fechaReg) {
        $this->clave = $clave;
        $this->cvl_puesto = $cvl_puesto;
        $this->nombre = $nombre;
        $this->apaterno = $apaterno;
        $this->amaterno = $amaterno;
        $this->fechaNac = $fechaNac;
        $this->fechaReg = $fechaReg;
    }

    function getClave() {
        return $this->clave;
    }

    function getCvl_puesto() {
        return $this->cvl_puesto;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApaterno() {
        return $this->apaterno;
    }

    function getAmaterno() {
        return $this->amaterno;
    }

    function getFechaNac() {
        return $this->fechaNac;
    }

    function getFechaReg() {
        return $this->fechaReg;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setCvl_puesto($cvl_puesto) {
        $this->cvl_puesto = $cvl_puesto;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApaterno($apaterno) {
        $this->apaterno = $apaterno;
    }

    function setAmaterno($amaterno) {
        $this->amaterno = $amaterno;
    }

    function setFechaNac($fechaNac) {
        $this->fechaNac = $fechaNac;
    }

    function setFechaReg($fechaReg) {
        $this->fechaReg = $fechaReg;
    }

}
