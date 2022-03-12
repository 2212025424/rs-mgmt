<?php
$titulo_documento = "Sistema RSMgmt || registro de productos || Productos del Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/transversal/Script.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Producto.inc.php';
include_once 'app/acceso/RepositorioProducto.inc.php';
include_once 'app/negocio/ValidadorProducto.inc.php';
include_once 'app/modelo/Proveedor.inc.php';
include_once 'app/acceso/RepositorioProveedor.inc.php';
include_once 'app/modelo/Categoria.inc.php';
include_once 'app/acceso/RepositorioCategoriaProducto.inc.php';
include_once 'app/modelo/Unidad.inc.php';
include_once 'app/acceso/RepositorioUnidad.inc.php';
include_once 'app/modelo/AreaProduccion.inc.php';
include_once 'app/acceso/RepositorioAreaProduccion.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

if (isset($_POST['REGISTRAR_PRO'])) {

    $estado = 0;
    if (isset($_POST['ESTADO_PRO'])) {
        $estado = 1;
    }

    Conexion::abrir_conexion();

    $validador = new ValidadorProducto('registrar', $_POST['PROVEEDOR_PRO'], $_POST['AREA_PRO'], $_POST['CATEGORIA_PRO'], $_POST['UNIDAD_PRO'], $_POST['NOMBRE_PRO'], $_POST['EXISTENCIAS_PRO'], $_POST['REORDEN_PRO'], $_POST['PRECIO_PRO'], $_POST['COMENTARIO_PRO'], Conexion::obtener_conexion());

    if ($validador->informacion_valida()) {


        $clave = Script::generar_clave(10);
        while (RepositorioProducto::existe_clave_producto($clave, Conexion::obtener_conexion())) {
            $clave = Script::generar_clave(10);
        }

        $new_producto = new Producto($clave, $validador->obtener_cvl_proveedor(), $validador->obtener_cvl_area(), $validador->obtener_cvl_categoria(), $validador->obtener_cvl_unidad(), $validador->obtener_producto(), $validador->obtener_existencias(), $validador->obtener_reOrden(), $validador->obtener_precio(), $validador->obtener_nota(), $estado);

        $insertado = RepositorioProducto::insertar_producto($new_producto, Conexion::obtener_conexion());

        if ($insertado) {

            $validador->limpiar_datos_validador();

            echo "<script> window.onload = function() {mostrarMensajeOperacionBoton('EXITO: Se ha insertado', 'alerta_exito', 'Agregar Insumos', 'btn_exito', '".RUTA_ASIGNAR_INSUMOS."?producto=".$new_producto->getClave()."');}; </script>";

        } else {
            echo "<script> window.onload = function() {mostrarMensajeOperacion('ERROR: Se ha producido un error', 'alerta_error');}; </script>";
        }
    }

    Conexion::cerrar_conexion();
}

include_once 'plantillas/html-apertura.php';
include_once 'plantillas/html-menu-superior.php';
include_once 'plantillas/html-menu-lateral.php';
?>

<div class="main_container">

    <!-- ENCABEZADO DEL DOCUMENTO EN LA VISTA -->
    <div class="descripcion_documento">Registro de producto</div>

    <div class="contenedor_contenido" id="#datos_iniales_producto">
        <div class="main_container__cuerpo">
            <div class="cont_main_form">

                <!-- Descriptcion de la seccion actual -->
                <div class="contenedor_encabezado_tabla">
                    <div>
                        <p>Datos iniciales del producto</p>
                    </div>
                    <div>
                        <a href="<?= RUTA_GESTOR_PRODUCTOS; ?>" class="btn btn_primary">Gestor De Productos</a>
                    </div>
                </div>                
                <hr class="separador">
                <div class="contenedor_mensaje_operacion" id="mensaje_opercion">
                    <!-- Se mostrará el mensaje de la operacion realizada -->
                </div>

                <?php
                Conexion::abrir_conexion();
                $proveedores = RepositorioProveedor::obtener_proveedores(Conexion::obtener_conexion());
                $categorias = RepositorioCategoriaProducto::obtener_categorias(Conexion::obtener_conexion());
                $uniades = RepositorioUnidad::obtener_unidades(Conexion::obtener_conexion());
                $areas_prod = RepositorioAreaProduccion::obtener_areas(Conexion::obtener_conexion());
                Conexion::cerrar_conexion();

                if (isset($_POST['REGISTRAR_PRO'])) {
                    include_once 'plantillas/form-producto-validado.php';
                } else {
                    include_once 'plantillas/form-producto-vacio.php';
                }
                ?>

            </div>
        </div>
    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';
?>
<script src="<?php echo RUTA_JS; ?>eventos/registrar-producto.js"></script>



