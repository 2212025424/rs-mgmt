<?php

include_once 'Validador.inc.php';

class ValidadorProducto extends Validador {

    private $error_cvl_proveedor;
    private $error_cvl_area;
    private $error_cvl_categoria;
    private $error_cvl_unidad;
    private $error_producto;
    private $error_existencias;
    private $error_reOrden;
    private $error_precio;
    private $error_nota;

    public function __construct($clave, $cvl_proveedor, $cvl_area, $cvl_categoria, $cvl_unidad, $producto, $existencias, $reOrden, $precio, $nota, $conexion) {

        $this->cvl_proveedor = "";
        $this->cvl_area = "";
        $this->cvl_categoria = "";
        $this->cvl_unidad = "";
        $this->producto = "";
        $this->existencias = "";
        $this->reOrden = "";
        $this->precio = "";
        $this->nota = $this->preparar_variable($nota);

        if (strcmp($clave, 'registrar') == 0) {
            $this->error_producto = $this->validar_producto($producto, $conexion);
        } else {
            $this->error_producto = $this->validar_producto_actualizar($clave, $producto, $conexion);
        }

        $this->error_cvl_proveedor = $this->validar_cvl_proveedor($cvl_proveedor, $conexion);
        $this->error_cvl_area = $this->validar_cvl_area($cvl_area, $conexion);
        $this->error_cvl_categoria = $this->validar_cvl_categoria($cvl_categoria, $conexion);
        $this->error_cvl_unidad = $this->validar_cvl_unidad($cvl_unidad, $conexion);
        //Validacion del producto
        $this->error_existencias = $this->validar_existencias($existencias);
        $this->error_reOrden = $this->validar_reOrden($reOrden);
        $this->error_precio = $this->validar_precio($precio);
        $this->error_nota = $this->validar_nota($nota);
    }

    private function validar_cvl_proveedor($cvl_proveedor, $conexion) {
        if (!RepositorioProveedor::existe_clave_proveedor($cvl_proveedor, $conexion)) {
            return "Se ha generado un error";
        } else {
            $this->cvl_proveedor = $cvl_proveedor;
        }
        return "";
    }

    private function validar_cvl_area($cvl_area, $conexion) {
        if (!RepositorioAreaProduccion::existe_clave_area($cvl_area, $conexion)) {
            return "Se ha generado un error";
        } else {
            $this->cvl_area = $cvl_area;
        }
        return "";
    }

    private function validar_cvl_categoria($cvl_categoria, $conexion) {
        if (!RepositorioCategoriaProducto::existe_clave_categoria($cvl_categoria, $conexion)) {
            return "Se ha generado un error";
        } else {
            $this->cvl_categoria = $cvl_categoria;
        }
        return "";
    }

    private function validar_cvl_unidad($cvl_unidad, $conexion) {
        if (!RepositorioUnidad::existe_clave_unidad($cvl_unidad, $conexion)) {
            return "Se ha generado un error";
        } else {
            $this->cvl_unidad = $cvl_unidad;
        }
        return "";
    }

    private function validar_producto_actualizar($clave, $nombre_pro, $conexion) {
        if (!$this->variable_iniciada($nombre_pro)) {
            return "Debes insertar nombre del producto";
        } else {
            $this->producto = $this->preparar_variable($nombre_pro);
        }if (!$this->en_limite_sup($this->eliminar_espacios($nombre_pro), 30)) {
            return "El nombre es largo, no valido";
        }if (!$this->en_limite_inf($this->eliminar_espacios($nombre_pro), 2)) {
            return "EL nombre es corto, no valido";
        }if (RepositorioProducto::existe_nombre_producto_en_otro_reg($clave, $nombre_pro, $conexion)) {
            return "Ya hay un producto con este nombre";
        }
        return "";
    }

    private function validar_producto($producto, $conexion) {
        if (!$this->variable_iniciada($producto)) {
            return "Debes insertar nombre del producto";
        } else {
            $this->producto = $this->preparar_variable($producto);
        }if (!$this->en_limite_sup($this->eliminar_espacios($producto), 30)) {
            return "El nombre es largo, no valido";
        }if (!$this->en_limite_inf($this->eliminar_espacios($producto), 2)) {
            return "EL nombre es corto, no valido";
        }if (RepositorioProducto::existe_nombre_producto($producto, $conexion)) {
            return "Ya hay un producto con este nombre";
        }
        return "";
    }

