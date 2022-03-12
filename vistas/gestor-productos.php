<?php
$titulo_documento = "Sistema RSMgmt || Gestor de productos || Productos del Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Script.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Producto.inc.php';
include_once 'app/acceso/RepositorioProducto.inc.php';
include_once 'app/modelo/Proveedor.inc.php';
include_once 'app/acceso/RepositorioProveedor.inc.php';
include_once 'app/modelo/Categoria.inc.php';
include_once 'app/acceso/RepositorioCategoriaProducto.inc.php';
include_once 'app/modelo/Unidad.inc.php';
include_once 'app/acceso/RepositorioUnidad.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

if (isset($_POST['ELIMINAR_PRO'])) {

    Conexion::abrir_conexion();
    $eliminado = RepositorioProducto::eliminar_producto_por_clave($_POST['CLAVE_PRO'], Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($eliminado) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: El producto se ha eliminado correctamente', 'alerta_exito');}; </script>";
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
    <div class="descripcion_documento">Gestor de Productos</div>

    <div class="contenedor_contenido">
        <!-- Descriptcion de la seccion actual -->
        <div class="contenedor_encabezado_tabla">
            <div class="contenedor_mensaje_operacion" id="mensaje_opercion">

            </div>
            <div>
                <a href="<?= RUTA_REGISTRAR_PRODUCTO; ?>" class="btn btn_primary">Agregar Nuevo Producto</a>
            </div>
        </div>

        <?php
        Conexion::abrir_conexion();
        $productos = RepositorioProducto::obtener_productos(Conexion::obtener_conexion());
        Conexion::cerrar_conexion();

        if (count($productos) > 0) {
            ?>

            <div class="table_responsive">
                <table class="tabla_contenido">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Existencias</th>
                            <th>Re Orden</th>
                            <th>Estado</th>
                            <th colspan="2">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($productos as $producto) {
                            Conexion::abrir_conexion();
                            $proveedor = RepositorioProveedor::obtener_proveedor_por_clave($producto->getCvl_proveedor(), Conexion::obtener_conexion());
                            $unidad = RepositorioUnidad::obtener_unidad_por_clave($producto->getCvl_unidad(), Conexion::obtener_conexion());
                            $categoria = RepositorioCategoriaProducto::obtener_categoria_por_clave($producto->getCvl_categoria(), Conexion::obtener_conexion());
                            Conexion::cerrar_conexion();
                            ?>
                            <tr>
                                <td><?= $producto->getProducto(); ?></td>
                                <td>$ <?= $producto->getPrecio(); ?></td>
                                <td><?= $producto->getExistencias(); ?></td>
                                <td><?= $producto->getReorden(); ?></td>
                                <td><?= Escritor::determinar_estado_caja($producto->getEstado()); ?></td>
                                <td>
                                    <button class="btn_sm btn_exito js_open_modal" modal="modal_detalles_<?= $producto->getClave(); ?>">
                                        Ver Más
                                    </button>
                                </td>
                                <td>
                                    <button class="btn_sm btn_peligro js_open_modal" modal="modal_eliminar_<?= $producto->getClave(); ?>">
                                        eliminar
                                    </button>
                                </td>
                            </tr>


                            <!-- Ventala modal de detalle, defaul: cerrada -->
                        <div class="ventana_modal" id="modal_detalles_<?= $producto->getClave(); ?>">
                            <div class="ventana_modal__content">
                                <div class="ventana_modal__titulo">
                                    Detalles del insumo
                                </div>
                                <div class="ventana_modal_cuerpo">
                                    <div class="presentacion_dos_columnas">
                                        <div>
                                            <p>Producto: <h4><?= $producto->getProducto(); ?></h4></p>
                                        </div>
                                        <div>
                                            <p>Unidad: <h4><?= $unidad->getUnidad(); ?></h4></p>
                                        </div>
                                        <div>
                                            <p>Proveedor: <h4><?= $proveedor->getRazonsocial(); ?></h4></p>
                                        </div>
                                        <div>
                                            <p>Categoria: <h4><?= $categoria->getCategoria(); ?></h4></p>
                                        </div>
                                        <div>
                                            <p>Existencias: <h4><?= $producto->getExistencias(); ?></h4></p>
                                        </div>
                                        <div>
                                            <p>Reorden: <h4><?= $producto->getReOrden(); ?></h4></p>
                                        </div>
                                    </div>
                                    <hr class="separador">
                                    <p><?= $producto->getNota(); ?></p>
                                </div>
                                <div class="ventana_modal__pie">
                                    <a class="btn btn_primary" href="<?=RUTA_ASIGNAR_INSUMOS.'?producto='.$producto->getClave()?>">Ver Insumos</a>
                                    <a class="btn btn_primary">Editar Producto</a>
                                    <a class="btn btn_exito js_close_modal" modal="modal_detalles_<?= $producto->getClave(); ?>">Cerrar Ventana</a>
                                </div>
                            </div>
                        </div>


                        <!-- Ventala modal de eliminar, defaul: cerrada -->
                        <div class="ventana_modal" id="modal_eliminar_<?= $producto->getClave(); ?>">
                            <div class="ventana_modal__content">
                                <div class="ventana_modal__titulo">
                                    Mensaje de confirmación
                                </div>
                                <div class="ventana_modal_cuerpo">
                                    ¿Seguro qué deseas eliminar de forma permanente <b><?= $producto->getProducto(); ?></b>?
                                </div>
                                <div class="ventana_modal__pie">
                                    <form method="post" class="form-inline">
                                        <input type="hidden" name="CLAVE_PRO" value="<?= $producto->getClave(); ?>">
                                        <button type="submit" name="ELIMINAR_PRO" class="btn btn_peligro">Eliminar Producto</button>
                                    </form>
                                    <a class="btn btn_exito js_close_modal" modal="modal_eliminar_<?= $producto->getClave(); ?>">Cerrar Ventana</a>
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




