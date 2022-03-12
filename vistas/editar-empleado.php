<?php
$titulo_documento = "Sistema RSMgmt || Editar informacion de empleados || Empleados El Cangrejo Dorado";

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

Conexion::abrir_conexion();
if (!isset($_GET['empleado']) || !RepositorioEmpleado::existe_clave_empleado($_GET['empleado'], Conexion::obtener_conexion())) {
    Redireccion::redirigir(RUTA_GESTOR_EMPLEADOS);
} else {
    $empleado = RepositorioEmpleado::obtener_empleado_por_clave($_GET['empleado'], Conexion::obtener_conexion());
}
Conexion::cerrar_conexion();

if (isset($_POST['REGISTRAR_EMP'])) {

    Conexion::abrir_conexion();

    $validador = new ValidadorEmpleado('editando', $_POST['PUESTO_EMP'], $_POST['NOMBRE_EMP'], $_POST['APA_EMP'], $_POST['AMA_EMP'], $_POST['FECHA_EMP'], Conexion::obtener_conexion());

    if ($validador->informacion_valida()) {

        $new_emp = new Empleado($empleado->getClave(), $validador->obtener_puesto(), $validador->obtener_nombre(), $validador->obtener_apaterno(), $validador->obtener_amaterno(), $validador->obtener_fecha(), '');

        $actualizado = RepositorioEmpleado::actualizar_empleado_por_clave($new_emp, Conexion::obtener_conexion());

        if ($actualizado) {
            echo "<script> window.onload = function() {mostrarMensajeOperacion('EXITO: Se ha atualizado de forma correcta', 'alerta_exito');}; </script>";
        } else {
            echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: Se ha producido un error', 'alerta_error');}; </script>";
        }
    } else {
        echo "La informacion no es correcta";
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
                        <a href="<?= RUTA_GESTOR_EMPLEADOS; ?>" class="btn btn_primary">Volver Gestor De Empleados</a>
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











