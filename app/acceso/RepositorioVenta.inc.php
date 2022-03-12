<?php

class RepositorioVenta {

    private static $INSERTAR_VENTA = "INSERT INTO Venta SET clave=:clave, cvl_caja=:cvl_caja, fecha=:fecha, hora=:hora, total=:total, estado=:estado";
    private static $OBTENER_VENTAS = "SELECT * FROM Venta";
    private static $OBTENER_VENTAS_POR_CRITERIO = "SELECT * FROM Venta WHERE estado = :criterio";
    private static $ELIMINAR_VENTA_POR_CLAVE = "DELETE FROM Venta WHERE clave=:clave";
    private static $OBTENER_VENTA_POR_CLAVE = "SELECT * FROM Mesa WHERE clave=:clave";

    public static function insertar_venta($venta_obj, $conexion) {

        $insertada = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($venta_obj->getClave());
                $cvl_caja = htmlspecialchars($venta_obj->getCvl_caja());
                $fecha = htmlspecialchars($venta_obj->getFecha());
                $hora = htmlspecialchars($venta_obj->getHora());
                $total = htmlspecialchars($venta_obj->getTotal());
                $estado = htmlspecialchars($venta_obj->getEstado());

                $sentencia = $conexion->prepare(self::$INSERTAR_VENTA);
                $sentencia->bindParam(":clave", $clave, PDO::PARAM_STR);
                $sentencia->bindParam(":cvl_caja", $cvl_caja, PDO::PARAM_STR);
                $sentencia->bindParam(":fecha", $fecha, PDO::PARAM_STR);
                $sentencia->bindParam(":hora", $hora, PDO::PARAM_STR);
                $sentencia->bindParam(":total", $total, PDO::PARAM_STR);
                $sentencia->bindParam(":estado", $estado, PDO::PARAM_STR);

                $insertada = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $insertada;
    }

    public static function obtener_ventas($conexion) {

        $ventas = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_VENTAS);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $ventas[] = new Venta($fila['clave'], $fila['cvl_caja'], $fila['fecha'], $fila['hora'], $fila['total'], $fila['estado']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $ventas;
    }

    public static function obtener_ventas_por_criterio($estado, $conexion) {

        $ventas = [];

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_VENTAS_POR_CRITERIO);
                $sentencia->bindParam(':criterio', $estado, PDO::PARAM_STR);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $ventas[] = new Venta($fila['clave'], $fila['cvl_caja'], $fila['fecha'], $fila['hora'], $fila['total'], $fila['estado']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $ventas;
    }

    public static function eliminar_venta_por_clave($clave, $conexion) {

        $eliminada = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$ELIMINAR_VENTA_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $eliminada = $sentencia->execute();
            } catch (Exception $ex) {
                //echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $eliminada;
    }

    public static function obtener_venta_por_clave($clave, $conexion) {

        $venta = null;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);
                $sentencia = $conexion->prepare(self::$OBTENER_VENTA_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);

                $sentencia->execute();

                $resultado = $sentencia->fetchAll();

                if (!empty($resultado)) {
                    $venta = new Venta($resultado['clave'], $resultado['cvl_caja'], $resultado['fecha'], $resultado['hora'], $resultado['total'], $resultado['estado']);
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $venta;
    }

}
