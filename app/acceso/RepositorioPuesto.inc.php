<?php

class RepositorioPuesto {

    private static $INSERTAR_PUESTO = "INSERT INTO Puesto SET clave=:clave, puesto=:puesto, nota=:nota";
    private static $OBTENER_PUESTOS = "SELECT * FROM Puesto WHERE clave <> 'DEFAULT' ORDER BY puesto";
    private static $ELIMINAR_TRABAJO_POR_CLAVE = "DELETE FROM Puesto WHERE clave=:clave";
    private static $ACTUALIZAR_TRABAJO_POR_CLAVE = "UPDATE Puesto SET puesto=:puesto, nota=:nota WHERE clave=:clave";
    private static $OBTENER_TRABAJO_POR_CLAVE = "SELECT * FROM Puesto WHERE clave=:clave";
    private static $OBTENER_TRABAJO_POR_NOMBRE = "SELECT * FROM Puesto WHERE puesto=:puesto";

    public static function insertar_puesto($puesto_obj, $conexion) {

        $insertado = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$INSERTAR_PUESTO);

                $clave = htmlspecialchars($puesto_obj->getClave());
                $puesto = htmlspecialchars($puesto_obj->getPuesto());
                $nota = htmlspecialchars($puesto_obj->getNota());

                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $sentencia->bindParam(':puesto', $puesto, PDO::PARAM_STR);
                $sentencia->bindParam(':nota', $nota, PDO::PARAM_STR);

                $insertado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $insertado;
    }

    public static function obtener_puestos($conexion) {

        $puestos = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_PUESTOS);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $puestos[] = new Puesto($fila['clave'], $fila['puesto'], $fila['nota']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $puestos;
    }

    public static function eliminar_puesto_por_clave($clave, $conexion) {

        $eliminado = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$ELIMINAR_TRABAJO_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $eliminado = $sentencia->execute();
            } catch (Exception $ex) {
                //echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $eliminado;
    }

    public static function actualizar_puesto_por_clave($puesto_obj, $conexion) {
        $actualizado = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($puesto_obj->getClave());
                $puesto = htmlspecialchars($puesto_obj->getPuesto());
                $nota = htmlspecialchars($puesto_obj->getNota());

                $sentencia = $conexion->prepare(self::$ACTUALIZAR_TRABAJO_POR_CLAVE);
                $sentencia->bindParam(':puesto', $puesto, PDO::PARAM_STR);
                $sentencia->bindParam(':nota', $nota, PDO::PARAM_STR);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);

                $actualizado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $actualizado;
    }

    public static function existe_clave_puesto($clave, $conexion) {

        $clave_existe = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_TRABAJO_POR_CLAVE);
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

    public static function existe_nombre_puesto($nombre, $conexion) {

        $clave_existe = false;

        if (isset($conexion)) {
            try {

                $nombre = htmlspecialchars($nombre);

                $sentencia = $conexion->prepare(self::$OBTENER_TRABAJO_POR_NOMBRE);
                $sentencia->bindParam(':puesto', $nombre, PDO::PARAM_STR);

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

    public static function obtener_puesto_por_clave($clave, $conexion) {
        $puesto = null;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_TRABAJO_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);

                $sentencia->execute();
                $resultado = $sentencia->fetch();

                if (!empty($resultado)) {
                    $puesto = new Puesto($resultado['clave'], $resultado['puesto'], $resultado['nota']);
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $puesto;
    }

}
