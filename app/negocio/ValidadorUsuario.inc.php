<?php

include_once 'Validador.inc.php';

class ValidadorUsuario extends Validador {

    private $error_rol;
    private $error_empleado;
    private $error_pass1;
    private $error_pass2;

    public function __construct($rol, $empleado, $pass1, $pass2, $conexion) {

        $this->rol = "";
        $this->empleado = "";
        $this->password = "";

        $this->error_rol = $this->validar_rol($rol, $conexion);
        $this->error_empleado = $this->validar_empleado($empleado, $conexion);
        $this->error_pass1 = $this->validar_pass1($pass1);
        $this->error_pass2 = $this->validar_pass2($pass2, $pass1);

        if ($this->error_pass1 == "" && $this->error_pass2 == "") {
            $this->password = $pass1;
        }
    }

    private function validar_rol($rol, $conexion) {
        if (!RepositorioRol::existe_clave_rol($rol, $conexion)) {
            return "No se encuantra el rol";
        } else {
            $this->rol = $rol;
        }
        return "";
    }

    private function validar_empleado($empleado, $conexion) {
        if (!RepositorioEmpleado::existe_clave_empleado($empleado, $conexion)) {
            return "No se encuantra el empleado";
        }if(RepositorioEmpleado::empleado_posse_cuenta($empleado, $conexion)){
            return "EL usuario ya posee una cuenta";
        } else {
            $this->empleado = $empleado;
        }
        return "";
    }

    private function validar_pass1($clave) {
        if (!$this->variable_iniciada($clave)) {
            return "Debes insertar una contraseña";
        }if (!$this->en_limite_sup($clave, 10)) {
            return "No puede ser mayor a 20 caracteres";
        }if (!$this->en_limite_inf($clave, 5)) {
            return "Se necesitan por lo menos 5 caracteres";
        }
        return "";
    }

    private function validar_pass2($clave, $clave2) {
        if (!$this->variable_iniciada($clave)) {
            return "Inserta la primera contraseña";
        }if (!$this->variable_iniciada($clave2)) {
            return "Debes repetir la contraseña";
        }if ($clave !== $clave2) {
            return "Las contraseñas no coinciden";
        }
        return "";
    }

    public function obtener_rol() {
        return $this->rol;
    }

    public function obtener_empleado() {
        return $this->empleado;
    }

    public function obtener_password() {
        return $this->password;
    }

    public function obtener_error_rol() {
        return $this->error_rol;
    }

    public function obtener_error_empleado() {
        return $this->error_empleado;
    }

    public function obtener_error_error_pass1() {
        return $this->error_pass1;
    }

    public function obtener_error_error_pass2() {
        return $this->error_pass2;
    }
    
    public function limpiar_datos_validador() {
        $this->rol = "";
        $this->empleado = "";
    }

    public function informacion_valida() {
        if ($this->error_rol == "" && $this->error_empleado == "" && $this->error_pass1 == "" && $this->error_pass2 == "") {
            return true;
        } else {
            return false;
        }
    }

}
