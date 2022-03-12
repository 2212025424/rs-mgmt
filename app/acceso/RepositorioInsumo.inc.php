<?php

class RepositorioInsumo {

    private static $INSERTAR_INSUMO = "INSERT INTO Insumo SET clave=:clave, cvl_proveedor=:cvl_proveedor, cvl_categoria=:cvl_categoria, cvl_unidad=:cvl_unidad, insumo=:insumo, existencias=:existencias, reOrden=:reOrden, nota=:nota";
    private static $OBTENER_INSUMOS = "SELECT * FROM Insumo ORDER BY insumo";
    private static $ELIMINAR_INSUMO_POR_CLAVE = "DELETE FROM Insumo WHERE clave=:clave";
    private static $ACTUALIZAR_INSUMO_POR_CLAVE = "UPDATE Insumo SET cvl_proveedor=:cvl_proveedor, cvl_categoria=:cvl_categoria, cvl_unidad=:cvl_unidad, insumo=:insumo, existencias=:existencias, reOrden=:reOrden, nota=:nota WHERE clave=:clave";
    private static $OBTENER_INSUMO_POR_CLAVE = "SELECT * FROM Insumo WHERE clave=:clave";
    private static $OBTENER_INSUMO_POR_INSUMO = "SELECT * FROM Insumo WHERE insumo=:insumo";
    private static $EXISTE_INSUMO_EN_OTRO_REG = "SELECT * FROM Insumo WHERE insumo=:insumo AND clave<>:clave";
    //Extrae todos los insumos que no han sido asignados a determinado producto como consumo implica tabla Insumo y ConsumoInsumo
    private static $OBTENER_INSUMOS_SIN_ASIGNA_A_CONSUMO_PRODUCTO = "SELECT clave, cvl_proveedor, cvl_categoria, cvl_unidad, insumo, existencias, reOrden, nota FROM Insumo LEFT JOIN (SELECT * FROM ConsumoInsumo WHERE cvl_producto = :cvl_producto) AS ConsumoInsumoResum ON clave = ConsumoInsumoResum.cvl_insumo WHERE cvl_insumo IS NULL";

    public static function insertar_insumo($insumo_obj, $conexion) {

        $insertado = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$INSERTAR_INSUMO);

                $clave = htmlspecialchars($insumo_obj->getClave());
                $cvl_proveedor = htmlspecialchars($insumo_obj->getCvl_proveedor());
                $cvl_categoria = htmlspecialchars($insumo_obj->getCvl_categoria());
                $cvl_unidad = htmlspecialchars($insumo_obj->getCvl_unidad());
                $insumo = htmlspecialchars($insumo_obj->getInsumo());
                $existencias = htmlspecialchars($insumo_obj->getExistencias());
                $reorden = htmlspecialchars($insumo_obj->getReorden());
                $nota = htmlspecialchars($insumo_obj->getNota());

                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_proveedor', $cvl_proveedor, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_categoria', $cvl_categoria, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_unidad', $cvl_unidad, PDO::PARAM_STR);
                $sentencia->bindParam(':insumo', $insumo, PDO::PARAM_STR);
                $sentencia->bindParam(':existencias', $existencias, PDO::PARAM_STR);
                $sentencia->bindParam(':reOrden', $reorden, PDO::PARAM_STR);
                $sentencia->bindParam(':nota', $nota, PDO::PARAM_STR);

                $insertado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $insertado;
    }

    public static function obtener_insumos($conexion) {

        $insumos = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_INSUMOS);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $insumos[] = new Insumo($fila['clave'], $fila['cvl_proveedor'], $fila['cvl_categoria'], $fila['cvl_unidad'], $fila['insumo'], $fila['existencias'], $fila['reOrden'], $fila['nota']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $insumos;
    }

    public static function eliminar_insumo_por_clave($clave, $conexion) {

        $eliminado = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$ELIMINAR_INSUMO_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $eliminado = $sentencia->execute();
            } catch (Exception $ex) {
                //echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $eliminado;
    }

    public static function actualizar_insumo_por_clave($insumo_obj, $conexion) {
        $actualizado = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$ACTUALIZAR_INSUMO_POR_CLAVE);

                $clave = htmlspecialchars($insumo_obj->getClave());
                $cvl_proveedor = htmlspecialchars($insumo_obj->getCvl_proveedor());
                $cvl_categoria = htmlspecialchars($insumo_obj->getCvl_categoria());
                $cvl_unidad = htmlspecialchars($insumo_obj->getCvl_unidad());
                $insumo = htmlspecialchars($insumo_obj->getInsumo());
                $existencias = htmlspecialchars($insumo_obj->getExistencias());
                $reorden = htmlspecialchars($insumo_obj->getReorden());
                $nota = htmlspecialchars($insumo_obj->getNota());

                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_proveedor', $cvl_proveedor, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_categoria', $cvl_categoria, PDO::PARAM_STR);
                $sentencia->bindParam(':cvl_unidad', $cvl_unidad, PDO::PARAM_STR);
                $sentencia->bindParam(':insumo', $insumo, PDO::PARAM_STR);
                $sentencia->bindParam(':existencias', $existencias, PDO::PARAM_STR);
                $sentencia->bindParam(':reOrden', $reorden, PDO::PARAM_STR);
                $sentencia->bindParam(':nota', $nota, PDO::PARAM_STR);

                $actualizado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $actualizado;
    }

    public static function existe_clave_insumo($clave, $conexion) {

        $clave_existe = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_INSUMO_POR_CLAVE);
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

    public static function existe_nombre_insumo($insumo, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $insumo = htmlspecialchars($insumo);

                $sentencia = $conexion->prepare(self::$OBTENER_INSUMO_POR_INSUMO);
                $sentencia->bindParam(':insumo', $insumo, PDO::PARAM_STR);

                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    $existe = true;
                }
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $existe;
    }

    public static function existe_insumo_en_otro_reg($clave, $insumo, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $insumo = htmlspecialchars($insumo);

                $sentencia = $conexion->prepare(self::$EXISTE_INSUMO_EN_OTRO_REG);
                $sentencia->bindParam(':insumo', $insumo, PDO::PARAM_STR);
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

    public static function obtener_insumo_por_clave($clave, $conexion) {
        $insumo = null;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_INSUMO_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);

                $sentencia->execute();
                $resultado = $sentencia->fetch();

                if (!empty($resultado)) {
                    $insumo = new Insumo($resultado['clave'], $resultado['cvl_proveedor'], $resultado['cvl_categoria'], $resultado['cvl_unidad'], $resultado['insumo'], $resultado['existencias'], $resultado['reOrden'], $resultado['nota']);
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $insumo;
    }

    //Extrae todos los insumos que no han sido asignados a determinado producto como consumo implica tabla Insumo y ConsumoInsumo
    public static function obtener_insumos_sin_asignar($cvl_producto, $conexion) {

        $insumos = [];

        if (isset($conexion)) {
            try {

                $cvl_producto = htmlspecialchars($cvl_producto);

                $sentencia = $conexion->prepare(self::$OBTENER_INSUMOS_SIN_ASIGNA_A_CONSUMO_PRODUCTO);
                $sentencia->bindParam(':cvl_producto', $cvl_producto, PDO::PARAM_STR);
                $sentencia->execute();

                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $insumos[] = new Insumo($fila['clave'], $fila['cvl_proveedor'], $fila['cvl_categoria'], $fila['cvl_unidad'], $fila['insumo'], $fila['existencias'], $fila['reOrden'], $fila['nota']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $insumos;
    }

}
