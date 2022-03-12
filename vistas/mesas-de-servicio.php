<?php
$titulo_documento = "Sistema RSMgmt || Mesas de servicio || Mesas de servicio El Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Script.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Mesa.inc.php';
include_once 'app/acceso/RepositorioMesa.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

if (isset($_POST['REGISTRAR_MESA'])) {

    Conexion::abrir_conexion();

    $mesa = Script::convertir_mayusculas($_POST['NOMBRE_MESA']);

    $estado = 0;
    if (isset($_POST['ESTADO_MESA'])) {
        $estado = 1;
    }

    if (!RepositorioMesa::existe_nombre_mesa($mesa, Conexion::obtener_conexion())) {

        $clave = Script::generar_clave(10);
        while (RepositorioMesa::existe_clave_mesa($clave, Conexion::obtener_conexion())) {
            $clave = Script::generar_clave(10);
        }

        $mesa_obj = new Mesa($clave, $mesa, $estado);
        $mesa_insertada = RepositorioMesa::insertar_mesa($mesa_obj, Conexion::obtener_conexion());

        if ($mesa_insertada) {
            echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: La mesa se ha insertado correctamente', 'alerta_exito');}; </script>";
        } else {
            echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: Se ha producido un error', 'alerta_error');}; </script>";
        }
    } else {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: La mesa ya existe en la base de datos', 'alerta_error');}; </script>";
    }

    Conexion::cerrar_conexion();
}


if (isset($_POST['ELIMINAR_MESA'])) {

    Conexion::abrir_conexion();
    $eliminado = RepositorioMesa::eliminar_mesa_por_clave($_POST['CLAVE_MESA'], Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($eliminado) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: La mesa se ha eliminado correctamente', 'alerta_exito');}; </script>";
    } else {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: Se ha producido un error', 'alerta_error');}; </script>";
    }
}

if (isset($_POST['ACTUALIZAR_MESA'])) {

    $estado = 0;
    if (isset($_POST['ESTADO_MESA'])) {
        $estado = 1;
    }

    $clave = $_POST['CLAVE_MESA'];
    $mesa = Script::convertir_mayusculas($_POST['NOMBRE_MESA']);

    $mesa_obj = new Mesa($clave, $mesa, $estado);

    Conexion::abrir_conexion();
    $actualizado = RepositorioMesa::actualizar_mesa_por_clave($mesa_obj, Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($actualizado) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: La mesa se ha eliminado correctamente', 'alerta_exito');}; </script>";
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
    <div class="descripcion_documento">Mesas de servicio</div>

    <div class="contenedor_contenido">

        <!-- Descriptcion de la seccion actual -->
        <div class="contenedor_encabezado_tabla">
            <div class="contenedor_mensaje_operacion" id="mensaje_opercion">

            </div>
            <div>
                <a type="button" class="btn btn_primary js_open_modal" modal="modal_registro">Agregar Nueva Mesa</a>
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
                        <input type="text" name="NOMBRE_MESA" class="form_cuadro_texto" placeholder="Nombre asiganado a la mesa. . ." required/>
                        <input type="checkbox" id="check" name="ESTADO_MESA" class="form_checkbox" checked/>
                        <label for="check">Actualmente disponible !</label>
                        <center>
                            <button type="submit" name="REGISTRAR_MESA" class="btn btn_primary">Guardar informacion</button> 
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
        $mesas = RepositorioMesa::obtener_mesas(Conexion::obtener_conexion());
        Conexion::cerrar_conexion();

        if (count($mesas) > 0) {
            ?>
            <div class="tarjeta_contenido">
                <?php
                foreach ($mesas as $mesa) {
                    ?>
                    <div class="tarjeta_contenido__tarjeta">
                        <div class="tarjeta_contenido__encabezado">
                            <?= $mesa->getMesa(); ?>
                        </div>
                        <div class="tarjeta_contenido__cuerpo">
                            Estado: <?= Escritor::determinar_estado_caja($mesa->getEstado()); ?>
                        </div>
                        <div class="tarjeta_contenido__pie">
                            <button class="btn_sm btn_primary js_open_modal" modal="modal_actualizar_<?= $mesa->getClave(); ?>">
                                Editar
                            </button>
                            <button class="btn_sm btn_peligro js_open_modal" modal="modal_eliminar_<?= $mesa->getClave(); ?>">
                                Eliminar
                            </button>
                        </div>
                    </div>

                    <!-- Ventala modal de actualizacion, defaul: cerrada -->
                    <div class="ventana_modal" id="modal_actualizar_<?= $mesa->getClave(); ?>">
                        <div class="ventana_modal__content">
                            <div class="ventana_modal__titulo">
                                Formulario actualización
                            </div>
                            <div class="ventana_modal_cuerpo">
                                <form method="post" autocomplete="off">
                                    <input type="hidden" value="<?= $mesa->getClave(); ?>" name="CLAVE_MESA">
                                    <input type="text" value="<?= $mesa->getMesa(); ?>" name="NOMBRE_MESA" class="form_cuadro_texto" placeholder="Nombre asiganado a la mesa. . ." required/>
                                    <input type="checkbox" id="ck_<?= $mesa->getClave(); ?>" name="ESTADO_MESA" class="form_checkbox" <?= Escritor::estado_check($mesa->getEstado()); ?>/>
                                    <label for="ck_<?= $mesa->getClave(); ?>">Actualmente disponible !</label>
                                    <center>
                                        <button type="submit" name="ACTUALIZAR_MESA" class="btn btn_primary">Actualizar informacion</button> 
                                    </center>
                                </form>
                            </div>
                            <div class="ventana_modal__pie">
                                <a class="btn btn_exito js_close_modal" modal="modal_actualizar_<?= $mesa->getClave(); ?>">Cerrar Ventana</a>
                            </div>
                        </div>
                    </div>
                    <!-- Ventala modal de eliminar, defaul: cerrada -->
                    <div class="ventana_modal" id="modal_eliminar_<?= $mesa->getClave(); ?>">
                        <div class="ventana_modal__content">
                            <div class="ventana_modal__titulo">
                                Mensaje de confirmación
                            </div>
                            <div class="ventana_modal_cuerpo">
                                ¿Seguro qué deseas eliminar de forma permanente <b><?= $mesa->getMesa(); ?></b>?
                            </div>
                            <div class="ventana_modal__pie">
                                <form method="post" class="form-inline">
                                    <input type="hidden" name="CLAVE_MESA" value="<?= $mesa->getClave(); ?>">
                                    <button type="submit" name="ELIMINAR_MESA" class="btn btn_peligro">Eliminar Mesa</button>
                                </form>
                                <a class="btn btn_exito js_close_modal" modal="modal_eliminar_<?= $mesa->getClave(); ?>">Cerrar Ventana</a>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </div>
            <?php
        } else {
            Escritor::pintar_no_hay_registros("No hay registro de mesas en la base de datos");
        }
        ?>
    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';


