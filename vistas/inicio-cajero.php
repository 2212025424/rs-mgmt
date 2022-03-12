<?php
$titulo_documento = "Sistema RSMgmt || Inicio cajero || Menu principal cajero";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';

if (!ControlSesion::sesion_iniciada_cajero()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}
?>
<br>
<center>
	<h2>BIENVENIDO</h2>
	<img style="width: 30%" src="<?= RUTA_IMG; ?>Compras.png" class="tarjeta_presentacion_img">
	<p><?= $_SESSION['NOMBRE_USUARIO'];?> - CAJERO</p>
	<a href="<?= RUTA_CERRAR_SESION?>"> Cerrar Sesion</a>
</center>