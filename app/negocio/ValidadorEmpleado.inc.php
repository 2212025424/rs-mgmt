<?php

include_once 'Validador.inc.php';

class ValidadorEmpleado extends Validador {

    private $error_clave;
    private $error_puesto;
    private $error_nombre;
    private $error_apaterno;
    private $error_amaterno;
    private $error_fecha;

    public function __construct($clave, $puesto, $nombre, $apaterno, $amaterno, $fecha, $conexion) {

        $this->clave = "";
        $this->puesto = "";
        $this->nombre = "";
        $this->apaterno = "";
        $this->amaterno = "";
        $this->fecha = "";

        $this->error_clave = $this->validar_clave($clave, $conexion);
        $this->error_puesto = $this->validar_puesto($puesto, $conexion);
        $this->error_nombre = $this->validar_nombre($nombre);
        $this->error_apaterno = $this->validar_apaterno($apaterno);
        $this->error_amaterno = $this->validar_amaterno($amaterno);
        $this->error_fecha = $this->validar_fecha($fecha);

        if (strcmp($clave, 'editando') == 0) {
            $this->error_clave = "";
        }

    }

    private function validar_clave($clave, $conexion) {
        if (!$this->variable_iniciada($clave)) {
            return "Debes insertar puesto";
        } else {
            $this->clave = $clave;
        }if ($this->hay_espacios($clave)) {
            return "No puede contener espacios";
        }if (!$this->en_limite_sup($this->eliminar_espacios($clave), 10)) {
            return "Se requiere 10 caracteres por clave";
        }if (!$this->en_limite_inf($this->eliminar_espacios($clave), 10)) {
            return "Se requiere 10 caracteres por clave";
        }if (RepositorioEmpleado::existe_clave_empleado($clave, $conexion)) {
            return "Ya hay un empleado con esa clave";
        }
        return "";
    }

    private function validar_puesto($puesto, $conexion) {
        if (!$this->variable_iniciada($puesto)) {
            return "Debes insertar puesto";
        } else {
            $this->puesto = $puesto;
        }if (!RepositorioPuesto::existe_clave_puesto($puesto, $conexion)) {
            return "Se genero un error con el puesto";
        }
        return "";
    }

    private function validar_nombre($nombre) {
        if (!$this->variable_iniciada($nombre)) {
            return "Debes insertar nombre";
        } else {
            $this->nombre = $this->preparar_variable($nombre);
        }if (!$this->en_limite_sup($this->eliminar_espacios($nombre), 15)) {
            return "EL nombre es largo, no es valido";
        }if (!$this->en_limite_inf($this->eliminar_espacios($nombre), 3)) {
            return "EL nombre es corto, no es valido";
        }
        return "";
    }

    private function validar_apaterno($apaterno) {
        if (!$this->variable_iniciada($apaterno)) {
            return "Debes insertar apellido";
        } else {
            $this->apaterno = $this->preparar_variable($apaterno);
        }if (!$this->en_limite_sup($this->eliminar_espacios($apaterno), 15)) {
            return "EL apellido es largo, no es valido";
        }if (!$this->en_limite_inf($this->eliminar_espacios($apaterno), 3)) {
            return "EL apellido es corto, no es valido";
        }
        return "";
    }

    private function validar_amaterno($amaterno) {
        if (!$this->variable_iniciada($amaterno)) {
            return "Debes insertar apellido";
        } else {
            $this->amaterno = $this->preparar_variable($amaterno);
        }if (!$this->en_limite_sup($this->eliminar_espacios($amaterno), 15)) {
            return "EL apellido es largo, no es valido";
        }if (!$this->en_limite_inf($this->eliminar_espacios($amaterno), 3)) {
            return "EL apellido es corto, no es valido";
        }
        return "";
    }

    private function validar_fecha($fecha) {
        if (!$this->variable_iniciada($fecha)) {
            return "Debes insertar fecha";
        } else {
            $this->fecha = $fecha;
        } if (!$this->es_formato_fecha($fecha)) {
            return "Fecha incorrecta, verifica el formato";
        }
        return "";
    }

    function obtener_clave() {
        return $this->clave;
    }

    function obtener_puesto() {
        return $this->puesto;
    }

    function obtener_nombre() {
        return $this->nombre;
    }

    function obtener_apaterno() {
        return $this->apaterno;
    }

    function obtener_amaterno() {
        return $this->amaterno;
    }

    function obtener_fecha() {
        return $this->fecha;
    }

    function obtener_error_clave() {
        return $this->error_clave;
    }

    function obtener_error_puesto() {
        return $this->error_puesto;
    }

    function obtener_error_nombre() {
        return $this->error_nombre;
    }

    function obtener_error_apaterno() {
        return $this->error_apaterno;
    }

    function obtener_error_amaterno() {
        return $this->error_amaterno;
    }

    function obtener_error_fecha() {
        return $this->error_fecha;
    }

    function limpiar_datos_validador() {
        $this->clave = "";
        $this->puesto = "";
        $this->nombre = "";
        $this->apaterno = "";
        $this->amaterno = "";
        $this->fecha = "";
    }

    function limpiar_errores_validador() {
        $this->error_clave = "";
        $this->error_puesto = "";
        $this->error_nombre = "";
        $this->error_apaterno = "";
        $this->error_amaterno = "";
        $this->error_fecha = "";
    }

    function informacion_valida() {
        if ($this->error_clave == "" && $this->error_puesto == "" && $this->error_nombre == "" && $this->error_apaterno == "" && $this->error_amaterno == "" && $this->error_fecha == "") {
            return true;
        } else {
            return false;
        }
    }

}
