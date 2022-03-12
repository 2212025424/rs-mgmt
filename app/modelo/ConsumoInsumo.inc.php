<?php

class ConsumoInsumo {

    private $cvl_producto;
    private $cvl_insumo;
    private $numproductos;
    private $cantidadMin;
    private $cantidadMax;

    function __construct($cvl_producto, $cvl_insumo, $numproductos, $cantidadMin, $cantidadMax) {
        $this->cvl_producto = $cvl_producto;
        $this->cvl_insumo = $cvl_insumo;
        $this->numproductos = $numproductos;
        $this->cantidadMin = $cantidadMin;
        $this->cantidadMax = $cantidadMax;
    }

    function getCvl_producto() {
        return $this->cvl_producto;
    }

    function getCvl_insumo() {
        return $this->cvl_insumo;
    }

    function getNumproductos() {
        return $this->numproductos;
    }

    function getCantidadMin() {
        return $this->cantidadMin;
    }

    function getCantidadMax() {
        return $this->cantidadMax;
    }

    function setCvl_producto($cvl_producto) {
        $this->cvl_producto = $cvl_producto;
    }

    function setCvl_insumo($cvl_insumo) {
        $this->cvl_insumo = $cvl_insumo;
    }

    function setNumproductos($numproductos) {
        $this->numproductos = $numproductos;
    }

    function setCantidadMin($cantidadMin) {
        $this->cantidadMin = $cantidadMin;
    }

    function setCantidadMax($cantidadMax) {
        $this->cantidadMax = $cantidadMax;
    }

}
