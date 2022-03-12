<?php

class ControlSesion {
    
    public static function iniciar_sesion($clave_usuario, $nombre_usuario, $clave_rol) {
        if (session_id() == '') {
            session_start();
        }
        $_SESSION['CLAVE_USUARIO'] = $clave_usuario;
        $_SESSION['NOMBRE_USUARIO'] = $nombre_usuario;
        $_SESSION['CLAVE_ROL'] = $clave_rol;
    }

    public static function cerrar_sesion() {
        if (session_id() == '') {
            session_start();
        }
        if (isset($_SESSION['CLAVE_USUARIO'])) {
            unset($_SESSION['CLAVE_USUARIO']);
        }
        if (isset($_SESSION['NOMBRE_USUARIO'])) {
            unset($_SESSION['NOMBRE_USUARIO']);
        }
        if (isset($_SESSION['CLAVE_ROL'])) {
            unset($_SESSION['CLAVE_ROL']);
        }
        session_destroy();
    }

    public static function sesion_iniciada_administrador() {
        if (session_id() == '') {
            session_start();
        }
        if (isset($_SESSION['CLAVE_USUARIO']) && isset($_SESSION['NOMBRE_USUARIO']) && isset($_SESSION['CLAVE_ROL']) && strcmp($_SESSION['CLAVE_ROL'], 'J2hBnK2js4') == 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function sesion_iniciada_cajero() {
        if (session_id() == '') {
            session_start();
        }
        if (isset($_SESSION['CLAVE_USUARIO']) && isset($_SESSION['NOMBRE_USUARIO']) && isset($_SESSION['CLAVE_ROL']) && strcmp($_SESSION['CLAVE_ROL'], '6EgYd2tR4W') == 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function sesion_iniciada_mesero() {
        if (session_id() == '') {
            session_start();
        }
        if (isset($_SESSION['CLAVE_USUARIO']) && isset($_SESSION['NOMBRE_USUARIO']) && isset($_SESSION['CLAVE_ROL']) && strcmp($_SESSION['CLAVE_ROL'], 'FSe7Hsg5K2') == 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function sesion_iniciada() {
        if (session_id() == '') {
            session_start();
        }
        if (isset($_SESSION['CLAVE_USUARIO']) && isset($_SESSION['NOMBRE_USUARIO']) && isset($_SESSION['CLAVE_ROL'])) {
            return true;
        } else {
            return false;
        }
    }

}
