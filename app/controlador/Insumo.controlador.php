<?php

include_once '../transversal/config.inc.php';
include_once '../acceso/Conexion.inc.php';
include_once '../modelo/Insumo.inc.php';
include_once '../acceso/RepositorioInsumo.inc.php';

if (isset($_POST['NOMBRE_INS_REG'])) {
	Conexion::abrir_conexion();
	$existe = RepositorioInsumo::existe_nombre_insumo($_POST['NOMBRE_INS_REG'], Conexion::obtener_conexion());
	Conexion::cerrar_conexion();	
	$codigo = 0;
	if ($existe) {
		$codigo = 100;
	}
	$jsonString = json_encode($codigo);
	echo $jsonString;	
}

if (isset($_POST['NOMBRE_INS_ACT'])) {
	Conexion::abrir_conexion();
	$existe = RepositorioInsumo::existe_insumo_en_otro_reg($_POST['CLAVE_INS_ACT'], $_POST['NOMBRE_INS_ACT'], Conexion::obtener_conexion());
	Conexion::cerrar_conexion();	
	$codigo = 0;
	if ($existe) {
		$codigo = 100;
	}
	$jsonString = json_encode($codigo);
	echo $jsonString;
	
}
