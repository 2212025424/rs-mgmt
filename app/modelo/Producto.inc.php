<?php

class Producto {

    private $clave;
    private $cvl_proveedor;
    private $cvl_area;
    private $cvl_categoria;
    private $cvl_unidad;
    private $producto;
    private $existencias;
    private $reOrden;
    private $precio;
    private $nota;
    private $estado;

    function __construct($clave, $cvl_proveedor, $cvl_area, $cvl_categoria, $cvl_unidad, $producto, $existencias, $reOrden, $precio, $nota, $estado) {
        $this->clave = $clave;
        $this->cvl_proveedor = $cvl_proveedor;
        $this->cvl_area = $cvl_area;
        $this->cvl_categoria = $cvl_categoria;
        $this->cvl_unidad = $cvl_unidad;
        $this->producto = $producto;
        $this->existencias = $existencias;
        $this->reOrden = $reOrden;
        $this->precio = $precio;
        $this->nota = $nota;
        $this->estado = $estado;
    }

    function getClave() {
        return $this->clave;
    }

    function getCvl_proveedor() {
        return $this->cvl_proveedor;
    }

    function getCvl_area() {
        return $this->cvl_area;
    }

    function getCvl_categoria() {
        return $this->cvl_categoria;
    }

    function getCvl_unidad() {
        return $this->cvl_unidad;
    }

    function getProducto() {
        return $this->producto;
    }

    function getExistencias() {
        return $this->existencias;
    }

    function getReOrden() {
        return $this->reOrden;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getNota() {
        return $this->nota;
    }

    function getEstado() {
        return $this->estado;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setCvl_proveedor($cvl_proveedor) {
        $this->cvl_proveedor = $cvl_proveedor;
    }

    function setCvl_area($cvl_area) {
        $this->cvl_area = $cvl_area;
    }

    function setCvl_categoria($cvl_categoria) {
        $this->cvl_categoria = $cvl_categoria;
    }

    function setCvl_unidad($cvl_unidad) {
        $this->cvl_unidad = $cvl_unidad;
    }

    function setProducto($producto) {
        $this->producto = $producto;
    }

    function setExistencias($existencias) {
        $this->existencias = $existencias;
    }

    function setReOrden($reOrden) {
        $this->reOrden = $reOrden;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setNota($nota) {
        $this->nota = $nota;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

}
