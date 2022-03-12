<?php

class Venta {

    private $clave;
    private $cvl_caja;
    private $fecha;
    private $hora;
    private $total;
    private $estado;

    public function __construct($clave, $cvl_caja, $fecha, $hora, $total, $estado) {
        $this->clave = $clave;
        $this->cvl_caja = $cvl_caja;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->total = $total;
        $this->estado = $estado;
    }

    function getClave() {
        return $this->clave;
    }

    function getCvl_caja() {
        return $this->cvl_caja;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getHora() {
        return $this->hora;
    }

    function getTotal() {
        return $this->total;
    }

    function getEstado() {
        return $this->estado;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setCvl_caja($cvl_caja) {
        $this->cvl_caja = $cvl_caja;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

}
