<?php

class RepositorioMesa {

    private static $INSERTAR_MESA = "INSERT INTO Mesa SET clave=:clave, mesa=:mesa, estado=:estado";
    private static $OBTENER_MESAS = "SELECT * FROM Mesa ORDER BY Mesa";
    private static $ELIMINAR_MESA_POR_CLAVE = "DELETE FROM Mesa WHERE clave=:clave";
    private static $ACTUALIZAR_MESA_POR_CLAVE = "UPDATE Mesa SET mesa=:mesa, estado=:estado WHERE clave=:clave";
    private static $OBTENER_MESA_POR_NOMBRE = "SELECT * FROM Mesa WHERE mesa=:mesa";
    private static $OBTENER_MESA_POR_CLAVE = "SELECT * FROM Mesa WHERE clave=:clave";

    public static function insertar_mesa($mesa_obj, $conexion) {

        $insertada = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($mesa_obj->getClave());
                $mesa = htmlspecialchars($mesa_obj->getMesa());
                $estado = htmlspecialchars($mesa_obj->getEstado());

                $sentencia = $conexion->prepare(self::$INSERTAR_MESA);
                $sentencia->bindParam(":clave", $clave, PDO::PARAM_STR);
                $sentencia->bindParam(":mesa", $mesa, PDO::PARAM_STR);
                $sentencia->bindParam(":estado", $estado, PDO::PARAM_STR);

                $insertada = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $insertada;
    }

    public static function obtener_mesas($conexion) {

        $cajas = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_MESAS);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $cajas[] = new Mesa($fila['clave'], $fila['mesa'], $fila['estado']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $cajas;
    }

    public static function eliminar_mesa_por_clave($clave, $conexion) {

        $eliminada = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$ELIMINAR_MESA_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $eliminada = $sentencia->execute();
            } catch (Exception $ex) {
                //echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $eliminada;
    }

    public static function actualizar_mesa_por_clave($mesa_obj, $conexion) {
        $actualizada = false;

        if (isset($conexion)) {
            try {
                $mesa = htmlspecialchars($mesa_obj->getMesa());
                $estado = htmlspecialchars($mesa_obj->getEstado());
                $clave = htmlspecialchars($mesa_obj->getClave());

                $sentencia = $conexion->prepare(self::$ACTUALIZAR_MESA_POR_CLAVE);
                $sentencia->bindParam(':mesa', $mesa, PDO::PARAM_STR);
                $sentencia->bindParam(':estado', $estado, PDO::PARAM_STR);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);

                $actualizada = $sentencia->execute();
            } catch (Exception $ex) {
                //echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $actualizada;
    }

    public static function existe_nombre_mesa($nombre, $conexion) {

        $mesa_existe = false;

        if (isset($conexion)) {
            try {

                $nombre = htmlspecialchars($nombre);
                $sentencia = $conexion->prepare(self::$OBTENER_MESA_POR_NOMBRE);
                $sentencia->bindParam(':mesa', $nombre, PDO::PARAM_STR);

                $sentencia->execute();

                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    $mesa_existe = true;
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $mesa_existe;
    }

    public static function existe_clave_mesa($clave, $conexion) {

        $clave_existe = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);
                $sentencia = $conexion->prepare(self::$OBTENER_MESA_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);

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

}
