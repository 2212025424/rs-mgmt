<?php

class RepositorioCajaApertura {

    private static $APERTURAR_CAJA = "INSERT INTO CajaApertura SET  clave=:clave,  cvl_caja=:cvl_caja,  cvl_cajero=:cvl_cajero,  montoApertura=:montoApertura,  estado=:estado";
    private static $OBTENER_CAJAS_POR_CRITERIO = "SELECT * FROM CajaApertura WHERE estado=:estado";
    private static $ACTUALIZAR_CAJA_ASIGANADA = "UPDATE CajaApertura SET cvl_cajero=:cvl_cajero,  montoApertura=:montoApertura,  estado=:estado WHERE clave=:clave AND cvl_cajero=:cvl_cajero";
    private static $ACTUALIZAR_ESTADO_CAJA_POR_CLAVE = "UPDATE CajaApertura SET estado=:estado WHERE clave=:clave";
    private static $OBTENER_CAJA_POR_CLAVE = "SELECT * FROM CajaApertura WHERE clave=:clave";

    public static function aperturar_caja($caja_obj, $conexion) {

        $insertado = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($caja_obj->getClave());
                $cvl_caja = htmlspecialchars($caja_obj->getCvl_caja());
                $cvl_cajero = htmlspecialchars($caja_obj->getCvl_cajero());
                $montoApertura = htmlspecialchars($caja_obj->getMontoApertura());
                $estado = htmlspecialchars($caja_obj->getEstado());

                $sentencia = $conexion->prepare(self::$APERTURAR_CAJA);
                $sentencia->bindParam(":clave", $clave, PDO::PARAM_STR);
                $sentencia->bindParam(":cvl_caja", $cvl_caja, PDO::PARAM_STR);
                $sentencia->bindParam(":cvl_cajero", $cvl_cajero, PDO::PARAM_STR);
                $sentencia->bindParam(":montoApertura", $montoApertura, PDO::PARAM_STR);
                $sentencia->bindParam(":estado", $estado, PDO::PARAM_STR);

                $insertado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $insertado;
    }

    public static function obtener_cajas_por_criterio($estado, $conexion) {

        $cajas = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_CAJAS_POR_CRITERIO);
                $sentencia->bindParam(':estado', $estado, PDO::PARAM_STR);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $cajas[] = new CajaApertura($fila['clave'], $fila['cvl_caja'], $fila['cvl_cajero'], $fila['montoApertura'], $fila['estado']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $cajas;
    }

    public static function actualizar_caja_por_clave($caja_obj, $conexion) {
        $actualizada = false;

        if (isset($conexion)) {
            try {
                $clave = htmlspecialchars($caja_obj->getClave());
                $cvl_caja = htmlspecialchars($caja_obj->getCvl_caja());
                $cvl_cajero = htmlspecialchars($caja_obj->getCvl_cajero());
                $montoApertura = htmlspecialchars($caja_obj->getMontoApertura());
                $estado = htmlspecialchars($caja_obj->getEstado());

                $sentencia = $conexion->prepare(self::$ACTUALIZAR_CAJA_ASIGANADA);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_caja', $cvl_caja, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_cajero', $cvl_cajero, PDO::PARAM_STR);
                $sentencia->bindParam(':montoApertura', $montoApertura, PDO::PARAM_STR);
                $sentencia->bindParam(':estado', $estado, PDO::PARAM_STR);

                $actualizada = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $actualizada;
    }

    public static function actualizar_estado_caja_por_clave($clave, $estado, $conexion) {
        $actualizada = false;

        if (isset($conexion)) {
            try {
                $clave = htmlspecialchars($clave);
                $estado = htmlspecialchars($estado);

                $sentencia = $conexion->prepare(self::$ACTUALIZAR_ESTADO_CAJA_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $sentencia->bindParam(':estado', $estado, PDO::PARAM_STR);

                $actualizada = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $actualizada;
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

}
