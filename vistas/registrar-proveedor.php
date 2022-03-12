<?php
$titulo_documento = "Sistema RSMgmt || Registrar proveedores || Proveedores El Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Script.inc.php';
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

if (isset($_POST['REGISTRAR_PRO'])) {

    Conexion::abrir_conexion();
    $validador = new ValidadorProveedor('registrar', $_POST['RAZ_SOC'], $_POST['RFC'], $_POST['TEL'], $_POST['CORREO'], $_POST['COMENTARIO'], Conexion::obtener_conexion());

    if ($validador->informacion_valida()) {

        $clave = Script::generar_clave(10);
        while (RepositorioProveedor::existe_clave_proveedor($clave, Conexion::obtener_conexion())) {
            $clave = Script::generar_clave(10);
        }

        $proveedor_obj = new Proveedor($clave, $validador->obtener_razonsocial(), $validador->obtener_RFC(), $validador->obtener_telefono(), $validador->obtener_correo(), $validador->obtener_nota());

        $insertado = RepositorioProveedor::insertar_proveedor($proveedor_obj, Conexion::obtener_conexion());

        if ($insertado) {
            $validador->limpiar_datos_validador();
            echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: EL proveedor se ha insertado correctamente', 'alerta_exito');}; </script>";
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
    <div class="descripcion_documento">Registro de proveedor</div>

    <div class="contenedor_contenido">
        <div class="main_container__cuerpo">
            <div class="cont_main_form">

                <!-- Descriptcion de la seccion actual -->
                <div class="contenedor_encabezado_tabla">
                    <div>
                        <p>Ingresa los datos del proveedor</p>
                    </div>
                    <div>
                        <a href="<?= RUTA_GESTOR_PROVEEDORES; ?>" class="btn btn_primary">Gestor De Proveedores</a>
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


