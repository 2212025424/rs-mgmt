<?php

class RepositorioCategoriaProducto {

    private static $INSERTAR_CATEGORIA = "INSERT INTO CategoriaProducto SET clave=:clave, categoria=:categoria";
    private static $OBTENER_CATEGORIAS = "SELECT * FROM CategoriaProducto ORDER BY categoria";
    private static $ELIMINAR_CATEGORIA_POR_CLAVE = "DELETE FROM CategoriaProducto WHERE clave=:clave";
    private static $ACTUALIZAR_CATEGORIA_POR_CLAVE = "UPDATE CategoriaProducto SET categoria=:categoria WHERE clave=:clave";
    private static $OBTENER_CATEGORIA_POR_CLAVE = "SELECT * FROM CategoriaProducto WHERE clave=:clave";
    private static $OBTENER_CATEGORIA_POR_CATEGORIA = "SELECT * FROM CategoriaProducto WHERE categoria=:categoria";

    public static function insertar_categoria($categoria_obj, $conexion) {

        $insertada = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($categoria_obj->getClave());
                $cate = htmlspecialchars($categoria_obj->getCategoria());

                $sentencia = $conexion->prepare(self::$INSERTAR_CATEGORIA);
                $sentencia->bindParam(":clave", $clave, PDO::PARAM_STR);
                $sentencia->bindParam(":categoria", $cate, PDO::PARAM_STR);

                $insertada = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $insertada;
    }

    public static function obtener_categorias($conexion) {

        $categorias = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_CATEGORIAS);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $categorias[] = new Categoria($fila['clave'], $fila['categoria']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $categorias;
    }

    public static function eliminar_categoria_por_clave($clave, $conexion) {

        $eliminada = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$ELIMINAR_CATEGORIA_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $eliminada = $sentencia->execute();
            } catch (Exception $ex) {
                //echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $eliminada;
    }

    public static function actualizar_categoria_por_clave($categoria_obj, $conexion) {
        $actualizada = false;

        if (isset($conexion)) {
            try {
                $categoria = htmlspecialchars($categoria_obj->getCategoria());
                $clave = htmlspecialchars($categoria_obj->getClave());

                $sentencia = $conexion->prepare(self::$ACTUALIZAR_CATEGORIA_POR_CLAVE);
                $sentencia->bindParam(':categoria', $categoria, PDO::PARAM_STR);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);

                $actualizada = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $actualizada;
    }

    public static function obtener_categoria_por_clave($clave, $conexion) {

        $categoria = null;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);
                $sentencia = $conexion->prepare(self::$OBTENER_CATEGORIA_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $sentencia->execute();

                $resultado = $sentencia->fetch();

                if (!empty($resultado)) {
                    $categoria = new Categoria($resultado['clave'], $resultado['categoria']);
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $categoria;
    }

    public static function existe_clave_categoria($clave, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $nombre = htmlspecialchars($nombre);
                $sentencia = $conexion->prepare(self::$OBTENER_CATEGORIA_POR_CLAVE);
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

    public static function existe_categoria($categoria, $conexion) {

        $clave_existe = false;

        if (isset($conexion)) {
            try {

                $categoria = htmlspecialchars($categoria);
                $sentencia = $conexion->prepare(self::$OBTENER_CATEGORIA_POR_CATEGORIA);
                $sentencia->bindParam(':categoria', $categoria, PDO::PARAM_STR);

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

