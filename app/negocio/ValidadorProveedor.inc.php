<?php

include_once 'Validador.inc.php';

class ValidadorProveedor extends Validador {

    private $error_razonsocial;
    private $error_RFC;
    private $error_telefono;
    private $error_correo;
    private $error_nota;

    function __construct($clave, $razonsocial, $RFC, $telefono, $correo, $nota, $conexion) {

        $this->razonsocial = "";
        $this->RFC = "";
        $this->telefono = "";
        $this->correo = "";
        $this->nota = $this->preparar_variable($nota);
        
        $this->error_nota = $this->validar_nota($nota);

        if (strcmp($clave, 'registrar') == 0) {
            $this->error_razonsocial = $this->validar_razonsocial($razonsocial, $conexion);
            $this->error_RFC = $this->validar_RFC($RFC, $conexion);
            $this->error_telefono = $this->validar_telefono($telefono, $conexion);
            $this->error_correo = $this->validar_correo($correo, $conexion);
        } else {
            $this->error_razonsocial = $this->validar_razonsocial_actualizar($clave, $razonsocial, $conexion);
            $this->error_RFC = $this->validar_RFC_actualizar($clave, $RFC, $conexion);
            $this->error_telefono = $this->validar_telefono_actualizar($clave, $telefono, $conexion);
            $this->error_correo = $this->validar_correo_actualizar($clave, $correo, $conexion);
        }
    }

    private function validar_razonsocial_actualizar($clave, $razonsocial, $conexion) {
        if (!$this->variable_iniciada($razonsocial)) {
            return "Debes ingresar el nombre de la empresa";
        } else {
            $this->razonsocial = $this->preparar_variable($razonsocial);
        }if (!$this->en_limite_sup($this->eliminar_espacios($razonsocial), 30)) {
            return "EL nombre es largo, no es valido";
        }if (!$this->en_limite_inf($this->eliminar_espacios($razonsocial), 3)) {
            return "EL nombre es corto, no es valido";
        }if (RepositorioProveedor::existe_razonsocial_proveedor_en_otro_reg($clave, $razonsocial, $conexion)) {
            return "EL nombre ya existe";
        }
        return "";
    }

    private function validar_RFC_actualizar($clave, $RFC, $conexion) {
        if (!$this->variable_iniciada($RFC)) {
            return "Debes ingresar el RFC";
        } else {
            $this->RFC = $this->preparar_variable($RFC);
        }if ($this->hay_espacios($RFC)) {
            return "Este campo no puede contener espacios";
        }if (!$this->en_limite_sup($this->eliminar_espacios($RFC), 13)) {
            return "Solo se necesitan 13 caracteres";
        }if (!$this->en_limite_inf($this->eliminar_espacios($RFC), 13)) {
            return "Se necesitan 13 caracteres";
        }if (RepositorioProveedor::existe_rfc_proveedor_en_otro_reg($clave, $RFC, $conexion)) {
            return "Ya hay un proveedor con este rfc";
        }
        return "";
    }

    private function validar_telefono_actualizar($clave, $telefono, $conexion) {
        if (!$this->variable_iniciada($telefono)) {
            return "Debes ingresar el telefono";
        } else {
            $this->telefono = $telefono;
        }if ($this->hay_espacios($telefono)) {
            return "Este campo no puede contener espacios";
        }if (!$this->es_numerico($telefono)) {
            return "No valido, solo ingresa numeros";
        }if (!$this->en_limite_sup($this->eliminar_espacios($telefono), 10)) {
            return "El telefono es largo, no es valido";
        }if (!$this->en_limite_inf($this->eliminar_espacios($telefono), 7)) {
            return "El telefono es corto, no es valido";
        }if (RepositorioProveedor::existe_telefono_proveedor_en_otro_reg($clave, $telefono, $conexion)) {
            return "Ya hay un proveedor con este telefono";
        }
        return "";
    }

    private function validar_correo_actualizar($clave, $correo, $conexion) {
        if (!$this->variable_iniciada($correo)) {
            return "Debes ingresar el correo";
        } else {
            $this->correo = $this->preparar_variable($correo);
        }if ($this->hay_espacios($correo)) {
            return "Este campo no puede contener espacios";
        }if (!$this->en_limite_sup($this->eliminar_espacios($correo), 50)) {
            return "El correo es largo, no es valido";
        }if (!$this->en_limite_inf($this->eliminar_espacios($correo), 4)) {
            return "El correo es corto, no es valido";
        }if (RepositorioProveedor::existe_correo_proveedor_en_otro_reg($clave, $correo, $conexion)) {
            return "Ya hay un registro con este correo";
        }
        return "";
    }

