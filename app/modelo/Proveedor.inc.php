<?php

class Proveedor {

    private $clave;
    private $razonsocial;
    private $RFC;
    private $telefono;
    private $correo;
    private $nota;

    function __construct($clave, $razonsocial, $RFC, $telefono, $correo, $nota) {
        $this->clave = $clave;
        $this->razonsocial = $razonsocial;
        $this->RFC = $RFC;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->nota = $nota;
    }

    function getClave() {
        return $this->clave;
    }

    function getRazonsocial() {
        return $this->razonsocial;
    }

    function getRFC() {
        return $this->RFC;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getNota() {
        return $this->nota;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setRazonsocial($razonsocial) {
        $this->razonsocial = $razonsocial;
    }

    function setRFC($RFC) {
        $this->RFC = $RFC;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setNota($nota) {
        $this->nota = $nota;
    }

}
