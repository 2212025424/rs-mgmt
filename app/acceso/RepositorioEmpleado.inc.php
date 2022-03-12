<?php

class RepositorioEmpleado {

    private static $INSERTAR_EMPLEADO = "INSERT INTO Empleado SET  clave =:clave, cvl_puesto =:cvl_puesto, nombre =:nombre, apaterno =:aPaterno, amaterno =:aMaterno, fechaNac =:fechaNac, fechaReg = CURDATE()";
    private static $OBTENER_EMPLEADOS = "SELECT * FROM Empleado WHERE clave <> 'USER-ADMIN' ORDER BY nombre";
    private static $ELIMINAR_EMPLEADO_POR_CLAVE = "DELETE FROM Empleado WHERE clave=:clave";
    private static $ACTUALIZAR_EMPLEADO_POR_CLAVE = "UPDATE Empleado SET cvl_puesto =:cvl_puesto, nombre =:nombre, aPaterno =:aPaterno, aMaterno =:aMaterno, fechaNac =:fechaNac WHERE clave=:clave";
    private static $OBTENER_EMPLEADO_POR_CLAVE = "SELECT * FROM Empleado WHERE clave=:clave";
    private static $OBTENER_EMPLEADOS_SIN_CUENTA = "SELECT clave,  cvl_puesto,  nombre,   aPaterno,   aMaterno,   fechaNac,  fechaReg FROM Empleado LEFT JOIN Usuario ON clave = cvl_empleado WHERE cvl_empleado IS NULL";
    private static $EMPLEADO_POSEE_CUENTA = "SELECT clave,  cvl_puesto,  nombre,   aPaterno,   aMaterno,   fechaNac,  fechaReg FROM Empleado JOIN Usuario ON clave = cvl_empleado WHERE clave = :clave;";
    
    public static function insertar_empleado($empleado_obj, $conexion) {

        $insertado = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$INSERTAR_EMPLEADO);

                $clave = htmlspecialchars($empleado_obj->getClave());
                $cvl_puesto = htmlspecialchars($empleado_obj->getCvl_puesto());
                $nombre = htmlspecialchars($empleado_obj->getNombre());
                $aPaterno = htmlspecialchars($empleado_obj->getApaterno());
                $aMaterno = htmlspecialchars($empleado_obj->getAmaterno());
                $fechaNac = htmlspecialchars($empleado_obj->getFechaNac());

                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_puesto', $cvl_puesto, PDO::PARAM_STR);
                $sentencia->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $sentencia->bindParam(':aPaterno', $aPaterno, PDO::PARAM_STR);
                $sentencia->bindParam(':aMaterno', $aMaterno, PDO::PARAM_STR);
                $sentencia->bindParam(':fechaNac', $fechaNac, PDO::PARAM_STR);

                $insertado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $insertado;
    }

    public static function obtener_empleados($conexion) {

        $empleados = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_EMPLEADOS);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $empleados[] = new Empleado($fila['clave'], $fila['cvl_puesto'], $fila['nombre'], $fila['aPaterno'], $fila['aMaterno'], $fila['fechaNac'], $fila['fechaReg']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $empleados;
    }

    public static function eliminar_empleado_por_clave($clave, $conexion) {

        $eliminado = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$ELIMINAR_EMPLEADO_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $eliminado = $sentencia->execute();
            } catch (Exception $ex) {
                //echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $eliminado;
    }

    public static function actualizar_empleado_por_clave($empleado_obj, $conexion) {
        $actualizado = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($empleado_obj->getClave());
                $cvl_puesto = htmlspecialchars($empleado_obj->getCvl_puesto());
                $nombre = htmlspecialchars($empleado_obj->getNombre());
                $aPaterno = htmlspecialchars($empleado_obj->getApaterno());
                $aMaterno = htmlspecialchars($empleado_obj->getAmaterno());
                $fechaNac = htmlspecialchars($empleado_obj->getFechaNac());

                $sentencia = $conexion->prepare(self::$ACTUALIZAR_EMPLEADO_POR_CLAVE);
                $sentencia->bindParam(':cvl_puesto', $cvl_puesto, PDO::PARAM_STR);
                $sentencia->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $sentencia->bindParam(':aPaterno', $aPaterno, PDO::PARAM_STR);
                $sentencia->bindParam(':aMaterno', $aMaterno, PDO::PARAM_STR);
                $sentencia->bindParam(':fechaNac', $fechaNac, PDO::PARAM_STR);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);

                $actualizado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $actualizado;
    }

    public static function existe_clave_empleado($clave, $conexion) {

        $clave_existe = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_EMPLEADO_POR_CLAVE);
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

    public static function obtener_empleado_por_clave($clave, $conexion) {
        $empleado = null;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_EMPLEADO_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);

                $sentencia->execute();
                $resultado = $sentencia->fetch();

                if (!empty($resultado)) {
                    $empleado = new Empleado($resultado['clave'], $resultado['cvl_puesto'], $resultado['nombre'], $resultado['aPaterno'], $resultado['aMaterno'], $resultado['fechaNac'], $resultado['fechaReg']);
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $empleado;
    }

    /* Operaciones en más de una tabla [Empleado, Usuario] */

    public static function obtener_empleados_sin_cuenta($conexion) {

        $empleados = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_EMPLEADOS_SIN_CUENTA);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $empleados[] = new Empleado($fila['clave'], $fila['cvl_puesto'], $fila['nombre'], $fila['aPaterno'], $fila['aMaterno'], $fila['fechaNac'], $fila['fechaReg']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $empleados;
    }

    public static function empleado_posse_cuenta($clave, $conexion) {

        $posee = false;


        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$EMPLEADO_POSEE_CUENTA);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $sentencia->execute();

                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    $posee = true;
                }
            } catch (Exception $ex) {
                echo "EEROR: " . $ex->getMessage();
            }
        }

        return $posee;
    }

}
