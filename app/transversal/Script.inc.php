<?php

class Script {

    public static function generar_clave($limite) {

        $clave = "";

        $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for ($i = 0; $i < $limite; $i++) {
            $clave .= $caracteres[rand(0, 60)];
        }

        return $clave;
    }

    public static function convertir_mayusculas($texto) {
        return strtoupper($texto);
    }

}
