<?php

class RepositorioUnidad {

    private static $OBTENER_UNIDADES = "SELECT * FROM Unidad";
    private static $OBTENER_UNIDAD_POR_CLAVE = "SELECT * FROM Unidad WHERE clave = :clave";

    public static function obtener_unidades($conexion) {

        $unidades = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_UNIDADES);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $unidades[] = new Unidad($fila['clave'], $fila['unidad']);
                    }
                }
            } catch (PDOException $ex) {
                "ERROR: " . $ex->getMessage();
            }
        }

        return $unidades;
    }

    public static function obtener_unidad_por_clave($clave, $conexion) {

        $unidad = null;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_UNIDAD_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $sentencia->execute();

                $resultado = $sentencia->fetch();

                if (!empty($resultado)) {
                    $unidad = new Unidad($resultado['clave'], $resultado['unidad']);
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $unidad;
    }

    public static function existe_clave_unidad($clave, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_UNIDAD_POR_CLAVE);
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
