<?php
$titulo_documento = "Sistema RSMgmt || Apertura de cajas || Cajas de cobro El Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Script.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Caja.inc.php';
include_once 'app/acceso/RepositorioCaja.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}


if (isset($_POST['REGISTRAR_CAJA'])) {

    Conexion::abrir_conexion();

    $caja = Script::convertir_mayusculas($_POST['NOMBRE_CAJA']);

    if (isset($_POST['ESTADO_CAJA'])) {
        $estado = 1;
    } else {
        $estado = 0;
    }

    if (!RepositorioCaja::existe_nombre_caja($caja, Conexion::obtener_conexion())) {

        $clave = Script::generar_clave(10);
        while (RepositorioCaja::existe_clave_caja($clave, Conexion::obtener_conexion())) {
            $clave = Script::generar_clave(10);
        }

        $caja_obj = new Caja($clave, $caja, $estado);
        $caja_insertada = RepositorioCaja::insertar_caja($caja_obj, Conexion::obtener_conexion());

        if ($caja_insertada) {
            echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: La caja se ha insertado correctamente', 'alerta_exito');}; </script>";
        } else {
            echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: Se ha producido un error', 'alerta_error');}; </script>";
        }
    } else {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: La caja ya existe en la base de datos', 'alerta_error');}; </script>";
    }

    Conexion::cerrar_conexion();
}


if (isset($_POST['ELIMINAR_CAJA'])) {

    Conexion::abrir_conexion();
    $eliminado = RepositorioCaja::eliminar_caja_por_clave($_POST['CLAVE_CAJA'], Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($eliminado) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: La caja se ha eliminado correctamente', 'alerta_exito');}; </script>";
    } else {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: Se ha producido un error', 'alerta_error');}; </script>";
    }
}

if (isset($_POST['ACTUALIZAR_CAJA'])) {

    $estado = 0;
    if (isset($_POST['ESTADO_CAJA'])) {
        $estado = 1;
    }

    $clave = $_POST['CLAVE_CAJA'];
    $caja = Script::convertir_mayusculas($_POST['NOMBRE_CAJA']);

    $caja_obj = new Caja($clave, $caja, $estado);

    Conexion::abrir_conexion();
    $actualizado = RepositorioCaja::actualizar_caja_por_clave($caja_obj, Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($actualizado) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: La caja se ha actualizado correctamente', 'alerta_exito');}; </script>";
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
    <div class="descripcion_documento">cajas de cobro</div>

    <div class="contenedor_contenido">

        <!-- Descriptcion de la seccion actual -->
        <div class="contenedor_encabezado_tabla">
            <div class="contenedor_mensaje_operacion" id="mensaje_opercion">

            </div>
            <div>
                <a type="button" class="btn btn_primary js_open_modal" modal="modal_registro">Agregar Nueva Caja</a>
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
                        <input type="text" name="NOMBRE_CAJA" class="form_cuadro_texto" placeholder="Nombre asiganado a la caja. . ." required/>
                        <input type="checkbox" id="check" name="ESTADO_CAJA" class="form_checkbox" checked/>
                        <label for="check">Actualmente disponible !</label>
                        <center>
                            <button type="submit" name="REGISTRAR_CAJA" class="btn btn_primary">Guardar informacion</button> 
                        </center>
                    </form>
                </div>
                <div class="ventana_modal__pie">
                    <a class="btn btn_exito js_close_modal" modal="modal_registro">Cerrar Ventana</a>
                </div>
            </div>
        </div>
        <br>
        <div class="main_container__cuerpo">
            <div class="tarjeta_contenido">

                <?php
                Conexion::abrir_conexion();
                $cajas = RepositorioCaja::obtener_cajas(Conexion::obtener_conexion());
                Conexion::cerrar_conexion();

                if (count($cajas) > 0) {
                    foreach ($cajas as $caja) {
                        ?>
                        <div class="tarjeta_contenido__tarjeta">
                            <div class="tarjeta_contenido__encabezado">
                                <?= $caja->getCaja(); ?>
                            </div>
                            <div class="tarjeta_contenido__cuerpo">
                                Estado: <?= Escritor::determinar_estado_caja($caja->getEstado()); ?>
                            </div>
                            <div class="tarjeta_contenido__pie">
                                <button class="btn_sm btn_primary js_open_modal" modal="modal_actualizar_<?= $caja->getClave(); ?>">
                                    Editar
                                </button>
                                <button class="btn_sm btn_peligro js_open_modal" modal="modal_eliminar_<?= $caja->getClave(); ?>">
                                    Eliminar
                                </button>
                            </div>
                        </div>

                        <!-- Ventala modal de actualizacion, defaul: cerrada -->
                        <div class="ventana_modal" id="modal_actualizar_<?= $caja->getClave(); ?>">
                            <div class="ventana_modal__content">
                                <div class="ventana_modal__titulo">
                                    Formulario actualización
                                </div>
                                <div class="ventana_modal_cuerpo">
                                    <form method="post" autocomplete="off">
                                        <input type="hidden" value="<?= $caja->getClave(); ?>" name="CLAVE_CAJA">
                                        <input type="text" value="<?= $caja->getCaja(); ?>" name="NOMBRE_CAJA" class="form_cuadro_texto" placeholder="Nombre asiganado a la caja. . ." required/>
                                        <input type="checkbox" id="ck_<?= $caja->getClave(); ?>" name="ESTADO_CAJA" class="form_checkbox" <?= Escritor::estado_check($caja->getEstado()); ?>/>
                                        <label for="ck_<?= $caja->getClave(); ?>">Actualmente disponible !</label>
                                        <center>
                                            <button type="submit" name="ACTUALIZAR_CAJA" class="btn btn_primary">Actualizar informacion</button> 
                                        </center>
                                    </form>
                                </div>
                                <div class="ventana_modal__pie">
                                    <a class="btn btn_exito js_close_modal" modal="modal_actualizar_<?= $caja->getClave(); ?>">Cerrar Ventana</a>
                                </div>
                            </div>
                        </div>
                        <!-- Ventala modal de eliminar, defaul: cerrada -->
                        <div class="ventana_modal" id="modal_eliminar_<?= $caja->getClave(); ?>">
                            <div class="ventana_modal__content">
                                <div class="ventana_modal__titulo">
                                    Mensaje de confirmación
                                </div>
                                <div class="ventana_modal_cuerpo">
                                    ¿Seguro qué deseas eliminar de forma permanente <b><?= $caja->getCaja(); ?></b>?
                                </div>
                                <div class="ventana_modal__pie">
                                    <form method="post" class="form-inline">
                                        <input type="hidden" name="CLAVE_CAJA" value="<?= $caja->getClave(); ?>">
                                        <button type="submit" name="ELIMINAR_CAJA" class="btn btn_peligro">Eliminar Caja</button>
                                    </form>
                                    <a class="btn btn_exito js_close_modal" modal="modal_eliminar_<?= $caja->getClave(); ?>">Cerrar Ventana</a>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    Escritor::pintar_no_hay_registros("No hay registro de cajas en la base de datos");
                }
                ?>
            </div>
        </div>

    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';


