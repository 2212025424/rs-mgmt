<?php
$titulo_documento = "Sistema RSMgmt || registro de usuarios || Usuarios del Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Rol.inc.php';
include_once 'app/acceso/RepositorioRol.inc.php';
include_once 'app/modelo/Empleado.inc.php';
include_once 'app/acceso/RepositorioEmpleado.inc.php';
include_once 'app/modelo/Usuario.inc.php';
include_once 'app/acceso/RepositorioUsuario.inc.php';
include_once 'app/negocio/ValidadorUsuario.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

if (isset($_POST['REGISTRAR_USR'])) {

    $estado = 0;
    if (isset($_POST['ESTADO_USR'])) {
        $estado = 1;
    }

    Conexion::abrir_conexion();

    $validador = new ValidadorUsuario($_POST['CVL_ROL'], $_POST['CLV_EMP'], $_POST['PASS_1'], $_POST['PASS_2'], Conexion::obtener_conexion());

    if ($validador->informacion_valida()) {

        $usuario = new Usuario($validador->obtener_empleado(), $validador->obtener_rol(), $validador->obtener_password(), $estado);

        $insertado = RepositorioUsuario::insertar_usuario($usuario, Conexion::obtener_conexion());

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
    <div class="descripcion_documento">Resgistro de usuario</div>

    <div class="contenedor_contenido">
        <div class="main_container__cuerpo">
            <div class="cont_main_form">

                <div class="contenedor_encabezado_tabla">
                    <div>
                        <p>Ingresa los datos del usuario</p>
                    </div>
                    <div>
                        <a href="<?= RUTA_GESTOR_USUARIOS; ?>" class="btn btn_primary">Gestor de Usuarios</a>
                    </div>
                </div>               
                <hr class="separador">
                <div class="contenedor_mensaje_operacion" id="mensaje_opercion">
                    <!-- Se mostrará el mensaje de la operacion realizada -->
                </div>                

                <?php
                Conexion::abrir_conexion();
                $roles = RepositorioRol::obtener_roles(Conexion::obtener_conexion());
                $empleados = RepositorioEmpleado::obtener_empleados_sin_cuenta(Conexion::obtener_conexion());
                Conexion::cerrar_conexion();

                if (isset($_POST['REGISTRAR_USR'])) {
                    include_once 'plantillas/form-usuario-validado.php';
                } else {
                    include_once 'plantillas/form-usuario-vacio.php';
                }
                ?>

            </div>
        </div>
    </div>
</div>



<?php
include_once 'plantillas/html-cierre.php';




