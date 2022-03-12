<?php
$titulo_documento = "Inicio RSMgmt || Inicio administrador || Menu principal Administrador";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

include_once 'plantillas/html-apertura.php';
include_once 'plantillas/html-menu-superior.php';
include_once 'plantillas/html-menu-lateral.php';
?>


<div class="main_container">
    <!-- ENCABEZADO DEL DOCUMENTO EN LA VISTA -->
    <div class="descripcion_documento">Bienvenido Administrador</div>

    <div class="tarjetas_presentacion">

        <div class="tarjeta_presentacion">
            <div class="tarjeta_presentacion__encabezado">
                Empleados de la empresa
            </div>
            <div class="tarjeta_presentacion__cuerpo">
                <img src="<?= RUTA_IMG; ?>AgregarUsuario.png" class="tarjeta_presentacion_img"/>
                <p>5 PERSONAS REGISTRADAS</p>
                <a class="btn_sm btn_primary" href="<?= RUTA_GESTOR_EMPLEADOS; ?>">VER EMPLEADOS</a>
            </div>
        </div>

        <div class="tarjeta_presentacion">
            <div class="tarjeta_presentacion__encabezado">
                Usuarios del sistema
            </div>
            <div class="tarjeta_presentacion__cuerpo">
                <img src="<?= RUTA_IMG; ?>Empleados.png" class="tarjeta_presentacion_img">
                <p>3 USUARIOS REGISTRADOS</p>
                <a class="btn_sm btn_primary" href="<?= RUTA_GESTOR_USUARIOS; ?>">VER USUARIOS</a>
            </div>
        </div>

        <div class="tarjeta_presentacion">
            <div class="tarjeta_presentacion__encabezado">
                Puestos de trabajo
            </div>
            <div class="tarjeta_presentacion__cuerpo">
                <img src="<?= RUTA_IMG; ?>puestos.png" class="tarjeta_presentacion_img">
                <p>CUENTAS CON 3 PUESTOS</p>
                <a class="btn_sm btn_primary" href="<?= RUTA_PUESTOS_TRABAJO; ?>">VER PUESTOS</a>
            </div>
        </div>

    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';
