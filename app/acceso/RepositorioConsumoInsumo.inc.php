<?php

class RepositorioConsumoInsumo {

    private static $INSERTAR_CONSUMO = "INSERT INTO ConsumoInsumo SET cvl_producto=:cvl_producto, cvl_insumo=:cvl_insumo, numproductos=:numproductos, cantidadMin=:cantidadMin, cantidadMax=:cantidadMax";
    private static $OBTENER_CONSUMOS_PRODUCTO = "SELECT * FROM ConsumoInsumo WHERE cvl_producto=:cvl_producto";
    private static $ELIMINAR_CONSUMOS_PRODUCTO = "DELETE FROM ConsumoInsumo WHERE cvl_producto=:cvl_producto";
    private static $ELIMINAR_CONSUMO_PRODUCTO = "DELETE FROM ConsumoInsumo WHERE cvl_producto=:cvl_producto AND cvl_insumo=:cvl_insumo";
    private static $ACTUALIZAR_CONSUMO_PRODUCTO = "UPDATE ConsumoInsumo SET numproductos=:numproductos, cantidadMin=:cantidadMin, cantidadMax=:cantidadMax WHERE cvl_producto=:cvl_producto AND cvl_insumo=:cvl_insumo";
    private static $OBTENER_INSUMO_DE_CONSUMO_PRODUCTO = "SELECT * FROM ConsumoInsumo WHERE cvl_producto=:cvl_producto AND cvl_insumo=:cvl_insumo";
    private static $ELIMINAR_INSUMO_DE_CONSUMO_PRODUCTO = "DELETE FROM ConsumoInsumo WHERE cvl_producto=:cvl_producto AND cvl_insumo=:cvl_insumo";

