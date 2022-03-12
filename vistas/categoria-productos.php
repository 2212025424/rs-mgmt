<?php
$titulo_documento = "Sistema RSMgmt || Categoria de productos || Categorias en El Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Script.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Categoria.inc.php';
include_once 'app/acceso/RepositorioCategoriaProducto.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

if (isset($_POST['REGISTRAR_CATE'])) {

    Conexion::abrir_conexion();

    $cate = Script::convertir_mayusculas($_POST['NOMBRE_CATE']);

    if (!RepositorioCategoriaProducto::existe_categoria($cate, Conexion::obtener_conexion())) {

        $clave = Script::generar_clave(10);
        while (RepositorioCategoriaProducto::existe_clave_categoria($clave, Conexion::obtener_conexion())) {
            $clave = Script::generar_clave(10);
        }

        $cate_obj = new Categoria($clave, $cate);
        $cate_insertada = RepositorioCategoriaProducto::insertar_categoria($cate_obj, Conexion::obtener_conexion());

        if ($cate_insertada) {
            echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: La categoria se ha insertado correctamente', 'alerta_exito');}; </script>";
        } else {
            echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: Se ha producido un error', 'alerta_error');}; </script>";
        }
    } else {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: La categoria ya existe en la base de datos', 'alerta_error');}; </script>";
    }

    Conexion::cerrar_conexion();
}


if (isset($_POST['ELIMINAR_CATE'])) {

    Conexion::abrir_conexion();
    $eliminada = RepositorioCategoriaProducto::eliminar_categoria_por_clave($_POST['CLAVE_CATE'], Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($eliminada) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: La categoria se ha eliminado correctamente', 'alerta_exito');}; </script>";
    } else {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: Se ha producido un error', 'alerta_error');}; </script>";
    }
}

if (isset($_POST['ACTUALIZAR_CATE'])) {

    $clave = $_POST['CLAVE_CATE'];
    $cate = Script::convertir_mayusculas($_POST['NOMBRE_CATE']);

    $cate_obj = new Categoria($clave, $cate);

    Conexion::abrir_conexion();
    $actualizada = RepositorioCategoriaProducto::actualizar_categoria_por_clave($cate_obj, Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($actualizada) {
        echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: La categoria se ha actualizado correctamente', 'alerta_exito');}; </script>";
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
    <div class="descripcion_documento">Categoria de productos</div>

    <div class="contenedor_contenido">

        <!-- Descriptcion de la seccion actual -->
        <div class="contenedor_encabezado_tabla">
            <div class="contenedor_mensaje_operacion" id="mensaje_opercion">

            </div>
            <div>
                <a type="button" class="btn btn_primary js_open_modal" modal="modal_registro">Agregar Nueva Categoria</a>
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
                        <input type="text" name="NOMBRE_CATE" class="form_cuadro_texto" placeholder="Nombre asiganado a la categoria. . ." required/>
                        <center>
                            <button type="submit" name="REGISTRAR_CATE" class="btn btn_primary">Guardar informacion</button> 
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
        $categorias = RepositorioCategoriaProducto::obtener_categorias(Conexion::obtener_conexion());
        Conexion::cerrar_conexion();

        if (count($categorias) > 0) {
            ?>
            <div class="tarjeta_contenido">
                <?php
                foreach ($categorias as $i => $categoria) {
                    ?>
                    <div class="tarjeta_contenido__tarjeta">
                        <div class="tarjeta_contenido__encabezado">
                            Categoria num. <?= $i + 1; ?>
                        </div>
                        <div class="tarjeta_contenido__cuerpo">
                            <?= $categoria->getCategoria(); ?>
                        </div>
                        <div class="tarjeta_contenido__pie">
                            <button class="btn_sm btn_primary js_open_modal" modal="modal_actualizar_<?= $categoria->getClave(); ?>">
                                Editar
                            </button>
                            <button class="btn_sm btn_peligro js_open_modal" modal="modal_eliminar_<?= $categoria->getClave(); ?>">
                                Eliminar
                            </button>
                        </div>
                    </div>

                    <!-- Ventala modal de actualizacion, defaul: cerrada -->
                    <div class="ventana_modal" id="modal_actualizar_<?= $categoria->getClave(); ?>">
                        <div class="ventana_modal__content">
                            <div class="ventana_modal__titulo">
                                Formulario actualización
                            </div>
                            <div class="ventana_modal_cuerpo">
                                <form method="post" autocomplete="off">
                                    <input type="hidden" value="<?= $categoria->getClave(); ?>" name="CLAVE_CATE">
                                    <input type="text" value="<?= $categoria->getCategoria(); ?>" name="NOMBRE_CATE" class="form_cuadro_texto" placeholder="Nombre asiganado a la caja. . ." required/>
                                    <center>
                                        <button type="submit" name="ACTUALIZAR_CATE" class="btn btn_primary">Actualizar informacion</button> 
                                    </center>
                                </form>
                            </div>
                            <div class="ventana_modal__pie">
                                <a class="btn btn_exito js_close_modal" modal="modal_actualizar_<?= $categoria->getClave(); ?>">Cerrar Ventana</a>
                            </div>
                        </div>
                    </div>

                    <!-- Ventala modal de eliminar, defaul: cerrada -->
                    <div class="ventana_modal" id="modal_eliminar_<?= $categoria->getClave(); ?>">
                        <div class="ventana_modal__content">
                            <div class="ventana_modal__titulo">
                                Mensaje de confirmación
                            </div>
                            <div class="ventana_modal_cuerpo">
                                ¿Seguro qué deseas eliminar de forma permanente <b><?= $categoria->getCategoria(); ?></b>?
                            </div>
                            <div class="ventana_modal__pie">
                                <form method="post" class="form-inline">
                                    <input type="hidden" name="CLAVE_CATE" value="<?= $categoria->getClave(); ?>">
                                    <button type="submit" name="ELIMINAR_CATE" class="btn btn_peligro">Eliminar Categoria</button>
                                </form>
                                <a class="btn btn_exito js_close_modal" modal="modal_eliminar_<?= $categoria->getClave(); ?>">Cerrar Ventana</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        } else {
            Escritor::pintar_no_hay_registros("No hay registro de categorias en la base de datos");
        }
        ?>
    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';


