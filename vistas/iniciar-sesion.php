<?php
$titulo_documento = "Sistema RSMgmt || Iniciar sesion || Administrador, Cajero, Encargado de piso";

include_once 'app/transversal/config.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Usuario.inc.php';
include_once 'app/acceso/RepositorioUsuario.inc.php';
include_once 'app/modelo/Empleado.inc.php';
include_once 'app/acceso/RepositorioEmpleado.inc.php';
include_once 'app/negocio/ValidadorAcceso.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';

if (ControlSesion::sesion_iniciada()) {
    Redireccion::redirigir_usuario_inicio($_SESSION['CLAVE_ROL']);
}

if (isset($_POST['INICIAR_SESION'])) {
    Conexion::abrir_conexion();
    $validador = new ValidadorAcceso($_POST['CLAVE_USR'], $_POST['CONTRASENIA'], Conexion::obtener_conexion());
    Conexion::cerrar_conexion();

    if ($validador->obtener_error() == "" && !is_null($validador->obtener_usuario())) {

        Conexion::abrir_conexion();
        $empleado = RepositorioEmpleado::obtener_empleado_por_clave($validador->obtener_usuario()->getClv_empleado(), Conexion::obtener_conexion());
        Conexion::cerrar_conexion();

        ControlSesion::iniciar_sesion($validador->obtener_usuario()->getClv_empleado(), $empleado->getNombre(), $validador->obtener_usuario()->getClv_rol());

        if (ControlSesion::sesion_iniciada()) {
            Redireccion::redirigir_usuario_inicio($_SESSION['CLAVE_ROL']);
        }
    }
}

include_once 'plantillas/html-apertura.php';
?>

<div class="contenedor_sesion">
    <div class="contenedor_sesion__cont">
        <p>Iniciar Sesión</p>
        <form method="post" autocomplete="off">
            <input type="text" name="CLAVE_USR" required="required" class="form_cuadro_texto" placeholder="Ingresa clave de usuario" 
            <?php
            if (isset($_POST['INICIAR_SESION']) && isset($_POST['CLAVE_USR']) && !empty($_POST['CLAVE_USR'])) {
                echo "value='" . $_POST['CLAVE_USR'] . "'";
            }
            ?>
                   />
            <input type="password" name="CONTRASENIA" required="required" class="form_cuadro_texto" placeholder="Ingresa la contraseña" />     

            <?php
            if (isset($_POST['INICIAR_SESION'])) {
                echo "<p class='mensaje_error'>" . $validador->obtener_error() . "</p><br>";
            }
            ?>


            <button type="submit" name="INICIAR_SESION" class="btn btn_primary">Iniciar sesión</button> 
        </form>
    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';
