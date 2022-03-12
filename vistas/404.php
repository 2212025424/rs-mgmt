<?php
header($_SERVER['SERVER_PROTOCOL'] . "404 Not Found", true, 404);

$titulo_documento = "Sistema RSMgmt || 404 error de enrrutacion || El Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';

include_once 'plantillas/html-apertura.php';
?>

<div class="contenedor_sesion">
    <div class="contenedor_sesion__cont">
        <div class="contenedor_img">

            <p>404: Lo sentimos !!</p>

            <img src="<?php echo RUTA_IMG; ?>NoCoincidencias.png" class="contenedor_img__imagen_gr"/>
            <h4>La pagina a la que intenta acceder, no existe.</h4>
            <br>
            <a class="btn btn_primary" href="<?= RUTA_INICIAR_SESION; ?>">VOLVER A INICIO</a>
        </div>
    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';
