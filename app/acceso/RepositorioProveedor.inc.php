<?php

class RepositorioProveedor {

    private static $INSERTAR_PROVEEDOR = "INSERT INTO Proveedor SET clave=:clave, razonsocial=:razonsocial, RFC=:RFC, telefono=:telefono, correo=:correo, nota=:nota";
    private static $OBTENER_PROVEEDORES = "SELECT * FROM Proveedor ORDER BY razonsocial";
    private static $ELIMINAR_PROVEEDOR_POR_CLAVE = "DELETE FROM Proveedor WHERE clave=:clave";
    private static $ACTUALIZAR_PROVEEDOR_POR_CLAVE = "UPDATE Proveedor SET razonsocial=:razonsocial, RFC=:RFC, telefono=:telefono, correo=:correo, nota=:nota WHERE clave=:clave";
    private static $OBTENER_PROVEEDOR_POR_CLAVE = "SELECT * FROM Proveedor WHERE clave=:clave";
    private static $OBTENER_PROVEEDOR_POR_RAZONSOCIAL = "SELECT * FROM Proveedor WHERE razonsocial=:razonsocial";
    private static $OBTENER_PROVEEDOR_POR_RFC = "SELECT * FROM Proveedor WHERE RFC=:RFC";
    private static $OBTENER_PROVEEDOR_POR_TELEFONO = "SELECT * FROM Proveedor WHERE telefono=:telefono";
    private static $OBTENER_PROVEEDOR_POR_CORREO = "SELECT * FROM Proveedor WHERE correo=:correo";
    private static $EXISTE_RAZONSOCIAL_EN_OTRO_REG = "SELECT * FROM Proveedor WHERE razonsocial=:razonsocial AND clave<>:clave";
    private static $EXISTE_RFC_EN_OTRO_RED = "SELECT * FROM Proveedor WHERE RFC=:RFC AND clave<>:clave";
    private static $EXISTE_TELEFONO_EN_OTRO_REG = "SELECT * FROM Proveedor WHERE telefono=:telefono AND clave<>:clave";
    private static $EXISTE_CORREO_EN_OTRO_REG = "SELECT * FROM Proveedor WHERE correo=:correo AND clave<>:clave";
    
    public static function insertar_proveedor($proveedor_obj, $conexion) {

        $insertado = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($proveedor_obj->getClave());
                $razonsocial = htmlspecialchars($proveedor_obj->getRazonsocial());
                $RFC = htmlspecialchars($proveedor_obj->getRFC());
                $telefono = htmlspecialchars($proveedor_obj->getTelefono());
                $correo = htmlspecialchars($proveedor_obj->getCorreo());
                $nota = htmlspecialchars($proveedor_obj->getNota());

                $sentencia = $conexion->prepare(self::$INSERTAR_PROVEEDOR);
                $sentencia->bindParam(":clave", $clave, PDO::PARAM_STR);
                $sentencia->bindParam(":razonsocial", $razonsocial, PDO::PARAM_STR);
                $sentencia->bindParam(":RFC", $RFC, PDO::PARAM_STR);
                $sentencia->bindParam(":telefono", $telefono, PDO::PARAM_STR);
                $sentencia->bindParam(":correo", $correo, PDO::PARAM_STR);
                $sentencia->bindParam(":nota", $nota, PDO::PARAM_STR);

                $insertado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $insertado;
    }

    public static function obtener_proveedores($conexion) {

        $proveedores = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_PROVEEDORES);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $proveedores[] = new Proveedor($fila['clave'], $fila['razonsocial'], $fila['RFC'], $fila['telefono'], $fila['correo'], $fila['nota']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $proveedores;
    }

    public static function eliminar_proveedor_por_clave($clave, $conexion) {

        $eliminada = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$ELIMINAR_PROVEEDOR_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $eliminada = $sentencia->execute();
            } catch (Exception $ex) {
                //echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $eliminada;
    }

