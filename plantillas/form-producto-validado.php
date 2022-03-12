<form method="post" autocomplete="off">
    <div class="cont_form_sec">
        <div>
            <label>Nombre producto</label>
            <input type="text" value="<?=$validador->obtener_producto();?>" name="NOMBRE_PRO" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            <p class="mensaje_error"><?= $validador->obtener_error_producto(); ?></p>
        </div>
        <div>
            <label>Precio venta</label>
            <input type="text" value="<?=$validador->obtener_precio();?>" name="PRECIO_PRO" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            <p class="mensaje_error"><?= $validador->obtener_error_precio(); ?></p>
        </div>
        <div>
            <label>Cantidad existencias inicial</label>
            <input type="text" value="<?=$validador->obtener_existencias();?>" name="EXISTENCIAS_PRO" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            <p class="mensaje_error"><?= $validador->obtener_error_existencias(); ?></p>
        </div>
        <div>
            <label>Cantidad Re Orden</label>
            <input type="text" value="<?=$validador->obtener_reOrden();?>" name="REORDEN_PRO" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            <p class="mensaje_error"><?= $validador->obtener_error_reOrden(); ?></p>
        </div>
        <div>
            <label>Selecciona un proveedor</label>
            <select class="form_select" name="PROVEEDOR_PRO" required>
                <option value="">: : ELIJA</option>
                <?php  
                foreach ($proveedores as $i => $proveedor) {
                    ?>
                    <option value="<?= $proveedor->getClave(); ?>" <?= Escritor::auto_select_options($proveedor->getClave(), $validador->obtener_cvl_proveedor()); ?>><?= $proveedor->getRazonsocial(); ?></option>
                    <?php
                }
                ?>
            </select>
            <p class="mensaje_error"><?= $validador->obtener_error_cvl_proveedor(); ?></p>
        </div>
        <div>
            <label>Selecciona un area producción</label>
            <select class="form_select" name="AREA_PRO" required>
                <option value="">: : ELIJA</option>
                <?php  
                foreach ($areas_prod as $i => $area) {
                    ?>
                    <option value="<?= $area->getClave(); ?>" <?= Escritor::auto_select_options($area->getClave(), $validador->obtener_cvl_area()); ?>><?= $area->getArea(); ?></option>
                    <?php
                }
                ?>
            </select>
            <p class="mensaje_error"><?= $validador->obtener_error_cvl_area(); ?></p>
        </div>
        <div>
            <label>Selecciona una categoria</label>
            <select class="form_select" name="CATEGORIA_PRO" required>
                <option value="">: : ELIJA</option>
                <?php  
                foreach ($categorias as $i => $categoria) {
                    ?>
                    <option value="<?= $categoria->getClave(); ?>" <?= Escritor::auto_select_options($categoria->getClave(), $validador->obtener_cvl_categoria()); ?>><?= $categoria->getCategoria(); ?></option>
                    <?php
                }
                ?>
            </select>
            <p class="mensaje_error"><?= $validador->obtener_error_cvl_categoria(); ?></p>
        </div>
        <div>
            <label>Selecciona una unidad de medida</label>
            <select class="form_select" name="UNIDAD_PRO" required>
                <option value="">: : ELIJA</option>
                <?php  
                foreach ($uniades as $i => $unidad) {
                    ?>
                    <option value="<?= $unidad->getClave(); ?>" <?= Escritor::auto_select_options($unidad->getClave(), $validador->obtener_cvl_unidad()); ?>><?= $unidad->getUnidad(); ?></option>
                    <?php
                }
                ?>
            </select>
            <p class="mensaje_error"><?= $validador->obtener_error_cvl_unidad(); ?></p>
        </div>
        <div>
            <label>Comentario</label>
            <textarea name="COMENTARIO_PRO" placeholder="Ingresa comentario" class="form_textarea"><?=$validador->obtener_nota();?></textarea>
            <p class="mensaje_error"><?= $validador->obtener_error_nota(); ?></p>
        </div>
    </div>

    <center>
        <input type="checkbox" id="check" name="ESTADO_PRO" class="form_checkbox" checked/>
        <label for="check">Actualmente disponible !</label>
        <button type="submit" name="REGISTRAR_PRO" class="btn btn_primary">Guardar informacion</button> 
    </center>
</form>