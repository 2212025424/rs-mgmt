<?php

class RepositorioUsuario {

    private static $INSERTAR_USUARIO = "INSERT INTO Usuario SET cvl_empleado=:cvl_empleado, cvl_rol=:cvl_rol, contrasenia=md5(:contrasenia), estado=:estado";
    private static $OBTENER_USARIOS = "SELECT * FROM Usuario WHERE cvl_empleado <> 'USER-ADMIN' ORDER BY cvl_empleado";
    private static $ELIMINAR_USUARIO_POR_CLAVE = "DELETE FROM Usuario WHERE cvl_empleado=:cvl_empleado";
    private static $ACTUALIZAR_USUARIO_POR_CLAVE = "UPDATE Usuario SET cvl_rol=:cvl_rol, estado=:estado WHERE cvl_empleado=:cvl_empleado";
    private static $OBTENER_USUARIO_POR_CLAVE = "SELECT * FROM Usuario WHERE cvl_empleado=:cvl_empleado";

    public static function insertar_usuario($usuario_obj, $conexion) {

        $insertado = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$INSERTAR_USUARIO);

                $cvl_empleado = htmlspecialchars($usuario_obj->getClv_empleado());
                $cvl_rol = htmlspecialchars($usuario_obj->getClv_rol());
                $contrasenia = htmlspecialchars($usuario_obj->getContrasenia());
                $estado = htmlspecialchars($usuario_obj->getEstado());

                $sentencia->bindParam(':cvl_empleado', $cvl_empleado, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_rol', $cvl_rol, PDO::PARAM_STR);
                $sentencia->bindParam(':contrasenia', $contrasenia, PDO::PARAM_STR);
                $sentencia->bindParam(':estado', $estado, PDO::PARAM_STR);

                $insertado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $insertado;
    }

    public static function obtener_usuarios($conexion) {

        $empleados = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_USARIOS);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $empleados[] = new Usuario($fila['cvl_empleado'], $fila['cvl_rol'], $fila['contrasenia'], $fila['estado']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $empleados;
    }

    public static function eliminar_usuario_por_clave($clave, $conexion) {

        $eliminado = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$ELIMINAR_USUARIO_POR_CLAVE);
                $sentencia->bindParam(':cvl_empleado', $clave, PDO::PARAM_STR);
                $eliminado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $eliminado;
    }

    public static function actualizar_usuario_por_clave($usuario_obj, $conexion) {
        $actualizado = false;

        if (isset($conexion)) {
            try {

                $cvl_empleado = htmlspecialchars($usuario_obj->getClv_empleado());
                $cvl_rol = htmlspecialchars($usuario_obj->getClv_rol());
                $estado = htmlspecialchars($usuario_obj->getEstado());

                $sentencia = $conexion->prepare(self::$ACTUALIZAR_USUARIO_POR_CLAVE);

                $sentencia->bindParam(':cvl_rol', $cvl_rol, PDO::PARAM_STR);
                $sentencia->bindParam(':estado', $estado, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_empleado', $cvl_empleado, PDO::PARAM_STR);

                $actualizado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $actualizado;
    }

    public static function existe_clave_usuario($clave, $conexion) {

        $clave_existe = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_USUARIO_POR_CLAVE);
                $sentencia->bindParam(':cvl_empleado', $clave, PDO::PARAM_STR);

                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    $clave_existe = true;
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $clave_existe;
    }

    public static function obtener_usuario_por_clave($clave, $conexion) {
        $empleado = null;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_USUARIO_POR_CLAVE);
                $sentencia->bindParam(':cvl_empleado', $clave, PDO::PARAM_STR);

                $sentencia->execute();
                $resultado = $sentencia->fetch();

                if (!empty($resultado)) {
                    $empleado = new Usuario($resultado['cvl_empleado'], $resultado['cvl_rol'], $resultado['contrasenia'], $resultado['estado']);
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $empleado;
    }

    public static function obtener_usuarios_por_rol($cvl_rol, $conexion) {

        $usuarios = [];

        if (isset($conexion)) {
            try {

                $cvl_rol = htmlspecialchars($cvl_rol);

                $sentencia = $conexion->prepare(self::$OBTENER_USUARIOS_POR_ROL);
                $sentencia->bindParam(':cvl_rol', $cvl_rol, PDO::PARAM_STR);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $usuarios[] = new Usuario($fila['cvl_empleado'], $fila['cvl_rol'], $fila['contrasenia'], $fila['estado']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $usuarios;
    }

}
