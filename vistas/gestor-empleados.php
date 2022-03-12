<?php
$titulo_documento = "Sistema RSMgmt || Gestor de empleados || Empleados del Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Script.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Empleado.inc.php';
include_once 'app/acceso/RepositorioEmpleado.inc.php';
include_once 'app/modelo/Puesto.inc.php';
include_once 'app/acceso/RepositorioPuesto.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

if (isset($_POST['ELIMINAR_EMP'])) {
    Conexion::abrir_conexion();
    $eliminado = RepositorioEmpleado::eliminar_empleado_por_clave($_POST['CLAVE_EMP'], Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($eliminado) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: La persona se ha eliminado correctamente', 'alerta_exito');}; </script>";
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
    <div class="descripcion_documento">Gestor de Empleados</div>

    <div class="contenedor_contenido">
        <!-- Descriptcion de la seccion actual -->
        <div class="contenedor_encabezado_tabla">
            <div class="contenedor_mensaje_operacion" id="mensaje_opercion">

            </div>
            <div>
                <a href="<?= RUTA_REGISTRAR_EMPLEADO; ?>" class="btn btn_primary">Agregar Nuevo Empleado</a>
            </div>
        </div>

        <?php
        Conexion::abrir_conexion();
        $empleados = RepositorioEmpleado::obtener_empleados(Conexion::obtener_conexion());
        Conexion::cerrar_conexion();

        if (count($empleados) > 0) {
            ?>

            <div class="table_responsive">
                <table class="tabla_contenido">
                    <thead>
                        <tr>
                            <th>Clave</th>
                            <th>Nombre</th>
                            <th>paterno</th>
                            <th>materno</th>
                            <th colspan="2">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($empleados as $i => $empleado) {
                            Conexion::abrir_conexion();
                            $puesto = RepositorioPuesto::obtener_puesto_por_clave($empleado->getCvl_puesto(), Conexion::obtener_conexion());
                            Conexion::cerrar_conexion();
                            ?>
                            <tr>
                                <td><?= $empleado->getClave(); ?></td>
                                <td><?= $empleado->getNombre(); ?></td>
                                <td><?= $empleado->getApaterno(); ?></td>
                                <td><?= $empleado->getAmaterno(); ?></td>
                                <td>
                                    <button class="btn_sm btn_exito js_open_modal" modal="modal_detalles_<?= $empleado->getClave(); ?>">
                                        detalles
                                    </button>
                                </td>
                                <td>
                                    <button class="btn_sm btn_peligro js_open_modal" modal="modal_eliminar_<?= $empleado->getClave(); ?>">
                                        eliminar
                                    </button>
                                </td>
                            </tr>

                            <!-- Ventala modal de detalle, defaul: cerrada -->
                        <div class="ventana_modal" id="modal_detalles_<?= $empleado->getClave(); ?>">
                            <div class="ventana_modal__content">
                                <div class="ventana_modal__titulo">
                                    Detalles de la persona
                                </div>
                                <div class="ventana_modal_cuerpo">
                                    <hr class="separador">
                                    Informacion inicial:
                                    <hr class="separador">
                                    <div class="presentacion_dos_columnas">
                                        <div>
                                            <p>Puesto de trabajo: <h4><?= $puesto->getPuesto(); ?></h4></p>
                                        </div>
                                        <div>
                                            <p>Registrado el: <h4><?= $empleado->getFechaReg(); ?></h4></p>
                                        </div>
                                    </div>
                                    <hr class="separador">
                                    Datos personales: 
                                    <hr class="separador">
                                    <div class="presentacion_dos_columnas">
                                        <div>
                                            <p>Nombre: <h4><?= $empleado->getNombre(); ?></h4></p>
                                        </div>
                                        <div>
                                            <p>Apellido paterno: <h4><?= $empleado->getApaterno(); ?></h4></p>
                                        </div>
                                        <div>
                                            <p>Apellido materno: <h4><?= $empleado->getAmaterno(); ?></h4></p>
                                        </div>
                                        <div>
                                            <p>Fecha de nacimiento: <h4><?= $empleado->getFechaNac(); ?></h4></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="ventana_modal__pie">
                                    <a href="<?= RUTA_EDITAR_EMPLEADO . "?empleado=" . $empleado->getClave(); ?>" class="btn btn_primary">Editar Información</a>
                                    <a class="btn btn_exito js_close_modal" modal="modal_detalles_<?= $empleado->getClave(); ?>">Cerrar Ventana</a>
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
                                    ¿Seguro qué deseas eliminar de forma permanente <b><?= $empleado->getNombre(); ?></b>?
                                </div>
                                <div class="ventana_modal__pie">
                                    <form method="post" class="form-inline">
                                        <input type="hidden" name="CLAVE_EMP" value="<?= $empleado->getClave(); ?>">
                                        <button type="submit" name="ELIMINAR_EMP" class="btn btn_peligro">Eliminar persona</button>
                                    </form>
                                    <a class="btn btn_exito js_close_modal" modal="modal_eliminar_<?= $empleado->getClave(); ?>">Cerrar Ventana</a>
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
            Escritor::pintar_no_hay_registros("No hay registro de empleados en la base de datos");
        }
        ?>
    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';




