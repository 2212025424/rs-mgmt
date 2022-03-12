<?php
include_once 'config.inc.php';

class Redireccion{
    
    public static function redirigir($url){
        header('Location:'. $url, true, 301);
        exit();
    }

    public static function redirigir_usuario_inicio($cvl_rol){
        //Administrador
    	if (strcmp($cvl_rol, 'J2hBnK2js4')==0) {
    		header('Location:'. RUTA_INICIO_ADMINISTRADOR, true, 301);
    	}
    	//Cajero
    	if (strcmp($cvl_rol, '6EgYd2tR4W')==0) {
    		header('Location:'. RUTA_INICIO_CAJERO, true, 301);
    	}
    	//Mesero
    	if (strcmp($cvl_rol, 'FSe7Hsg5K2')==0) {
    		header('Location:'. RUTA_INICIO_MESERO, true, 301);
    	}
        exit();
    }

}
 


