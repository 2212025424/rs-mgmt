<?php
$titulo_documento = "Sistema RSMgmt || Gestor de Proveedores || Proveedores El Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Script.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Proveedor.inc.php';
include_once 'app/acceso/RepositorioProveedor.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

if (isset($_POST['ELIMINAR_PROVEEDOR'])) {
    Conexion::abrir_conexion();
    $eliminado = RepositorioProveedor::eliminar_proveedor_por_clave($_POST['CLAVE_PRO'], Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($eliminado) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: El proveedor se ha eliminado correctamente', 'alerta_exito');}; </script>";
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
    <div class="descripcion_documento">Gestor de proveedores</div>

    <div class="contenedor_contenido">

        <!-- Descriptcion de la seccion actual -->
        <div class="contenedor_encabezado_tabla">
            <div class="contenedor_mensaje_operacion" id="mensaje_opercion">

            </div>
            <div>
                <a href="<?= RUTA_REGISTRAR_PROVEEDOR; ?>" class="btn btn_primary">Agregar Nuevo Proveedor</a>
            </div>
        </div>

        <?php
        Conexion::abrir_conexion();
        $proveedores = RepositorioProveedor::obtener_proveedores(Conexion::obtener_conexion());
        Conexion::cerrar_conexion();

        if (count($proveedores) > 0) {
            ?>
            <div class="table_responsive">
                <table class="tabla_contenido">
                    <thead>
                        <tr>
                            <th>Razon Social</th>
                            <th>RFC</th>
                            <th>Teléfono</th>
                            <th colspan="2">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($proveedores as $proveedor) {
                            ?>
                            <tr>
                                <td><?= $proveedor->getRazonsocial(); ?></td>
                                <td><?= $proveedor->getRFC(); ?></td>
                                <td><?= $proveedor->getTelefono(); ?></td>                                
                                <td>
                                    <button class="btn_sm btn_exito js_open_modal" modal="modal_detalles_<?= $proveedor->getClave(); ?>">
                                        detalles
                                    </button>
                                </td>
                                <td>
                                    <button class="btn_sm btn_peligro js_open_modal" modal="modal_eliminar_<?= $proveedor->getClave(); ?>">
                                        eliminar
                                    </button>
                                </td>
                            </tr>

                            <!-- Ventala modal de detalle, defaul: cerrada -->
                        <div class="ventana_modal" id="modal_detalles_<?= $proveedor->getClave(); ?>">
                            <div class="ventana_modal__content">
                                <div class="ventana_modal__titulo">
                                    Detalles del proveedor
                                </div>
                                <div class="ventana_modal_cuerpo">
                                    <div class="presentacion_dos_columnas">
                                        <div>
                                            <p>Empresa: <h4><?= $proveedor->getRazonsocial(); ?></h4></p>
                                        </div>
                                        <div>
                                            <p>RFC: <h4><?= $proveedor->getRFC(); ?></h4></p>
                                        </div>
                                        <div>
                                            <p>Teléfono: <h4><?= $proveedor->getTelefono(); ?></h4></p>
                                        </div>
                                        <div>
                                            <p>Correo: <h4><?= $proveedor->getCorreo(); ?></h4></p>
                                        </div>
                                    </div>
                                    <hr class="separador">
                                    <p><?= Escritor::determinar_nota($proveedor->getNota()); ?></p>
                                </div>
                                <div class="ventana_modal__pie">
                                    <a href="<?= RUTA_EDITAR_PROVEEDOR . "?proveedor=" . $proveedor->getClave(); ?>" class="btn btn_primary">Editar Información</a>
                                    <a class="btn btn_exito js_close_modal" modal="modal_detalles_<?= $proveedor->getClave(); ?>">Cerrar Ventana</a>
                                </div>
                            </div>
                        </div>

                        <!-- Ventala modal de eliminar, defaul: cerrada -->
                        <div class="ventana_modal" id="modal_eliminar_<?= $proveedor->getClave(); ?>">
                            <div class="ventana_modal__content">
                                <div class="ventana_modal__titulo">
                                    Mensaje de confirmación
                                </div>
                                <div class="ventana_modal_cuerpo">
                                    ¿Seguro qué deseas eliminar de forma permanente <b><?= $proveedor->getRazonsocial(); ?></b>?
                                </div>
                                <div class="ventana_modal__pie">
                                    <form method="post" class="form-inline">
                                        <input type="hidden" name="CLAVE_PRO" value="<?= $proveedor->getClave(); ?>">
                                        <button type="submit" name="ELIMINAR_PROVEEDOR" class="btn btn_peligro">Eliminar Caja</button>
                                    </form>
                                    <a class="btn btn_exito js_close_modal" modal="modal_eliminar_<?= $proveedor->getClave(); ?>">Cerrar Ventana</a>
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
            Escritor::pintar_no_hay_registros("No hay registro de proveedores en la base de datos");
        }
        ?>
    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';


