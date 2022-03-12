<?php

$componentes_url = parse_url($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);

$ruta = $componentes_url['path'];

$partes_ruta = explode('/', $ruta);

$partes_ruta = array_filter($partes_ruta);
//Al montar al servidor, cambiar por 0 del slide
$partes_ruta = array_slice($partes_ruta, 0);

$ruta_elegida = 'vistas/404.php';

if ($partes_ruta[0] == 'rs-mgmt-cd.000webhostapp.com') {
    
    if (count($partes_ruta) == 1) {
        $ruta_elegida = 'vistas/iniciar-sesion.php';
    } else if (count($partes_ruta) == 2) {
        switch ($partes_ruta[1]) {
            case 'iniciar-sesion':
                $ruta_elegida = 'vistas/iniciar-sesion.php';
                break;
            case 'cerrar-sesion':
                $ruta_elegida = 'vistas/cerrar-sesion.php';
                break;
            case 'inicio-administrador':
                $ruta_elegida = 'vistas/inicio-administrador.php';
                break;
            case 'inicio-cajero':
                $ruta_elegida = 'vistas/inicio-cajero.php';
                break;
            case 'inicio-encargado-de-piso':
                $ruta_elegida = 'vistas/inicio-encargado-piso.php';
                break;
            case 'puestos-de-trabajo':
                $ruta_elegida = 'vistas/puestos-trabajo.php';
                break;
            case 'mesas-de-servicio':
                $ruta_elegida = 'vistas/mesas-de-servicio.php';
                break;
            case 'cajas-de-cobro':
                $ruta_elegida = 'vistas/cajas-de-cobro.php';
                break;
            case 'gestor-empleados':
                $ruta_elegida = 'vistas/gestor-empleados.php';
                break;
            case 'registrar-empleado':
                $ruta_elegida = 'vistas/registrar-empleado.php';
                break;
            case 'editar-empleado':
                $ruta_elegida = 'vistas/editar-empleado.php';
                break;
            case 'gestor-usuarios':
                $ruta_elegida = 'vistas/gestor-usuarios.php';
                break;
            case 'registrar-usuario':
                $ruta_elegida = 'vistas/registrar-usuario.php';
                break;
            case 'gestor-proveedores':
                $ruta_elegida = 'vistas/gestor-proveedores.php';
                break;
            case 'registrar-proveedor':
                $ruta_elegida = 'vistas/registrar-proveedor.php';
                break;
            case 'editar-proveedor':
                $ruta_elegida = 'vistas/editar-proveedor.php';
                break;
            case 'gestor-insumos':
                $ruta_elegida = 'vistas/gestor-insumos.php';
                break;
            case 'registrar-insumo':
                $ruta_elegida = 'vistas/registrar-insumo.php';
                break;
            case 'editar-insumo':
                $ruta_elegida = 'vistas/editar-insumo.php';
                break;
            case 'categoria-productos':
                $ruta_elegida = 'vistas/categoria-productos.php';
                break;
            case 'gestor-productos':
                $ruta_elegida = 'vistas/gestor-productos.php';
                break;
            case 'registrar-producto':
                $ruta_elegida = 'vistas/registrar-producto.php';
                break;
            case 'asignar-consumo-insumo':
                $ruta_elegida = 'vistas/asignar-consumo-insumo.php';
                break;
            case 'gestor-ventas':
                $ruta_elegida = 'vistas/gestor-ventas.php';
                break;
        }
    }
}


include_once $ruta_elegida;

