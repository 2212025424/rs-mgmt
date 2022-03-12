<?php
$titulo_documento = "Sistema RSMgmt || registro de empleados || Empleados del Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Puesto.inc.php';
include_once 'app/acceso/RepositorioPuesto.inc.php';
include_once 'app/modelo/Empleado.inc.php';
include_once 'app/acceso/RepositorioEmpleado.inc.php';
include_once 'app/negocio/ValidadorEmpleado.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

if (isset($_POST['REGISTRAR_EMP'])) {

    Conexion::abrir_conexion();

    $validador = new ValidadorEmpleado($_POST['CLAVE_EMP'], $_POST['PUESTO_EMP'], $_POST['NOMBRE_EMP'], $_POST['APA_EMP'], $_POST['AMA_EMP'], $_POST['FECHA_EMP'], Conexion::obtener_conexion());

    if ($validador->informacion_valida()) {

        $empleado = new Empleado($validador->obtener_clave(), $validador->obtener_puesto(), $validador->obtener_nombre(), $validador->obtener_apaterno(), $validador->obtener_amaterno(), $validador->obtener_fecha(), '');

        $insertado = RepositorioEmpleado::insertar_empleado($empleado, Conexion::obtener_conexion());

        if ($insertado) {

            $validador->limpiar_datos_validador();

            echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: Se ha insertado de forma correcta', 'alerta_exito');}; </script>";
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
    <div class="descripcion_documento">Registro de empleado</div>

    <div class="contenedor_contenido">
        <div class="main_container__cuerpo">
            <div class="cont_main_form">

                <!-- Descriptcion de la seccion actual -->
                <div class="contenedor_encabezado_tabla">
                    <div>
                        <p>Ingresa los datos de la persona</p>
                    </div>
                    <div>
                        <a href="<?= RUTA_GESTOR_EMPLEADOS; ?>" class="btn btn_primary">Gestor De Empleados</a>
                    </div>
                </div>                
                <hr class="separador">
                <div class="contenedor_mensaje_operacion" id="mensaje_opercion">
                    <!-- Se mostrará el mensaje de la operacion realizada -->
                </div>

                <?php
                if (isset($_POST['REGISTRAR_EMP'])) {
                    include_once 'plantillas/form-empleado-validado.php';
                } else {
                    include_once 'plantillas/form-empleado-vacio.php';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';



