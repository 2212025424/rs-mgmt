<?php

class RepositorioCaja {

    private static $INSERTAR_CAJA = "INSERT INTO Caja SET clave=:clave, caja=:caja, estado=:estado";
    private static $OBTENER_CAJAS = "SELECT * FROM Caja ORDER BY caja";
    private static $ELIMINAR_CAJA_POR_CLAVE = "DELETE FROM Caja WHERE clave=:clave";
    private static $ACTUALIZAR_CAJA_POR_CLAVE = "UPDATE Caja SET caja=:caja, estado=:estado WHERE clave=:clave";
    private static $OBTENER_CAJA_POR_NOMBRE = "SELECT * FROM Caja WHERE caja=:caja";
    private static $OBTENER_CAJA_POR_CLAVE = "SELECT * FROM Caja WHERE clave=:clave";

    public static function insertar_caja($caja_obj, $conexion) {

        $insertado = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($caja_obj->getClave());
                $caja = htmlspecialchars($caja_obj->getCaja());
                $estado = htmlspecialchars($caja_obj->getEstado());

                $sentencia = $conexion->prepare(self::$INSERTAR_CAJA);
                $sentencia->bindParam(":clave", $clave, PDO::PARAM_STR);
                $sentencia->bindParam(":caja", $caja, PDO::PARAM_STR);
                $sentencia->bindParam(":estado", $estado, PDO::PARAM_STR);

                $insertado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $insertado;
    }

    public static function obtener_cajas($conexion) {

        $cajas = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_CAJAS);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $cajas[] = new Caja($fila['clave'], $fila['caja'], $fila['estado']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $cajas;
    }

    public static function eliminar_caja_por_clave($clave, $conexion) {

        $eliminada = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$ELIMINAR_CAJA_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $eliminada = $sentencia->execute();
            } catch (Exception $ex) {
                //echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $eliminada;
    }

    public static function actualizar_caja_por_clave($caja_obj, $conexion) {
        $actualizada = false;

        if (isset($conexion)) {
            try {
                $caja = htmlspecialchars($caja_obj->getCaja());
                $estado = htmlspecialchars($caja_obj->getEstado());
                $clave = htmlspecialchars($caja_obj->getClave());

                $sentencia = $conexion->prepare(self::$ACTUALIZAR_CAJA_POR_CLAVE);
                $sentencia->bindParam(':caja', $caja, PDO::PARAM_STR);
                $sentencia->bindParam(':estado', $estado, PDO::PARAM_STR);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);

                $actualizada = $sentencia->execute();

            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $actualizada;
    }

    public static function existe_nombre_caja($nombre, $conexion) {

        $caja_existe = false;

        if (isset($conexion)) {
            try {

                $nombre = htmlspecialchars($nombre);
                $sentencia = $conexion->prepare(self::$OBTENER_CAJA_POR_NOMBRE);
                $sentencia->bindParam(':caja', $nombre, PDO::PARAM_STR);

                $sentencia->execute();

                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    $caja_existe = true;
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $caja_existe;
    }

    public static function existe_clave_caja($clave, $conexion) {

        $clave_existe = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);
                $sentencia = $conexion->prepare(self::$OBTENER_CAJA_POR_CLAVE);
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

    /* Operaciones en más de una tabla [Empleado, Usuario] */
    
    public static function obtener_cajas_sin_apertura () {
        
    }
    
}
