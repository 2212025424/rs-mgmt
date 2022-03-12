<?php

class RepositorioRol {

    private static $OBTENER_ROLES = "SELECT * FROM Rol WHERE rol <> 'ADMINISTRADOR' ORDER BY Rol";
    private static $OBTENER_ROL_POR_CLAVE = "SELECT * FROM Rol WHERE clave = :clave";

    public static function obtener_roles($conexion) {

        $roles = [];

        if (isset($conexion)) {
            try {

                $sentencia = $conexion->prepare(self::$OBTENER_ROLES);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        $roles[] = new Rol($fila['clave'], $fila['rol']);
                    }
                }

            } catch (PDOException $ex) {
                "ERROR: " . $ex->getMessage();
            }
        }

        return $roles;
    }

    public static function obtener_rol_por_clave($clave, $conexion) {

        $rol = null;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_ROL_POR_CLAVE);
                $sentencia->bindParam(':clave', $clave, PDO::PARAM_STR);
                $sentencia->execute();

                $resultado = $sentencia->fetch();

                if (!empty($resultado)) {
                    $rol = new Rol($resultado['clave'], $resultado['rol']);
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }

        return $rol;
    }

    public static function existe_clave_rol($clave, $conexion) {

        $existe = false;

        if (isset($conexion)) {
            try {

                $clave = htmlspecialchars($clave);

                $sentencia = $conexion->prepare(self::$OBTENER_ROL_POR_CLAVE);
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