    public static function insertar_consumo($consumo_obj, $conexion) {

        $insertado = false;

        if (isset($conexion)) {
            try {

                $cvl_producto = htmlspecialchars($consumo_obj->getCvl_producto());
                $cvl_insumo = htmlspecialchars($consumo_obj->getCvl_insumo());
                $numproductos = htmlspecialchars($consumo_obj->getNumproductos());
                $cantidadMin = htmlspecialchars($consumo_obj->getCantidadMin());
                $cantidadMax = htmlspecialchars($consumo_obj->getCantidadMax());

                $sentencia = $conexion->prepare(self::$INSERTAR_CONSUMO);
                $sentencia->bindParam(":cvl_producto", $cvl_producto, PDO::PARAM_STR);
                $sentencia->bindParam(":cvl_insumo", $cvl_insumo, PDO::PARAM_STR);
                $sentencia->bindParam(":numproductos", $numproductos, PDO::PARAM_STR);
                $sentencia->bindParam(":cantidadMin", $cantidadMin, PDO::PARAM_STR);
                $sentencia->bindParam(":cantidadMax", $cantidadMax, PDO::PARAM_STR);

                $insertado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $insertado;
    }

    public static function obtener_consumos_producto($cvl_producto, $conexion) {

        $consumos = [];

        if (isset($conexion)) {
            try {

                $cvl_producto = htmlspecialchars($cvl_producto);

                $sentencia = $conexion->prepare(self::$OBTENER_CONSUMOS_PRODUCTO);
                $sentencia->bindParam(':cvl_producto', $cvl_producto, PDO::PARAM_STR);
                $sentencia->execute();

                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $consumos[] = new ConsumoInsumo($fila['cvl_producto'], $fila['cvl_insumo'], $fila['numproductos'], $fila['cantidadMin'], $fila['cantidadMax']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $consumos;
    }

    public static function eliminar_consumos_producto($cvl_producto, $conexion) {

        $eliminada = false;

        if (isset($conexion)) {
            try {

                $cvl_producto = htmlspecialchars($cvl_producto);

                $sentencia = $conexion->prepare(self::$ELIMINAR_CONSUMOS_PRODUCTO);
                $sentencia->bindParam(':cvl_producto', $cvl_producto, PDO::PARAM_STR);

                $eliminada = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $eliminada;
    }

    public static function eliminar_consumo_producto($cvl_producto, $cvl_insumo, $conexion) {

        $eliminada = false;

        if (isset($conexion)) {
            try {

                $cvl_producto = htmlspecialchars($cvl_producto);
                $cvl_insumo = htmlspecialchars($cvl_insumo);

                $sentencia = $conexion->prepare(self::$ELIMINAR_CONSUMO_PRODUCTO);
                $sentencia->bindParam(':cvl_producto', $cvl_producto, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_insumo', $cvl_insumo, PDO::PARAM_STR);

                $eliminada = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $eliminada;
    }

    public static function actualizar_consumo_producto($consumo_obj, $conexion) {
        $actualizada = false;

        if (isset($conexion)) {
            try {
                $cvl_producto = htmlspecialchars($consumo_obj->getCvl_producto());
                $cvl_insumo = htmlspecialchars($consumo_obj->getCvl_insumo());
                $numproductos = htmlspecialchars($consumo_obj->getNumproductos());
                $cantidadMin = htmlspecialchars($consumo_obj->getCantidadMin());
                $cantidadMax = htmlspecialchars($consumo_obj->getCantidadMax());

                $sentencia = $conexion->prepare(self::$ACTUALIZAR_CONSUMO_PRODUCTO);
                $sentencia->bindParam(":cvl_producto", $cvl_producto, PDO::PARAM_STR);
                $sentencia->bindParam(":cvl_insumo", $cvl_insumo, PDO::PARAM_STR);
                $sentencia->bindParam(":numproductos", $numproductos, PDO::PARAM_STR);
                $sentencia->bindParam(":cantidadMin", $cantidadMin, PDO::PARAM_STR);
                $sentencia->bindParam(":cantidadMax", $cantidadMax, PDO::PARAM_STR);

                $actualizada = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $actualizada;
    }

    //Con la finalidad de validar si un insumo ya ha sido asignado a un producto
    public static function existe_insumo_en_producto($cvl_producto, $cvl_insumo, $conexion) {

        $consumo_existe = false;

        if (isset($conexion)) {
            try {

                $cvl_producto = htmlspecialchars($cvl_producto);
                $cvl_insumo = htmlspecialchars($cvl_insumo);

                $sentencia = $conexion->prepare(self::$OBTENER_INSUMO_DE_CONSUMO_PRODUCTO);
                $sentencia->bindParam(':cvl_producto', $cvl_producto, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_insumo', $cvl_insumo, PDO::PARAM_STR);

                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    $consumo_existe = true;
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $consumo_existe;
    }

    //Con la finalidad de validar si un insumo ya ha sido asignado a un producto
    public static function eliminar_consumo_de_producto($cvl_producto, $cvl_insumo, $conexion) {

        $eliminado = false;

        if (isset($conexion)) {
            try {

                $cvl_producto = htmlspecialchars($cvl_producto);
                $cvl_insumo = htmlspecialchars($cvl_insumo);

                $sentencia = $conexion->prepare(self::$ELIMINAR_INSUMO_DE_CONSUMO_PRODUCTO);
                $sentencia->bindParam(':cvl_producto', $cvl_producto, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_insumo', $cvl_insumo, PDO::PARAM_STR);

                $eliminado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $eliminado;
    }

    //Con la finalidad de validar si un insumo ya ha sido asignado a un producto
    public static function obtener_insumo_en_producto($cvl_producto, $cvl_insumo, $conexion) {

        $consumos = null;

        if (isset($conexion)) {
            try {

                $cvl_producto = htmlspecialchars($cvl_producto);
                $cvl_insumo = htmlspecialchars($cvl_insumo);

                $sentencia = $conexion->prepare(self::$OBTENER_INSUMO_DE_CONSUMO_PRODUCTO);
                $sentencia->bindParam(':cvl_producto', $cvl_producto, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_insumo', $cvl_insumo, PDO::PARAM_STR);

                $sentencia->execute();
                $resultado = $sentencia->fetch();

                if (!empty($resultado) > 0) {
                    $consumos = new ConsumoInsumo($resultado['cvl_producto'], $resultado['cvl_insumo'], $resultado['numproductos'], $resultado['cantidadMin'], $resultado['cantidadMax']);
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $consumos;
    }

}
