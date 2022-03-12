<?php

class DetalleVenta {

    private $cvl_venta;
    private $cvl_producto;
    private $cantidad;
    private $subtotal;

    function __construct($cvl_venta, $cvl_producto, $cantidad, $subtotal) {
        $this->cvl_venta = $cvl_venta;
        $this->cvl_producto = $cvl_producto;
        $this->cantidad = $cantidad;
        $this->subtotal = $subtotal;
    }

    function getCvl_venta() {
        return $this->cvl_venta;
    }

    function getCvl_producto() {
        return $this->cvl_producto;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getSubtotal() {
        return $this->subtotal;
    }

    function setCvl_venta($cvl_venta) {
        $this->cvl_venta = $cvl_venta;
    }

    function setCvl_producto($cvl_producto) {
        $this->cvl_producto = $cvl_producto;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }

}
