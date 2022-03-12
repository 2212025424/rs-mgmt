<?php
$titulo_documento = "Sistema RSMgmt || Editar informacion de insumo || Insumos El Cangrejo Dorado";

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

Conexion::abrir_conexion();
if (!isset($_GET['insumo']) || !RepositorioInsumo::existe_clave_insumo($_GET['insumo'], Conexion::obtener_conexion())) {
    Redireccion::redirigir(RUTA_GESTOR_INSUMOS);
} else {
    $insumo = RepositorioInsumo::obtener_insumo_por_clave($_GET['insumo'], Conexion::obtener_conexion());
}
Conexion::cerrar_conexion();

if (isset($_POST['REGISTRAR_INS'])) {

    Conexion::abrir_conexion();

    $validador = new ValidadorInsumo($insumo->getClave(), $_POST['NOMBRE_INS'], $_POST['EXISTENCIAS_INS'], $_POST['REORDEN_INS'], $_POST['PROVEEDOR_INS'], $_POST['CATEGORIA_INS'], $_POST['UNIDAD_INS'], $_POST['COMENTARIO_INS'], Conexion::obtener_conexion());

    if ($validador->informacion_valida()) {

        $new_insumo = new Insumo($insumo->getClave(), $validador->obtener_proveedor(), $validador->obtener_categoria(), $validador->obtener_unidad(), $validador->obtener_insumo(), $validador->obtener_existencias(), $validador->obtener_reOrden(), $validador->obtener_nota());

        $actualizado = RepositorioInsumo::actualizar_insumo_por_clave($new_insumo, Conexion::obtener_conexion());

        if ($actualizado) {
            echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: Se ha atualizado de forma correcta', 'alerta_exito');}; </script>";
        } else {
            echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: Se ha producido un error', 'alerta_error');}; </script>";
        }
    }
    Conexion::cerrar_conexion();
}

include_once 'plantillas/html-apertura.php';
include_once 'plantillas/html-menu-superior.php';
include_once 'plantillas/html-menu-lateral.php';
?>

<div class="main_container">

    <!-- ENCABEZADO DEL DOCUMENTO EN LA VISTA -->
    <div class="descripcion_documento">EDITAR INFORMACION EMPLEADO</div>

    <div class="contenedor_contenido">
        <div class="main_container__cuerpo">
            <div class="cont_main_form">

                <!-- Descriptcion de la seccion actual -->
                <div class="contenedor_encabezado_tabla">
                    <div>
                        <p>Editar la informacion del insumo</p>
                    </div>
                    <div>
                        <a href="<?= RUTA_GESTOR_INSUMOS; ?>" class="btn btn_primary">Volver Gestor De Insumos</a>
                    </div>
                </div>                
                <hr class="separador">
                <div class="contenedor_mensaje_operacion" id="mensaje_opercion">
                    <!-- Se mostrará el mensaje de la operacion realizada -->
                </div>

<?php
Conexion::abrir_conexion();
$proveedores = RepositorioProveedor::obtener_proveedores(Conexion::obtener_conexion());
$categorias = RepositorioCategoriaInsumo::obtener_categorias(Conexion::obtener_conexion());
$uniades = RepositorioUnidad::obtener_unidades(Conexion::obtener_conexion());
Conexion::cerrar_conexion();
if (isset($_POST['REGISTRAR_INS'])) {
    include_once 'plantillas/form-insumo-validado.php';
} else {
    include_once 'plantillas/form-insumo-vacio.php';
}
?>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';
?>
<script src="<?php echo RUTA_JS; ?>eventos/editar-insumo.js"></script>











