<?php
$titulo_documento = "Sistema RSMgmt || Asignar insumos a producto || Productos del Cangrejo Dorado";

include_once 'app/transversal/config.inc.php';
include_once 'app/transversal/Escritor.inc.php';
include_once 'app/transversal/ControlSesion.inc.php';
include_once 'app/transversal/Redireccion.inc.php';
include_once 'app/transversal/Script.inc.php';
include_once 'app/acceso/Conexion.inc.php';
include_once 'app/modelo/Producto.inc.php';
include_once 'app/acceso/RepositorioProducto.inc.php';

if (!ControlSesion::sesion_iniciada_administrador()) {
    Redireccion::redirigir(RUTA_INICIAR_SESION);
}

Conexion::abrir_conexion();
if (!isset($_GET['producto']) || !RepositorioProducto::existe_clave_producto($_GET['producto'], Conexion::obtener_conexion())) {
    Redireccion::redirigir(RUTA_GESTOR_PRODUCTOS);
} else {
    $producto = RepositorioProducto::obtener_producto_por_clave($_GET['producto'], Conexion::obtener_conexion());
}
Conexion::cerrar_conexion();


include_once 'plantillas/html-apertura.php';
include_once 'plantillas/html-menu-superior.php';
include_once 'plantillas/html-menu-lateral.php';
?>

<div class="main_container">

    <!-- ENCABEZADO DEL DOCUMENTO EN LA VISTA -->
    <div class="descripcion_documento"><?=$producto->getProducto(); ?> - LISTA DE INSUMOS</div>

    <div class="contenedor_contenido">



        <!-- Descriptcion de la seccion actual -->
        <div class="contenedor_encabezado_tabla">
            <div class="contenedor_mensaje_operacion" id="mensaje_opercion">

            </div>
            <div>
                <a href="<?= RUTA_GESTOR_PRODUCTOS; ?>" class="btn btn_primary">Gestor De Productos</a>
            </div>
        </div>



        <!-- Ventala modal, muestra la lista de insumos -->
        <div class="ventana_modal" id="modal_lista_de_insumos">
            <div class="ventana_modal__content">
                <div class="ventana_modal__titulo">
                    Lista de insumos
                </div>
                <div class="ventana_modal_cuerpo">
                    <center>Lista de insumo, selecciona un insumo de la lista para agregarlo al producto.</center>
                    <div class="table_responsive">
                        <table class="sub_tabla_contenido">
                            <thead>
                                <tr>
                                    <th>Insumo</th>
                                    <th>unidad</th>
                                    <th>Categoria</th>
                                    <th>Opcion</th>
                                </tr>
                            </thead>
                            <tbody id="lista_insumos">
                                <!-- ====================================================
                                ====== Mostrar los insumos sin asignar al producto ======
                                ======================================================-->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="ventana_modal__pie">
                    <a class="btn btn_exito js_close_modal" modal="modal_lista_de_insumos">Cerrar Ventana</a>
                </div>
            </div>
        </div>

        

        <!-- Formulario para agregar un nuevo insumo -->
        <form autocomplete="off" id="form_ins">
            <div class="form_in_line">
                <input type="hidden" id="form_clave_ins">
                <div class="form_in_line__insumo">
                    <label>Insumo</label>
                    <div>
                        <input type="text" id="form_nom_ins" placeholder="BUSCA Y LISTA EL INSUMO" class="form_cuadro_texto" required>
                        <!-- boton de ventana modal -->
                        <a class="btn btn_primary elemento_input_ins js_open_modal" modal="modal_lista_de_insumos">
                            <i class="fas fa-search-plus"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <label>Unidad</label>
                    <input type="text" id="form_unidad_ins" placeholder="UNIDAD" title="Agregar producto" class="form_cuadro_texto" required>
                </div>
                <div>
                    <label>Num. productos</label>
                    <input type="number" id="form_num_ins" min="1" max="100" placeholder="INGRESA NÚMERO" class="form_cuadro_texto" required>
                </div>
                <div>
                    <label>Cant. Mínima</label>
                    <input type="number" id="form_canmin_ins" min="1" max="1000" placeholder="INGRESA CANTIDAD" class="form_cuadro_texto" required>   
                </div>
                <div>
                    <label>Cant. Máxima</label>
                    <input type="number" id="form_canmax_ins" min="1" max="1000" placeholder="INGRESA CANTIDAD" class="form_cuadro_texto" required>
                </div>
            </div>
            <center>
                <button type="submit" class="btn_sm btn_exito elemento_input_ins_btn" id="btn_form_ins">Guardar Consumo</button>
            </center>
        </form>



        <!-- Lista de insumos agregados al producto -->
        <div class="table_responsive">
            <table class="sub_tabla_contenido">
                <thead>
                    <tr>
                        <th>Insumo</th>
                        <th>En Productos</th>
                        <th>Cons mínimo</th>
                        <th>Cons máximo</th>
                        <th>Unidad</th>
                        <th colspan="2">Opciones</th>
                    </tr>
                </thead>
                <tbody id="lista_consumos">
                    <!-- ====================================================
                    ======= Mostrar los insumos asignados al producto =======
                    ======================================================-->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include_once 'plantillas/html-cierre.php';
?>
<script src="<?php echo RUTA_JS; ?>eventos/asignar-consumo-insumo.js"></script>