    private function validar_existencias($existencias) {
        if (!$this->variable_iniciada($existencias)) {
            return "Ingresa una cantidad";
        } else {
            $this->existencias = $existencias;
        }if (!$this->es_numerico($existencias)) {
            return "No valido, solo ingresa numeros";
        }if ($existencias < 0) {
            return "La cantidad no puede ser menor a 0";
        }
        return "";
    }

    private function validar_reOrden($reorden) {
        if (!$this->variable_iniciada($reorden)) {
            return "Debes insertar una cantidad";
        } else {
            $this->reOrden = $reorden;
        }if (!$this->es_numerico($reorden)) {
            return "No valido, solo ingresa numeros";
        }if ($reorden < 0) {
            return "La cantidad no puede ser menor a 0";
        }
        return "";
    }

    private function validar_precio($precio) {
        if (!$this->variable_iniciada($precio)) {
            return "Debes insertar un precio";
        } else {
            $this->precio = $precio;
        }if (!$this->es_numerico($precio)) {
            return "No valido, solo ingresa numeros";
        }if ($precio < 0) {
            return "La cantidad no puede ser menor a 0";
        }
        return "";
    }

    private function validar_nota($nota) {
        if (!$this->en_limite_sup($this->eliminar_espacios($nota), 100)) {
            return "El comentario es demasiado largo";
        }
        return "";
    }

    function obtener_cvl_proveedor() {
        return $this->cvl_proveedor;
    }

    function obtener_cvl_area() {
        return $this->cvl_area;
    }

    function obtener_cvl_categoria() {
        return $this->cvl_categoria;
    }

    function obtener_cvl_unidad() {
        return $this->cvl_unidad;
    }

    function obtener_producto() {
        return $this->producto;
    }

    function obtener_existencias() {
        return $this->existencias;
    }

    function obtener_reOrden() {
        return $this->reOrden;
    }

    function obtener_precio() {
        return $this->precio;
    }

    function obtener_nota() {
        return $this->nota;
    }

    function obtener_error_cvl_proveedor() {
        return $this->error_cvl_proveedor;
    }

    function obtener_error_cvl_area() {
        return $this->error_cvl_area;
    }

    function obtener_error_cvl_categoria() {
        return $this->error_cvl_categoria;
    }

    function obtener_error_cvl_unidad() {
        return $this->error_cvl_unidad;
    }

    function obtener_error_producto() {
        return $this->error_producto;
    }

    function obtener_error_existencias() {
        return $this->error_existencias;
    }

    function obtener_error_reOrden() {
        return $this->error_reOrden;
    }

    function obtener_error_precio() {
        return $this->error_precio;
    }

    function obtener_error_nota() {
        return $this->error_nota;
    }

    function limpiar_datos_validador() {
        $this->cvl_proveedor = "";
        $this->cvl_area = "";
        $this->cvl_categoria = "";
        $this->cvl_unidad = "";
        $this->producto = "";
        $this->existencias = "";
        $this->reOrden = "";
        $this->precio = "";
        $this->nota = "";
    }

    function limpiar_errores_validador() {
        $this->error_producto = "";
        $this->error_cvl_proveedor = "";
        $this->error_cvl_area = "";
        $this->error_cvl_categoria = "";
        $this->error_cvl_unidad = "";
        $this->error_existencias = "";
        $this->error_reOrden = "";
        $this->error_precio = "";
        $this->error_nota = "";
    }

    function informacion_valida() {
        if ($this->error_cvl_proveedor == "" &&
                $this->error_cvl_area == "" &&
                $this->error_cvl_categoria == "" &&
                $this->error_cvl_unidad == "" &&
                $this->error_producto == "" &&
                $this->error_existencias == "" &&
                $this->error_reOrden == "" &&
                $this->error_precio == "" &&
                $this->error_nota == "") {
            return true;
        } else {
            return false;
        }
    }

}
