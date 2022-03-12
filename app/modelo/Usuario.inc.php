<?php

class Usuario {

    private $clv_empleado;
    private $clv_rol;
    private $contrasenia;
    private $estado;

    function __construct($clv_empleado, $clv_rol, $contrasenia, $estado) {
        $this->clv_empleado = $clv_empleado;
        $this->clv_rol = $clv_rol;
        $this->contrasenia = $contrasenia;
        $this->estado = $estado;
    }

    function getClv_empleado() {
        return $this->clv_empleado;
    }

    function getClv_rol() {
        return $this->clv_rol;
    }

    function getContrasenia() {
        return $this->contrasenia;
    }

    function getEstado() {
        return $this->estado;
    }

    function setClv_empleado($clv_empleado) {
        $this->clv_empleado = $clv_empleado;
    }

    function setClv_rol($clv_rol) {
        $this->clv_rol = $clv_rol;
    }

    function setContrasenia($contrasenia) {
        $this->contrasenia = $contrasenia;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

}