    public static function actualizar_proveedor_por_clave($proveedor_obj, $conexion) {
        $actualizado = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($proveedor_obj->getClave());
                $razonsocial = htmlspecialchars($proveedor_obj->getRazonsocial());
                $RFC = htmlspecialchars($proveedor_obj->getRFC());
                $telefono = htmlspecialchars($proveedor_obj->getTelefono());
                $correo = htmlspecialchars($proveedor_obj->getCorreo());
                $nota = htmlspecialchars($proveedor_obj->getNota());

                $sentencia = $conexion->prepare(self::$ACTUALIZAR_PROVEEDOR_POR_CLAVE);
                $sentencia->bindParam(":clave", $clave, PDO::PARAM_STR);
                $sentencia->bindParam(":razonsocial", $razonsocial, PDO::PARAM_STR);
                $sentencia->bindParam(":RFC", $RFC, PDO::PARAM_STR);
                $sentencia->bindParam(":telefono", $telefono, PDO::PARAM_STR);
                $sentencia->bindParam(":correo", $correo, PDO::PARAM_STR);
                $sentencia->bindParam(":nota", $nota, PDO::PARAM_STR);

                $actualizado = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $actualizado;
    }

    public static function obtener_proveedor_por_clave($clave, $conexion) {

        $proveedor = null;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);
                $sentencia = $conexion->prepare(self::$OBTENER_PROVEEDOR_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);

                $sentencia->execute();
                $resultado = $sentencia->fetch();

                if (!empty($resultado)) {
                    $proveedor = new Proveedor($resultado['clave'], $resultado['razonsocial'], $resultado['RFC'], $resultado['telefono'], $resultado['correo'], $resultado['nota']);
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $proveedor;
    }

    public static function existe_clave_proveedor($clave, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);
                $sentencia = $conexion->prepare(self::$OBTENER_PROVEEDOR_POR_CLAVE);
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

    public static function existe_rasonsocial_proveedor($razonsocial, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $razonsocial = htmlspecialchars($razonsocial);
                $sentencia = $conexion->prepare(self::$OBTENER_PROVEEDOR_POR_RAZONSOCIAL);
                $sentencia->bindParam(':razonsocial', $razonsocial, PDO::PARAM_STR);

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

    public static function existe_rfc_proveedor($RFC, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $RFC = htmlspecialchars($RFC);
                $sentencia = $conexion->prepare(self::$OBTENER_PROVEEDOR_POR_RFC);
                $sentencia->bindParam(':RFC', $RFC, PDO::PARAM_STR);

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

    public static function existe_telefono_proveedor($telefono, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $telefono = htmlspecialchars($telefono);
                $sentencia = $conexion->prepare(self::$OBTENER_PROVEEDOR_POR_TELEFONO);
                $sentencia->bindParam(':telefono', $telefono, PDO::PARAM_STR);

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

    public static function existe_correo_proveedor($correo, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $correo = htmlspecialchars($correo);
                $sentencia = $conexion->prepare(self::$OBTENER_PROVEEDOR_POR_CORREO);
                $sentencia->bindParam(':correo', $correo, PDO::PARAM_STR);

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

    public static function existe_razonsocial_proveedor_en_otro_reg($clave, $razonsocial, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $razonsocial = htmlspecialchars($razonsocial);
                $sentencia = $conexion->prepare(self::$EXISTE_RAZONSOCIAL_EN_OTRO_REG);
                $sentencia->bindParam(':razonsocial', $razonsocial, PDO::PARAM_STR);
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

    public static function existe_rfc_proveedor_en_otro_reg($clave, $RFC, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $RFC = htmlspecialchars($RFC);
                $sentencia = $conexion->prepare(self::$EXISTE_RFC_EN_OTRO_RED);
                $sentencia->bindParam(':RFC', $RFC, PDO::PARAM_STR);
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

    public static function existe_telefono_proveedor_en_otro_reg($clave, $telefono, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $telefono = htmlspecialchars($telefono);
                $sentencia = $conexion->prepare(self::$EXISTE_TELEFONO_EN_OTRO_REG);
                $sentencia->bindParam(':telefono', $telefono, PDO::PARAM_STR);
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

    public static function existe_correo_proveedor_en_otro_reg($clave, $correo, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $correo = htmlspecialchars($correo);
                $sentencia = $conexion->prepare(self::$EXISTE_CORREO_EN_OTRO_REG);
                $sentencia->bindParam(':correo', $correo, PDO::PARAM_STR);
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