    private function validar_razonsocial($razonsocial, $conexion) {
        if (!$this->variable_iniciada($razonsocial)) {
            return "Debes ingresar el nombre de la empresa";
        } else {
            $this->razonsocial = $this->preparar_variable($razonsocial);
        }if (!$this->en_limite_sup($this->eliminar_espacios($razonsocial), 30)) {
            return "EL nombre es largo, no es valido";
        }if (!$this->en_limite_inf($this->eliminar_espacios($razonsocial), 3)) {
            return "EL nombre es corto, no es valido";
        }if (RepositorioProveedor::existe_rasonsocial_proveedor($razonsocial, $conexion)) {
            return "EL nombre ya existe";
        }
        return "";
    }

    private function validar_RFC($RFC, $conexion) {
        if (!$this->variable_iniciada($RFC)) {
            return "Debes ingresar el RFC";
        } else {
            $this->RFC = $this->preparar_variable($RFC);
        }if ($this->hay_espacios($RFC)) {
            return "Este campo no puede contener espacios";
        }if (!$this->en_limite_sup($this->eliminar_espacios($RFC), 13)) {
            return "Solo se necesitan 13 caracteres";
        }if (!$this->en_limite_inf($this->eliminar_espacios($RFC), 13)) {
            return "Se necesitan 13 caracteres";
        }if (RepositorioProveedor::existe_rfc_proveedor($RFC, $conexion)) {
            return "Ya hay un proveedor con este rfc";
        }
        return "";
    }

    private function validar_telefono($telefono, $conexion) {
        if (!$this->variable_iniciada($telefono)) {
            return "Debes ingresar el telefono";
        } else {
            $this->telefono = $telefono;
        }if ($this->hay_espacios($telefono)) {
            return "Este campo no puede contener espacios";
        }if (!$this->es_numerico($telefono)) {
            return "No valido, solo ingresa numeros";
        }if (!$this->en_limite_sup($this->eliminar_espacios($telefono), 10)) {
            return "El telefono es largo, no es valido";
        }if (!$this->en_limite_inf($this->eliminar_espacios($telefono), 7)) {
            return "El telefono es corto, no es valido";
        }if (RepositorioProveedor::existe_telefono_proveedor($telefono, $conexion)) {
            return "Ya hay un proveedor con este telefono";
        }
        return "";
    }

    private function validar_correo($correo, $conexion) {
        if (!$this->variable_iniciada($correo)) {
            return "Debes ingresar el correo";
        } else {
            $this->correo = $this->preparar_variable($correo);
        }if ($this->hay_espacios($correo)) {
            return "Este campo no puede contener espacios";
        }if (!$this->en_limite_sup($this->eliminar_espacios($correo), 50)) {
            return "El correo es largo, no es valido";
        }if (!$this->en_limite_inf($this->eliminar_espacios($correo), 4)) {
            return "El correo es corto, no es valido";
        }if (RepositorioProveedor::existe_correo_proveedor($correo, $conexion)) {
            return "Ya hay un registro con este correo";
        }
        return "";
    }

    private function validar_nota($nota) {
        if (!$this->en_limite_sup($this->eliminar_espacios($nota), 100)) {
            return "El comentario es demasiado largo";
        }
        return "";
    }

    function obtener_razonsocial() {
        return $this->razonsocial;
    }

    function obtener_RFC() {
        return $this->RFC;
    }

    function obtener_telefono() {
        return $this->telefono;
    }

    function obtener_correo() {
        return $this->correo;
    }

    function obtener_nota() {
        return $this->nota;
    }

    function obtener_error_razonsocial() {
        return $this->error_razonsocial;
    }

    function obtener_error_RFC() {
        return $this->error_RFC;
    }

    function obtener_error_telefono() {
        return $this->error_telefono;
    }

    function obtener_error_correo() {
        return $this->error_correo;
    }

    function obtener_error_nota() {
        return $this->error_nota;
    }

    function limpiar_datos_validador() {
        $this->razonsocial = "";
        $this->RFC = "";
        $this->telefono = "";
        $this->correo = "";
        $this->nota = "";
    }

    function limpiar_errores_validador() {
        $this->error_razonsocial = "";
        $this->error_RFC = "";
        $this->error_telefono = "";
        $this->error_correo = "";
        $this->error_nota = "";
    }

    function informacion_valida() {
        if ($this->error_razonsocial == "" && $this->error_RFC == "" && $this->error_telefono == "" && $this->error_correo == "" && $this->error_nota == "") {
            return true;
        } else {
            return false;
        }
    }

}
