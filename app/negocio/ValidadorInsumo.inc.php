<?php

include_once 'Validador.inc.php';

class ValidadorInsumo extends Validador {

    private $error_insumo;
    private $error_existencias;
    private $error_reOrden;
    private $error_proveedor;
    private $error_categoria;
    private $error_unidad;
    private $error_nota;

    public function __construct($clave, $insumo, $existencias, $reOrden, $proveedor, $categoria, $unidad, $nota, $conexion) {

        $this->insumo = "";
        $this->existencias = "";
        $this->reOrden = "";
        $this->proveedor = "";
        $this->categoria = "";
        $this->unidad = "";
        $this->nota = $this->preparar_variable($nota);

        if (strcmp($clave, 'insertar') == 0) {
            $this->error_insumo = $this->validar_insumo($insumo, $conexion);
        }else{
            $this->error_insumo = $this->validar_insumo_actualizar($clave, $insumo, $conexion);
        }

        $this->error_existencias = $this->validar_existencias($existencias);
        $this->error_reOrden = $this->validar_reOrden($reOrden);
        $this->error_proveedor = $this->validar_proveedor($proveedor, $conexion);
        $this->error_categoria = $this->validar_categoria($categoria, $conexion);
        $this->error_unidad = $this->validar_unidad($unidad, $conexion);
        $this->error_nota = $this->validar_nota($nota);
    }

    private function validar_insumo_actualizar($clave, $insumo, $conexion) {
        if (!$this->variable_iniciada($insumo)) {
            return "Debes insertar nombre del insumo";
        } else {
            $this->insumo = $this->preparar_variable($insumo);
        }if (!$this->en_limite_sup($this->eliminar_espacios($insumo), 30)) {
            return "El nombre es largo, no valido";
        }if (!$this->en_limite_inf($this->eliminar_espacios($insumo), 2)) {
            return "EL nombre es corto, no valido";
        }if (RepositorioInsumo::existe_insumo_en_otro_reg($clave, $insumo, $conexion)) {
            return "Ya hay un insumo con este nombre";
        }
        return "";
    }

    private function validar_insumo($insumo, $conexion) {
        if (!$this->variable_iniciada($insumo)) {
            return "Debes insertar nombre del insumo";
        } else {
            $this->insumo = $this->preparar_variable($insumo);
        }if (!$this->en_limite_sup($this->eliminar_espacios($insumo), 30)) {
            return "El nombre es largo, no valido";
        }if (!$this->en_limite_inf($this->eliminar_espacios($insumo), 2)) {
            return "EL nombre es corto, no valido";
        }if (RepositorioInsumo::existe_nombre_insumo($insumo, $conexion)) {
            return "Ya hay un insumo con este nombre";
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
            return "La cantidad puede ser menor a 0";
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

    private function validar_proveedor($clave, $conexion) {
        if (!RepositorioProveedor::existe_clave_proveedor($clave, $conexion)) {
            return "Se ha generado un error con el proveedor";
        } else {
            $this->proveedor = $clave;
        }
        return "";
    }

    private function validar_categoria($clave, $conexion) {
        if (!RepositorioCategoriaInsumo::existe_clave_categoria($clave, $conexion)) {
            return "Se ha generado un error con la categoria";
        } else {
            $this->categoria = $clave;
        }
        return "";
    }

    private function validar_unidad($clave, $conexion) {
        if (!RepositorioUnidad::existe_clave_unidad($clave, $conexion)) {
            return "Se ha generado un error con la unidad";
        } else {
            $this->unidad = $clave;
        }
        return "";
    }

    private function validar_nota($nota) {
        if (!$this->en_limite_sup($this->eliminar_espacios($nota), 100)) {
            return "El comentario es demasiado largo";
        }
        return "";
    }

    function obtener_insumo() {
        return $this->insumo;
    }

    function obtener_existencias() {
        return $this->existencias;
    }

    function obtener_reOrden() {
        return $this->reOrden;
    }

    function obtener_proveedor() {
        return $this->proveedor;
    }

    function obtener_categoria() {
        return $this->categoria;
    }

    function obtener_unidad() {
        return $this->unidad;
    }

    function obtener_nota() {
        return $this->nota;
    }

    function obtener_error_insumo() {
        return $this->error_insumo;
    }

    function obtener_error_existencias() {
        return $this->error_existencias;
    }

    function obtener_error_reOrden() {
        return $this->error_reOrden;
    }

    function obtener_error_proveedor() {
        return $this->error_proveedor;
    }

    function obtener_error_categoria() {
        return $this->error_categoria;
    }

    function obtener_error_unidad() {
        return $this->error_unidad;
    }

    function obtener_error_nota() {
        return $this->error_nota;
    }

    function limpiar_datos_validador() {
        $this->insumo = "";
        $this->existencias = "";
        $this->reOrden = "";
        $this->proveedor = "";
        $this->categoria = "";
        $this->unidad = "";
        $this->nota = "";
    }

    function limpiar_errores_validador() {
        $this->error_insumo = "";
        $this->error_existencias = "";
        $this->error_reOrden = "";
        $this->error_proveedor = "";
        $this->error_categoria = "";
        $this->error_unidad = "";
        $this->error_nota = "";
    }

    function informacion_valida() {
        if ($this->error_insumo == "" && $this->error_existencias == "" && $this->error_reOrden == "" && $this->error_proveedor == "" && $this->error_categoria == "" && $this->error_unidad == "" && $this->error_nota == "") {
            return true;
        } else {
            return false;
        }
    }

}
