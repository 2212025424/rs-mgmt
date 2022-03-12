<?php

class CajaApertura {

    private $clave;
    private $cvl_caja;
    private $cvl_cajero;
    private $montoApertura;
    private $estado;

    function __construct($clave, $cvl_caja, $cvl_cajero, $montoApertura, $estado) {
        $this->clave = $clave;
        $this->cvl_caja = $cvl_caja;
        $this->cvl_cajero = $cvl_cajero;
        $this->montoApertura = $montoApertura;
        $this->estado = $estado;
    }

    function getClave() {
        return $this->clave;
    }

    function getCvl_caja() {
        return $this->cvl_caja;
    }

    function getCvl_cajero() {
        return $this->cvl_cajero;
    }

    function getMontoApertura() {
        return $this->montoApertura;
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

    function setCvl_cajero($cvl_cajero) {
        $this->cvl_cajero = $cvl_cajero;
    }

    function setMontoApertura($montoApertura) {
        $this->montoApertura = $montoApertura;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

}
