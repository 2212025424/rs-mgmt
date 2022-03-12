<?php
$titulo_documento = "Sistema RSMgmt || Editar informacion del proveedor || Proveedores El Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Proveedor.inc.php';
include_once 'app/acceso/RepositorioProveedor.inc.php';
include_once 'app/negocio/ValidadorProveedor.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

Conexion::abrir_conexion();
if (!isset($_GET['proveedor']) || !RepositorioProveedor::existe_clave_proveedor($_GET['proveedor'], Conexion::obtener_conexion())) {
    Redireccion::redirigir(RUTA_GESTOR_PROVEEDORES);
} else {
    $proveedor = RepositorioProveedor::obtener_proveedor_por_clave($_GET['proveedor'], Conexion::obtener_conexion());
}
Conexion::cerrar_conexion();

if (isset($_POST['REGISTRAR_PRO'])) {

    Conexion::abrir_conexion();

    $validador = new ValidadorProveedor($proveedor->getClave(), $_POST['RAZ_SOC'], $_POST['RFC'], $_POST['TEL'], $_POST['CORREO'], $_POST['COMENTARIO'], Conexion::obtener_conexion());

    if ($validador->informacion_valida()) {

        $new_proveedor = new Proveedor($proveedor->getClave(), $validador->obtener_razonsocial(), $validador->obtener_RFC(), $validador->obtener_telefono(), $validador->obtener_correo(), $validador->obtener_nota());

        $actualizado = RepositorioProveedor::actualizar_proveedor_por_clave($new_proveedor, Conexion::obtener_conexion());

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
                        <p>Editar la informacion de la persona</p>
                    </div>
                    <div>
                        <a href="<?= RUTA_GESTOR_PROVEEDORES; ?>" class="btn btn_primary">Volver Gestor De Proveedores</a>
                    </div>
                </div>                
                <hr class="separador">
                <div class="contenedor_mensaje_operacion" id="mensaje_opercion">
                    <!-- Se mostrará el mensaje de la operacion realizada -->
                </div>

                <?php
                if (isset($_POST['REGISTRAR_PRO'])) {
                    include_once 'plantillas/form-proveedor-validado.php';
                } else {
                    include_once 'plantillas/form-proveedor-vacio.php';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';











