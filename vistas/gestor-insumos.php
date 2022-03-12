<?php
$titulo_documento = "Sistema RSMgmt || Gestor de insumos || Insumos El Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/transversal/Script.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Insumo.inc.php';
include_once 'app/acceso/RepositorioInsumo.inc.php';
include_once 'app/negocio/ValidadorInsumo.inc.php';
include_once 'app/modelo/Proveedor.inc.php';
include_once 'app/acceso/RepositorioProveedor.inc.php';
include_once 'app/modelo/Categoria.inc.php';
include_once 'app/acceso/RepositorioCategoriaInsumo.inc.php';
include_once 'app/modelo/Unidad.inc.php';
include_once 'app/acceso/RepositorioUnidad.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

if (isset($_POST['ELIMINAR_INS'])) {
    Conexion::abrir_conexion();
    $eliminado = RepositorioInsumo::eliminar_insumo_por_clave($_POST['CLAVE_INS'], Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($eliminado) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: El insumo se ha eliminado correctamente', 'alerta_exito');}; </script>";
    } else {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: Se ha producido un error', 'alerta_error');}; </script>";
    }
}

include_once 'plantillas/html-apertura.php';
include_once 'plantillas/html-menu-superior.php';
include_once 'plantillas/html-menu-lateral.php';
?>

<div class="main_container">

    <!-- ENCABEZADO DEL DOCUMENTO EN LA VISTA -->
    <div class="descripcion_documento">Gestor de insumos</div>

    <div class="contenedor_contenido">

        <!-- Descriptcion de la seccion actual -->
        <div class="contenedor_encabezado_tabla">
            <div class="contenedor_mensaje_operacion" id="mensaje_opercion">

            </div>
            <div>
                <a href="<?= RUTA_REGISTRAR_INSUMO; ?>" class="btn btn_primary">Agregar Nuevo Insumo</a>
            </div>
        </div>

        <?php
        Conexion::abrir_conexion();
        $insumos = RepositorioInsumo::obtener_insumos(Conexion::obtener_conexion());
        Conexion::cerrar_conexion();

        if (count($insumos) > 0) {
            ?>
            <div class="table_responsive">
                <table class="tabla_contenido">
                    <thead>
                        <tr>
                            <th>Insumo</th>
                            <th>Unidad</th>
                            <th>Existencias</th>
                            <th>Re Orden</th>
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

                            <!-- Ventala modal de EDITAR, defaul: cerrada -->
                        <div class="ventana_modal" id="modal_detalles_<?= $insumo->getClave(); ?>">
                            <div class="ventana_modal__content">
                                <div class="ventana_modal__titulo">
                                    Detalles del insumo
                                </div>
                                <div class="ventana_modal_cuerpo">
                                    <div class="presentacion_dos_columnas">
                                        <div>
                                            <p>Proveedor: <h4><?= $proveedor->getRazonsocial(); ?></h4></p>
                                        </div>
                                        <div>
                                            <p>Categoria: <h4><?= $categoria->getCategoria(); ?></h4></p>
                                        </div>
                                    </div>
                                    <hr class="separador">
                                    <p><?= Escritor::determinar_nota($insumo->getNota()); ?></p>
                                </div>
                                <div class="ventana_modal__pie">
                                    <a class="btn btn_primary" href="<?= RUTA_EDITAR_INSUMO . '?insumo=' . $insumo->getClave(); ?>">Editar Insumo</a>
                                    <a class="btn btn_exito js_close_modal" modal="modal_detalles_<?= $insumo->getClave(); ?>">Cerrar Ventana</a>
                                </div>
                            </div>
                        </div>




                        <!-- Ventala modal de eliminar, defaul: cerrada -->
                        <div class="ventana_modal" id="modal_eliminar_<?= $insumo->getClave(); ?>">
                            <div class="ventana_modal__content">
                                <div class="ventana_modal__titulo">
                                    Mensaje de confirmación
                                </div>
                                <div class="ventana_modal_cuerpo">
                                    ¿Seguro qué deseas eliminar de forma permanente <b><?= $insumo->getInsumo(); ?></b>? <br> 
                                </div>
                                <div class="ventana_modal__pie">
                                    <form method="post" class="form-inline">
                                        <input type="hidden" name="CLAVE_INS" value="<?= $insumo->getClave(); ?>">
                                        <button type="submit" name="ELIMINAR_INS" class="btn btn_peligro">Eliminar Insumo</button>
                                    </form>
                                    <a class="btn btn_exito js_close_modal" modal="modal_eliminar_<?= $insumo->getClave(); ?>">Cerrar Ventana</a>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
        } else {
            Escritor::pintar_no_hay_registros("No hay registro de insumos en la base de datos");
        }
        ?>
    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';


