<?php

class RepositorioProducto {

    private static $INSERTAR_PRODUCTO = "INSERT INTO Producto SET  clave=:clave,  cvl_proveedor=:cvl_proveedor,  cvl_area=:cvl_area,  cvl_categoria=:cvl_categoria,  cvl_unidad=:cvl_unidad,  producto=:producto,  existencias=:existencias,  reOrden=:reOrden,  precio=:precio,  nota=:nota,  estado=:estado";
    private static $OBTENER_PRODUCTOS = "SELECT * FROM Producto ORDER BY producto";
    private static $ELIMINAR_PRODUCTO_POR_CLAVE = "DELETE FROM Producto WHERE clave=:clave";
    private static $ACTUALIZAR_PRODUCTO_POR_CLAVE = "UPDATE Producto SET cvl_proveedor=:cvl_proveedor,  cvl_area=:cvl_area,  cvl_categoria=:cvl_categoria,  cvl_unidad=:cvl_unidad,  producto=:producto,  existencias=:existencias,  reOrden=:reOrden,  precio=:precio,  nota=:nota,  estado=:estado WHERE clave=:clave";
    private static $OBTENER_PRODUCTO_POR_NOMBRE = "SELECT * FROM Producto WHERE producto=:producto";
    private static $OBTENER_PRODUCTO_POR_CLAVE = "SELECT * FROM Producto WHERE clave=:clave";
    private static $OBTENER_NOMBRE_PRODUCTO_EN_OTRO_REG = "SELECT * FROM Producto WHERE producto=:producto AND clave<>:clave";

    public static function insertar_producto($producto_obj, $conexion) {

        $insertada = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($producto_obj->getClave());
                $cvl_proveedor = htmlspecialchars($producto_obj->getCvl_proveedor());
                $cvl_area = htmlspecialchars($producto_obj->getCvl_area());
                $cvl_categoria = htmlspecialchars($producto_obj->getCvl_categoria());
                $cvl_unidad = htmlspecialchars($producto_obj->getCvl_unidad());
                $producto = htmlspecialchars($producto_obj->getProducto());
                $existencias = htmlspecialchars($producto_obj->getExistencias());
                $reOrden = htmlspecialchars($producto_obj->getReOrden());
                $precio = htmlspecialchars($producto_obj->getPrecio());
                $nota = htmlspecialchars($producto_obj->getNota());
                $estado = htmlspecialchars($producto_obj->getEstado());

                $sentencia = $conexion->prepare(self::$INSERTAR_PRODUCTO);
                $sentencia->bindParam(":clave", $clave, PDO::PARAM_STR);
                $sentencia->bindParam(":cvl_proveedor", $cvl_proveedor, PDO::PARAM_STR);
                $sentencia->bindParam(":cvl_area", $cvl_area, PDO::PARAM_STR);
                $sentencia->bindParam(":cvl_categoria", $cvl_categoria, PDO::PARAM_STR);
                $sentencia->bindParam(":cvl_unidad", $cvl_unidad, PDO::PARAM_STR);
                $sentencia->bindParam(":producto", $producto, PDO::PARAM_STR);
                $sentencia->bindParam(":existencias", $existencias, PDO::PARAM_STR);
                $sentencia->bindParam(":reOrden", $reOrden, PDO::PARAM_STR);
                $sentencia->bindParam(":precio", $precio, PDO::PARAM_STR);
                $sentencia->bindParam(":nota", $nota, PDO::PARAM_STR);
                $sentencia->bindParam(":estado", $estado, PDO::PARAM_STR);

                $insertada = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $insertada;
    }

