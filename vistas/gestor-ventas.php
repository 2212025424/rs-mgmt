<?php
$titulo_documento = "Sistema RSMgmt || Gestor de ventas || Ventas El Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/transversal/Script.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Venta.inc.php';
include_once 'app/acceso/RepositorioVenta.inc.php';
include_once 'app/modelo/Producto.inc.php';
include_once 'app/acceso/RepositorioProducto.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

if (isset($_POST['ELIMINAR_INS'])) {
    Conexion::abrir_conexion();
    $eliminada = RepositorioVenta::eliminar_venta_por_clave($_POST['CLAVE_VEN'], Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($eliminada) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: La venta se ha eliminado correctamente', 'alerta_exito');}; </script>";
    } else {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: Se ha generado un error', 'alerta_error');}; </script>";
    }
}

include_once 'plantillas/html-apertura.php';
include_once 'plantillas/html-menu-superior.php';
include_once 'plantillas/html-menu-lateral.php';
?>

<div class="main_container">

    <!-- ENCABEZADO DEL DOCUMENTO EN LA VISTA -->
    <div class="descripcion_documento">Gestor de ventas</div>

    <div class="contenedor_contenido">

        <!-- Descriptcion de la seccion actual -->
        <div class="contenedor_encabezado_tabla">
            <div class="contenedor_mensaje_operacion" id="mensaje_opercion">

            </div>
            <div>
                <a href="<?= RUTA_REGISTRAR_INSUMO; ?>" class="btn btn_primary">Aperturar Caja</a>
            </div>
        </div>

        <?php
        Conexion::abrir_conexion();
        $ventas = RepositorioVenta::obtener_ventas_por_criterio('0', Conexion::obtener_conexion());
        Conexion::cerrar_conexion();

        if (count($ventas) > 0) {
            ?>
            <div class="table_responsive">
                <table class="tabla_contenido">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th colspan="2">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($insumos as $i => $insumo) {
                            Conexion::abrir_conexion();
                            $proveedor = RepositorioProveedor::obtener_proveedor_por_clave($insumo->getCvl_proveedor(), Conexion::obtener_conexion());
                            $unidad = RepositorioUnidad::obtener_unidad_por_clave($insumo->getCvl_unidad(), Conexion::obtener_conexion());
                            $categoria = RepositorioCategoriaInsumo::obtener_categoria_por_clave($insumo->getCvl_categoria(), Conexion::obtener_conexion());
                            Conexion::cerrar_conexion();
                            ?>
                            <tr>
                                <td><?= $insumo->getInsumo(); ?></td>
                                <td><?= $unidad->getUnidad(); ?></td>
                                <td><?= $insumo->getExistencias(); ?></td>
                                <td><?= $insumo->getReorden(); ?></td>
                                <td>
                                    <button class="btn_sm btn_exito js_open_modal" modal="modal_detalles_<?= $insumo->getClave(); ?>">
                                        Detalles
                                    </button>
                                </td>
                                <td>
                                    <button class="btn_sm btn_peligro js_open_modal" modal="modal_eliminar_<?= $insumo->getClave(); ?>">
                                        eliminar
                                    </button>
                                </td>
                            </tr>

                         

                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
        } else {
            Escritor::pintar_no_hay_registros("No hay registro de ventas en la base de datos");
        }
        ?>
    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';


