<?php

class Categoria {

    private $clave;
    private $categoria;

    function __construct($clave, $categoria) {
        $this->clave = $clave;
        $this->categoria = $categoria;
    }

    function getClave() {
        return $this->clave;
    }

    function getCategoria() {
        return $this->categoria;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

}
