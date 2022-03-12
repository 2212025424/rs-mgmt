<?php

class Escritor {
    
    public static function auto_select_options ($default, $opcion_actual) {
        
        if ($opcion_actual == $default) {
            return "selected";
        }else{
            return "";
        }
        
    }

    public static function determinar_estado_caja($estado) {

        $texto = "No Definido";

        switch ($estado) {
            case 0:
                $texto = "No Disponible";
                break;
            case 1:
                $texto = "Disponible";
                break;
            case 2:
                $texto = "Bloqueada";
                break;
        }

        return $texto;
    }

    public static function determinar_estado_usuario($estado) {

        $texto = "No Definido";

        switch ($estado) {
            case 0:
                $texto = "Sin acceso";
                break;
            case 1:
                $texto = "Con Acceso";
                break;
            case 2:
                $texto = "BloqueadO";
                break;
        }

        return $texto;
    }

    public static function estado_check($estado) {

        $echeck = "checked";

        if ($estado == 0) {
            $echeck = "";
        }

        return $echeck;
    }

    public static function pintar_no_hay_registros($descripcion) {
        ?>
        <div class="contenedor_img">
            <img src="<?php echo RUTA_IMG; ?>NoHayRegistros.png" class="contenedor_img__imagen_ch"/>
            <p><?php echo $descripcion; ?>.</p>
        </div>
        <?php
    }
    
    //Sin uso sin usp
    public static function pintar_sin_resultados($descripcion) {
        ?>
        <div class="contenedor_img">
            <img src="<?php echo RUTA_IMG; ?>NoCoincidencias.png" class="contenedor_img__imagen_ch"/>
            <p><?php echo $descripcion; ?>.</p>
        </div>
        <?php
    }

    public static function determinar_nota($nota) {

        if (empty($nota)) {
            $nota = " -- No se agregó un comentario --";
        }

        return $nota;
    }

}
