<?php

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';

ControlSesion :: cerrar_sesion();
Redireccion::redirigir(RUTA_INICIAR_SESION);
