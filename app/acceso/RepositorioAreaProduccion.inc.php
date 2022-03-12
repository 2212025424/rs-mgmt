<?php

class RepositorioAreaProduccion {

    private static $OBTENER_AREAS = "SELECT * FROM AreaProduccion ORDER BY area";
    private static $OBTENER_AREA_POR_CLAVE = "SELECT * FROM AreaProduccion WHERE clave = :clave";

    public static function obtener_areas($conexion) {

        $areas = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_AREAS);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $areas[] = new AreaProduccion($fila['clave'], $fila['area']);
                    }
                }
            } catch (PDOException $ex) {
                "ERROR: " . $ex->getMessage();
            }
        }

        return $areas;
    }

    public static function obtener_area_por_clave($clave, $conexion) {

        $area = null;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_AREA_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $sentencia->execute();

                $resultado = $sentencia->fetch();

                if (!empty($resultado)) {
                    $area = new AreaProduccion($resultado['clave'], $resultado['area']);
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $area;
    }

    public static function existe_clave_area($clave, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_AREA_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $sentencia->execute();

                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    $existe = true;
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $existe;
    }

}
