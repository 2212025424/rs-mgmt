<?php
$titulo_documento = "Sistema RSMgmt || Puestos de trabajo || Puestos de trabajo Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Script.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Puesto.inc.php';
include_once 'app/acceso/RepositorioPuesto.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

if (isset($_POST['REGISTRAR_PUESTO'])) {

    Conexion::abrir_conexion();

    $puesto = Script::convertir_mayusculas($_POST['NOMBRE_PUESTO']);
    $nota = Script::convertir_mayusculas($_POST['NOTA_PUESTO']);

    if (!RepositorioPuesto::existe_nombre_puesto($puesto, Conexion::obtener_conexion())) {

        $clave = Script::generar_clave(10);
        while (RepositorioPuesto::existe_clave_puesto($clave, Conexion::obtener_conexion())) {
            $clave = Script::generar_clave(10);
        }

        $puesto_obj = new Puesto($clave, $puesto, $nota);

        $insertado = RepositorioPuesto::insertar_puesto($puesto_obj, Conexion::obtener_conexion());

        if ($insertado) {
            echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: El puesto se ha insertado correctamente', 'alerta_exito');}; </script>";
        } else {
            echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: Se ha producido un error', 'alerta_error');}; </script>";
        }
    } else {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: El puesto ya existe en la base de datos', 'alerta_error');}; </script>";
    }

    Conexion::cerrar_conexion();
}

if (isset($_POST['ACTUALIZAR_PUESTO'])) {

    Conexion::abrir_conexion();

    $clave = $_POST['CLAVE_PUESTO'];
    $puesto = Script::convertir_mayusculas($_POST['NOMBRE_PUESTO']);
    $nota = Script::convertir_mayusculas($_POST['NOTA_PUESTO']);

    $puesto_obj = new Puesto($clave, $puesto, $nota);

    $actualizado = RepositorioPuesto::actualizar_puesto_por_clave($puesto_obj, Conexion::obtener_conexion());

    if ($actualizado) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: El puesto se ha actualizado correctamente', 'alerta_exito');}; </script>";
    } else {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: Se ha producido un error', 'alerta_error');}; </script>";
    }

    Conexion::cerrar_conexion();
}

if (isset($_POST['ELIMINAR_PUESTO'])) {
    Conexion::abrir_conexion();
    $eliminado = RepositorioPuesto::eliminar_puesto_por_clave($_POST['CLAVE_PUESTO'], Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($eliminado) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO:El puesto se ha eliminado correctamente', 'alerta_exito');}; </script>";
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
    <div class="descripcion_documento">Puestos de trabajo</div>

    <div class="contenedor_contenido">


        <!-- Descriptcion de la seccion actual -->
        <div class="contenedor_encabezado_tabla">
            <div class="contenedor_mensaje_operacion" id="mensaje_opercion">

            </div>
            <div>
                <a type="button" class="btn btn_primary js_open_modal" modal="modal_registro">Agregar Nuevo Puesto</a>
            </div>
        </div>

        <!-- Ventala modal de registro, defaul: cerrada -->
        <div class="ventana_modal" id="modal_registro">
            <div class="ventana_modal__content">
                <div class="ventana_modal__titulo">
                    Formulario de registro
                </div>
                <div class="ventana_modal_cuerpo">
                    <form method="post" autocomplete="off">
                        <input type="text" name="NOMBRE_PUESTO" class="form_cuadro_texto" placeholder="Nombre del puesto. . ." required/>
                        <textarea name="NOTA_PUESTO" class="form_textarea" placeholder="Comentario del puesto"/></textarea>
                        <center>
                            <button type="submit" name="REGISTRAR_PUESTO" class="btn btn_primary">Guardar informacion</button> 
                        </center>
                    </form>
                </div>
                <div class="ventana_modal__pie">
                    <a class="btn btn_exito js_close_modal" modal="modal_registro">Cerrar Ventana</a>
                </div>
            </div>
        </div>

        <?php
        Conexion::abrir_conexion();
        $puestos = RepositorioPuesto::obtener_puestos(Conexion::obtener_conexion());
        Conexion::cerrar_conexion();

        if (count($puestos) > 0) {
            ?>
            <div class="table_responsive">
                <table class="tabla_contenido">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Puesto</th>
                            <th>Descripción</th>
                            <th colspan="2">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($puestos as $i => $puesto) {
                            ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= $puesto->getPuesto(); ?></td>
                                <td><?= Escritor::determinar_nota($puesto->getNota()); ?></td>
                                <td>
                                    <button class="btn_sm btn_alerta js_open_modal" modal="modal_actualizar_<?= $puesto->getClave(); ?>">
                                        editar
                                    </button>
                                </td>
                                <td>
                                    <button class="btn_sm btn_peligro js_open_modal" modal="modal_eliminar_<?= $puesto->getClave(); ?>">
                                        eliminar
                                    </button>
                                </td>
                            </tr>

                            <!-- Ventala modal de actualizacion, defaul: cerrada -->
                        <div class="ventana_modal" id="modal_actualizar_<?= $puesto->getClave(); ?>">
                            <div class="ventana_modal__content">
                                <div class="ventana_modal__titulo">
                                    Formulario actualización
                                </div>
                                <div class="ventana_modal_cuerpo">
                                    <form method="post" autocomplete="off">
                                        <input type="hidden" value="<?= $puesto->getClave(); ?>" name="CLAVE_PUESTO">
                                        <input type="text" value="<?= $puesto->getPuesto(); ?>" name="NOMBRE_PUESTO" class="form_cuadro_texto" placeholder="Nombre del puesto. . ." required/>
                                        <textarea name="NOTA PUESTO" class="form_textarea" placeholder="Comentario del puesto"/><?= $puesto->getNota(); ?></textarea>
                                        <center>
                                            <button type="submit" name="ACTUALIZAR_PUESTO" class="btn btn_primary">Actualizar informacion</button> 
                                        </center>
                                    </form>
                                </div>
                                <div class="ventana_modal__pie">
                                    <a class="btn btn_exito js_close_modal" modal="modal_actualizar_<?= $puesto->getClave(); ?>">Cerrar Ventana</a>
                                </div>
                            </div>
                        </div>
                        <!-- Ventala modal de eliminar, defaul: cerrada -->
                        <div class="ventana_modal" id="modal_eliminar_<?= $puesto->getClave(); ?>">
                            <div class="ventana_modal__content">
                                <div class="ventana_modal__titulo">
                                    Mensaje de confirmación
                                </div>
                                <div class="ventana_modal_cuerpo">
                                    ¿Seguro qué deseas eliminar de forma permanente <b><?= $puesto->getPuesto(); ?></b>?
                                </div>
                                <div class="ventana_modal__pie">
                                    <form method="post" class="form-inline">
                                        <input type="hidden" name="CLAVE_PUESTO" value="<?= $puesto->getClave(); ?>">
                                        <button type="submit" name="ELIMINAR_PUESTO" class="btn btn_peligro">Eliminar Puesto</button>
                                    </form>
                                    <a class="btn btn_exito js_close_modal" modal="modal_eliminar_<?= $puesto->getClave(); ?>">Cerrar Ventana</a>
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
            Escritor::pintar_no_hay_registros("No hay registro de puestos en la base de datos");
        }
        ?>

    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';

