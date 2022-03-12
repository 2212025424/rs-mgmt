<?php

include_once '../transversal/config.inc.php';
include_once '../acceso/Conexion.inc.php';
include_once '../modelo/Producto.inc.php';
include_once '../acceso/RepositorioProducto.inc.php';

if (isset($_POST['NOMBRE_PRO_REG'])) {
	Conexion::abrir_conexion();
	$existe = RepositorioProducto::existe_nombre_producto($_POST['NOMBRE_PRO_REG'], Conexion::obtener_conexion());
	Conexion::cerrar_conexion();	
	$codigo = 0;
	if ($existe) {
		$codigo = 100;
	}
	$jsonString = json_encode($codigo);
	echo $jsonString;	
}

