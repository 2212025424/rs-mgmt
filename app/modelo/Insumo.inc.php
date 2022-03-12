<?php

class Insumo {

    private $clave;
    private $cvl_proveedor;
    private $cvl_categoria;
    private $cvl_unidad;
    private $insumo;
    private $existencias;
    private $reorden;
    private $nota;

    function __construct($clave, $cvl_proveedor, $cvl_categoria, $cvl_unidad, $insumo, $existencias, $reorden, $nota) {
        $this->clave = $clave;
        $this->cvl_proveedor = $cvl_proveedor;
        $this->cvl_categoria = $cvl_categoria;
        $this->cvl_unidad = $cvl_unidad;
        $this->insumo = $insumo;
        $this->existencias = $existencias;
        $this->reorden = $reorden;
        $this->nota = $nota;
    }

    function getClave() {
        return $this->clave;
    }

    function getCvl_proveedor() {
        return $this->cvl_proveedor;
    }

    function getCvl_categoria() {
        return $this->cvl_categoria;
    }

    function getCvl_unidad() {
        return $this->cvl_unidad;
    }

    function getInsumo() {
        return $this->insumo;
    }

    function getExistencias() {
        return $this->existencias;
    }

    function getReorden() {
        return $this->reorden;
    }

    function getNota() {
        return $this->nota;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setCvl_proveedor($cvl_proveedor) {
        $this->cvl_proveedor = $cvl_proveedor;
    }

    function setCvl_categoria($cvl_categoria) {
        $this->cvl_categoria = $cvl_categoria;
    }

    function setCvl_unidad($cvl_unidad) {
        $this->cvl_unidad = $cvl_unidad;
    }

    function setInsumo($insumo) {
        $this->insumo = $insumo;
    }

    function setExistencias($existencias) {
        $this->existencias = $existencias;
    }

    function setReorden($reorden) {
        $this->reorden = $reorden;
    }

    function setNota($nota) {
        $this->nota = $nota;
    }

}
