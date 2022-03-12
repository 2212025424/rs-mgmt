<?php

include_once '../transversal/config.inc.php';
include_once '../acceso/Conexion.inc.php';
include_once '../modelo/Insumo.inc.php';
include_once '../acceso/RepositorioInsumo.inc.php';
include_once '../modelo/Unidad.inc.php';
include_once '../acceso/RepositorioUnidad.inc.php';
include_once '../modelo/Categoria.inc.php';
include_once '../acceso/RepositorioCategoriaInsumo.inc.php';
include_once '../modelo/ConsumoInsumo.inc.php';
include_once '../acceso/RepositorioConsumoInsumo.inc.php';

$operacion = $_POST['OPERACION'];

if (isset($_POST['OPERACION'])) {
	switch ($operacion) {
		case 'OBTENER_INSUMOS':
			Conexion::abrir_conexion();
			$insumos = RepositorioInsumo::obtener_insumos_sin_asignar($_POST['CVL_PRODUCTO'], Conexion::obtener_conexion());
			Conexion::cerrar_conexion();

			$json = array();

			foreach ($insumos as $insumo) {
				Conexion::abrir_conexion();
                $categoria = RepositorioCategoriaInsumo::obtener_categoria_por_clave($insumo->getCvl_categoria(), Conexion::obtener_conexion());
                $unidad = RepositorioUnidad::obtener_unidad_por_clave($insumo->getCvl_unidad(), Conexion::obtener_conexion());
				Conexion::cerrar_conexion();
				
				$json[] = array(
					'cvl_insumo' => $insumo->getClave(),
					'insumo' => $insumo->getInsumo(),
					'unidad' => $unidad->getUnidad(),
					'categoria' => $categoria->getCategoria()
				);
			}

			$jsonString = json_encode($json);
			
			echo $jsonString;
			break;
		case 'OBTENER_INSUMO_CLAVE':
			Conexion::abrir_conexion();
			$insumo = RepositorioInsumo::obtener_insumo_por_clave($_POST['CVL_INSUMO'], Conexion::obtener_conexion());
            $unidad = RepositorioUnidad::obtener_unidad_por_clave($insumo->getCvl_unidad(), Conexion::obtener_conexion());
			Conexion::cerrar_conexion();

			$json = array();

			$json[] = array(
				'cvl_insumo' => $insumo->getClave(),
				'insumo' => $insumo->getInsumo(),
				'unidad' => $unidad->getUnidad()
			);

			$jsonString = json_encode($json);
			
			echo $jsonString;
			break;
		case 'INSERTAR_CONSUMO':
			$consumo = new ConsumoInsumo($_POST['CVL_PRODUCTO'], $_POST['CVL_INSUMO'], $_POST['NUM_PRODUCTOS'], $_POST['CANT_MIN'], $_POST['CANT_MAX']);
			Conexion::abrir_conexion();
			$insertado = RepositorioConsumoInsumo::insertar_consumo($consumo, Conexion::obtener_conexion());
			Conexion::cerrar_conexion();
			if ($insertado) {
				return true;
			}else{
				return false;
			}
			break;
		case 'ACTUALIZAR_CONSUMO':
			$consumo = new ConsumoInsumo($_POST['CVL_PRODUCTO'], $_POST['CVL_INSUMO'], $_POST['NUM_PRODUCTOS'], $_POST['CANT_MIN'], $_POST['CANT_MAX']);
			Conexion::abrir_conexion();
			$actualizado = RepositorioConsumoInsumo::actualizar_consumo_producto($consumo, Conexion::obtener_conexion());
			Conexion::cerrar_conexion();
			if ($actualizado) {
				return true;
			}else{
				return false;
			}
			break;
		case 'ELIMINAR_CONSUMO':
			Conexion::abrir_conexion();
			$eliminado = RepositorioConsumoInsumo::eliminar_consumo_de_producto($_POST['CVL_PRODUCTO'], $_POST['CVL_INSUMO'], Conexion::obtener_conexion());
			Conexion::cerrar_conexion();
			if ($eliminado) {
				return true;
			}else{
				return false;
			}
			break;
		case 'OBTENER_CONSMOS_PRODUCTO':
			Conexion::abrir_conexion();
			$consumos = RepositorioConsumoInsumo::obtener_consumos_producto($_POST['CVL_PRODUCTO'], Conexion::obtener_conexion());
			Conexion::cerrar_conexion();

			$json = array();

			foreach ($consumos as $consumo) {
				Conexion::abrir_conexion();
				$insumo = RepositorioInsumo::obtener_insumo_por_clave($consumo->getCvl_insumo(), Conexion::obtener_conexion());
                $unidad = RepositorioUnidad::obtener_unidad_por_clave($insumo->getCvl_unidad(), Conexion::obtener_conexion());
				Conexion::cerrar_conexion();
				
				$json[] = array(
					'cvl_producto' => $consumo->getCvl_producto(),
					'cvl_insumo' => $consumo->getCvl_insumo(),
					'insumo' => $insumo->getInsumo(),
					'numProductos' => $consumo->getNumproductos(),
					'cantMin' => $consumo->getCantidadMin(),
					'cantMax' => $consumo->getCantidadMax(),
					'unidad' => $unidad->getUnidad()
				);
			}

			$jsonString = json_encode($json);
			
			echo $jsonString;
			break;
		case 'OBTENER_CONSUMO_CLAVE':
			Conexion::abrir_conexion();
			$consumo = RepositorioConsumoInsumo::obtener_insumo_en_producto($_POST['CVL_PRODUCTO'], $_POST['CVL_INSUMO'], Conexion::obtener_conexion());
			$insumo = RepositorioInsumo::obtener_insumo_por_clave($consumo->getCvl_insumo(), Conexion::obtener_conexion());
            $unidad = RepositorioUnidad::obtener_unidad_por_clave($insumo->getCvl_unidad(), Conexion::obtener_conexion());
			Conexion::cerrar_conexion();

			$json = array();

			$json[] = array(
				'cvl_producto' => $consumo->getCvl_producto(),
				'cvl_insumo' => $consumo->getCvl_insumo(),
				'insumo' => $insumo->getInsumo(),
				'numProductos' => $consumo->getNumproductos(),
				'cantMin' => $consumo->getCantidadMin(),
				'cantMax' => $consumo->getCantidadMax(),
				'unidad' => $unidad->getUnidad()
			);

			$jsonString = json_encode($json);
			
			echo $jsonString;
			break;
		default:
			echo "error de operacion";
			break;
	}
}
