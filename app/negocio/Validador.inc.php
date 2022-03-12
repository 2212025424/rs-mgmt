<?php

abstract class Validador {

    function __construct() {
        
    }

    //Elimina los espacios de más y convierte a mayusculas - Estandar de la base de datos
    protected function preparar_variable($variable) {
        $variable_tratada = implode(' ', array_filter(explode(' ', $variable)));
        return mb_strtoupper($variable_tratada, 'UTF-8');
    }

    //Retorna true en caso de que se cumpla el formato y la fecha exista
    protected function es_formato_fecha($fecha) {
        $valores = explode('-', $fecha);
        if (count($valores) == 3) {
            return true;
        } else {
            return false;
        }
    }

    //Determina si es una cadena hay espacios
    protected function hay_espacios($cadena) {
        $cadena_tratada = str_replace(' ', '', $cadena);
        $cadena_tratada = preg_replace('/\s+/', '', $cadena_tratada);
        if (strlen($cadena) != strlen($cadena_tratada)) {
            return true;
        } else {
            return false;
        }
    }

    //Eliminar todos los espacios de una cadena y caracteres como tabulador y salto de linea
    protected function eliminar_espacios($cadena) {
        $cadena_trarada = str_replace(' ', '', $cadena);
        $res = preg_replace('/\s+/', '', $cadena_trarada);
        return $res;
    }

    //valida que una variable existe y no sea vacia
    protected function variable_iniciada($variable) {
        if (isset($variable) && !empty($variable)) {
            return true;
        } else {
            return false;
        }
    }

    //Validad que un valor esté debajo o igual al limite
    protected function en_limite_sup($variable, $lim_sup) {
        if (strlen($variable) <= $lim_sup) {
            return true;
        } else {
            return false;
        }
    }

    //Validad que un valor esté arriba o igual al limite
    protected function en_limite_inf($variable, $lim_inf) {
        if (strlen($variable) >= $lim_inf) {
            return true;
        } else {
            return false;
        }
    }

    //Validad que un valor esté arriba o igual al limite
    protected function es_numerico($variable) {
        if (is_numeric($variable)) {
            return true;
        } else {
            return false;
        }
    }

}
