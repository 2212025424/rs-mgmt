<?php
$titulo_documento = "Sistema RSMgmt || Usuarios del sistema || Usuarios El Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Script.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Rol.inc.php';
include_once 'app/acceso/RepositorioRol.inc.php';
include_once 'app/modelo/Empleado.inc.php';
include_once 'app/acceso/RepositorioEmpleado.inc.php';
include_once 'app/modelo/Usuario.inc.php';
include_once 'app/acceso/RepositorioUsuario.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

if (isset($_POST['ELIMINAR_USR'])) {
    Conexion::abrir_conexion();
    $eliminado = RepositorioUsuario::eliminar_usuario_por_clave($_POST['CLAVE_USR'], Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($eliminado) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: El usuario se ha eliminado correctamente', 'alerta_exito');}; </script>";
    } else {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: Se ha producido un error', 'alerta_error');}; </script>";
    }
}

if (isset($_POST['ACTUALIZAR_USR'])) {

    if (isset($_POST['ESTADO_USR'])) {
        $estado = 1;
    } else {
        $estado = 0;
    }

    $cvl_rol = $_POST['CVL_ROL'];
    $cvl_usr = $_POST['CLAVE_USR'];

    $usuario_obj = new Usuario($cvl_usr, $cvl_rol, '', $estado);

    Conexion::abrir_conexion();
    $actualizado = RepositorioUsuario::actualizar_usuario_por_clave($usuario_obj, Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($actualizado) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: El usuario se ha actualizado correctamente', 'alerta_exito');}; </script>";
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
    <div class="descripcion_documento">Gestor de usuarios del sistema</div>

    <div class="contenedor_contenido">

        <!-- Descriptcion de la seccion actual -->
        <div class="contenedor_encabezado_tabla">
            <div class="contenedor_mensaje_operacion" id="mensaje_opercion">

            </div>
            <div>
                <a href="<?= RUTA_REGISTRAR_USUARIO; ?>" class="btn btn_primary">Agregar Nuevo Usuario</a>
            </div>
        </div>

        <?php
        Conexion::abrir_conexion();
        $usuarios = RepositorioUsuario::obtener_usuarios(Conexion::obtener_conexion());
        $roles = RepositorioRol::obtener_roles(Conexion::obtener_conexion());
        Conexion::cerrar_conexion();

        if (count($usuarios) > 0) {
            ?>
            <div class="table_responsive">
                <table class="tabla_contenido">
                    <thead>
                        <tr>
                            <th>Rol Usuario</th>
                            <th>CVL usuario</th>
                            <th>Asignado a</th>
                            <th>Estado</th>
                            <th colspan="2">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($usuarios as $i => $usuario) {
                            Conexion::abrir_conexion();
                            $empleado = RepositorioEmpleado::obtener_empleado_por_clave($usuario->getClv_empleado(), Conexion::obtener_conexion());
                            $rol = RepositorioRol::obtener_rol_por_clave($usuario->getClv_rol(), Conexion::obtener_conexion());
                            Conexion::cerrar_conexion();
                            ?>
                            <tr>
                                <td><?= $rol->getRol(); ?></td>
                                <td><?= $usuario->getClv_empleado(); ?></td>
                                <td><?= $empleado->getNombre(); ?></td>
                                <td><?= Escritor::determinar_estado_usuario($usuario->getEstado()); ?></td>
                                <td>
                                    <button class="btn_sm btn_exito js_open_modal" modal="modal_actualizar_<?= $usuario->getClv_empleado(); ?>">
                                        editar
                                    </button>
                                </td>
                                <td>
                                    <button class="btn_sm btn_peligro js_open_modal" modal="modal_eliminar_<?= $usuario->getClv_empleado(); ?>">
                                        eliminar
                                    </button>
                                </td>
                            </tr>

                            <!-- Ventala modal de EDITAR, defaul: cerrada -->
                        <div class="ventana_modal" id="modal_actualizar_<?= $usuario->getClv_empleado(); ?>">
                            <div class="ventana_modal__content">
                                <div class="ventana_modal__titulo">
                                    FORMULARIO DE ACTUALIZACIÓN
                                </div>
                                <div class="ventana_modal_cuerpo">
                                    <form method="post" autocomplete="off">
                                        <input type="hidden" name="CLAVE_USR" value="<?= $usuario->getClv_empleado(); ?>">
                                        <select class="form_select" name="CVL_ROL" required>
                                            <?php
                                            foreach ($roles as $rol_itm) {
                                                ?>
                                                <option value="<?= $rol_itm->getClave(); ?>"  <?= Escritor::auto_select_options($rol->getClave(), $rol_itm->getClave()); ?> ><?= $rol_itm->getRol(); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <input type="checkbox" id="ck_<?= $usuario->getClv_empleado(); ?>" name="ESTADO_USR" class="form_checkbox" <?= Escritor::estado_check($usuario->getEstado()); ?>/>
                                        <label for="ck_<?= $usuario->getClv_empleado(); ?>">Actualmente con acceso !</label>

                                        <button type="submit" name="ACTUALIZAR_USR" class="btn btn_primary">Actualizar usuario</button>
                                    </form>
                                </div>
                                <div class="ventana_modal__pie">
                                    <a class="btn btn_exito js_close_modal" modal="modal_actualizar_<?= $usuario->getClv_empleado(); ?>">Cerrar Ventana</a>
                                </div>
                            </div>
                        </div>

                        <!-- Ventala modal de eliminar, defaul: cerrada -->
                        <div class="ventana_modal" id="modal_eliminar_<?= $empleado->getClave(); ?>">
                            <div class="ventana_modal__content">
                                <div class="ventana_modal__titulo">
                                    Mensaje de confirmación
                                </div>
                                <div class="ventana_modal_cuerpo">
                                    ¿Seguro qué deseas eliminar de forma permanente al usuario? <br> 
                                    clave: <b><?= $usuario->getClv_empleado(); ?></b> <br> 
                                    asisgando a: <b><?= $empleado->getNombre() ?></b>
                                </div>
                                <div class="ventana_modal__pie">
                                    <form method="post" class="form-inline">
                                        <input type="hidden" name="CLAVE_USR" value="<?= $usuario->getClv_empleado(); ?>">
                                        <button type="submit" name="ELIMINAR_USR" class="btn btn_peligro">Eliminar usuario</button>
                                    </form>
                                    <a class="btn btn_exito js_close_modal" modal="modal_eliminar_<?= $usuario->getClv_empleado(); ?>">Cerrar Ventana</a>
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
            Escritor::pintar_no_hay_registros("No hay registro de usuarios en la base de datos");
        }
        ?>
    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';