    public static function obtener_productos($conexion) {

        $productos = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_PRODUCTOS);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $productos[] = new Producto($fila['clave'], $fila['cvl_proveedor'], $fila['cvl_area'], $fila['cvl_categoria'], $fila['cvl_unidad'], $fila['producto'], $fila['existencias'], $fila['reOrden'], $fila['precio'], $fila['nota'], $fila['estado']);
                    }
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
        return $productos;
    }

    public static function eliminar_producto_por_clave($clave, $conexion) {

        $eliminado = false;

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$ELIMINAR_PRODUCTO_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $eliminado = $sentencia->execute();
            } catch (Exception $ex) {
                //echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $eliminado;
    }

    public static function actualizar_producto_por_clave($producto_obj, $conexion) {
        $actualizada = false;

        if (isset($conexion)) {
            try {
                $clave = htmlspecialchars($producto_obj->getClave());
                $cvl_proveedor = htmlspecialchars($producto_obj->getCvl_proveedor());
                $cvl_area = htmlspecialchars($producto_obj->getCvl_area());
                $cvl_categoria = htmlspecialchars($producto_obj->getCvl_categoria());
                $cvl_unidad = htmlspecialchars($producto_obj->getCvl_unidad());
                $producto = htmlspecialchars($producto_obj->getProducto());
                $existencias = htmlspecialchars($producto_obj->getExistencias());
                $reOrden = htmlspecialchars($producto_obj->getReOrden());
                $precio = htmlspecialchars($producto_obj->getPrecio());
                $nota = htmlspecialchars($producto_obj->getNota());
                $estado = htmlspecialchars($producto_obj->getEstado());

                $sentencia = $conexion->prepare(self::$ACTUALIZAR_PRODUCTO_POR_CLAVE);
                $sentencia->bindParam(":clave", $clave, PDO::PARAM_STR);
                $sentencia->bindParam(":cvl_proveedor", $cvl_proveedor, PDO::PARAM_STR);
                $sentencia->bindParam(":cvl_area", $cvl_area, PDO::PARAM_STR);
                $sentencia->bindParam(":cvl_categoria", $cvl_categoria, PDO::PARAM_STR);
                $sentencia->bindParam(":cvl_unidad", $cvl_unidad, PDO::PARAM_STR);
                $sentencia->bindParam(":producto", $producto, PDO::PARAM_STR);
                $sentencia->bindParam(":existencias", $existencias, PDO::PARAM_STR);
                $sentencia->bindParam(":reOrden", $reOrden, PDO::PARAM_STR);
                $sentencia->bindParam(":precio", $precio, PDO::PARAM_STR);
                $sentencia->bindParam(":nota", $nota, PDO::PARAM_STR);
                $sentencia->bindParam(":estado", $estado, PDO::PARAM_STR);

                $actualizada = $sentencia->execute();
            } catch (Exception $ex) {
                echo "ERROR: algo ha salido mal.. " . $ex->getMessage();
            }
        }

        return $actualizada;
    }

    public static function obtener_producto_por_clave($clave, $conexion) {

        $producto = null;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);
                $sentencia = $conexion->prepare(self::$OBTENER_PRODUCTO_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);

                $sentencia->execute();
                $resultado = $sentencia->fetch();

                if (!empty($resultado)) {
                    $producto = new Producto($resultado['clave'], $resultado['cvl_proveedor'], $resultado['cvl_area'], $resultado['cvl_categoria'], $resultado['cvl_unidad'], $resultado['producto'], $resultado['existencias'], $resultado['reOrden'], $resultado['precio'], $resultado['nota'], $resultado['estado']);
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $producto;
    }

    public static function existe_clave_producto($clave, $conexion) {

        $clave_existe = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);
                $sentencia = $conexion->prepare(self::$OBTENER_PRODUCTO_POR_CLAVE);
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

    public static function existe_nombre_producto($nombre, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $nombre = htmlspecialchars($nombre);
                $sentencia = $conexion->prepare(self::$OBTENER_PRODUCTO_POR_NOMBRE);
                $sentencia->bindParam(':producto', $nombre, PDO::PARAM_STR);
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

    public static function existe_nombre_producto_en_otro_reg($clave, $nombre, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $nombre = htmlspecialchars($nombre);
                $clave = htmlspecialchars($clave);
                $sentencia = $conexion->prepare(self::$OBTENER_NOMBRE_PRODUCTO_EN_OTRO_REG);
                $sentencia->bindParam(':producto', $nombre, PDO::PARAM_STR);
                $sentencia->bindParam(':clave', $nombre, PDO::PARAM_STR);
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
