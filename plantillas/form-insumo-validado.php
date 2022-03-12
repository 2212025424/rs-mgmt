
<form method="post" autocomplete="off">
    <div class="cont_form_sec">
        <div>
            <label>Nombre insumo</label>
            <input type="text" value="<?= $validador->obtener_insumo(); ?>" name="NOMBRE_INS" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            <p class="mensaje_error"><?= $validador->obtener_error_insumo(); ?></p>
        </div>
        <div>
            <label>Cantidad existencias inicial</label>
            <input type="text" value="<?= $validador->obtener_existencias(); ?>" name="EXISTENCIAS_INS" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            <p class="mensaje_error"><?= $validador->obtener_error_existencias(); ?></p>
        </div>
        <div>
            <label>Cantidad re Orden</label>
            <input type="text" value="<?= $validador->obtener_reOrden(); ?>" name="REORDEN_INS" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            <p class="mensaje_error"><?= $validador->obtener_error_reOrden(); ?></p>
        </div>
        <div>
            <label>Selecciona un proveedor</label>
            <select class="form_select" name="PROVEEDOR_INS" required>
                <option value="">: : ELIJA</option>
                <?php  
                foreach ($proveedores as $proveedor) {
                    ?>
                    <option value="<?= $proveedor->getClave(); ?>" <?= Escritor::auto_select_options($validador->obtener_proveedor(), $proveedor->getClave()); ?>><?= $proveedor->getRazonsocial(); ?></option>
                    <?php
                }
                ?>
            </select>
            <p class="mensaje_error"><?= $validador->obtener_error_proveedor(); ?></p>
        </div>
        <div>
            <label>Selecciona una categoria</label>
            <select class="form_select" name="CATEGORIA_INS" required>
                <option value="">: : ELIJA</option>
                <?php  
                foreach ($categorias as $categoria) {
                    ?>
                    <option value="<?= $categoria->getClave(); ?>" <?= Escritor::auto_select_options($validador->obtener_categoria(), $categoria->getClave()); ?>><?= $categoria->getCategoria(); ?></option>
                    <?php
                }
                ?>
            </select>
            <p class="mensaje_error"><?= $validador->obtener_error_categoria(); ?></p>
        </div>
        <div>
            <label>Selecciona una unidad de medida</label>
            <select class="form_select" name="UNIDAD_INS" required>
                <option value="">: : ELIJA</option>
                <?php  
                foreach ($uniades as $unidad) {
                    ?>
                    <option value="<?= $unidad->getClave(); ?>" <?= Escritor::auto_select_options($validador->obtener_unidad(), $unidad->getClave()); ?>><?= $unidad->getUnidad(); ?></option>
                    <?php
                }
                ?>
            </select>
            <p class="mensaje_error"><?= $validador->obtener_error_unidad(); ?></p>
        </div>
        <div>
            <label>Comentario</label>
            <textarea name="COMENTARIO_INS" placeholder="Ingresa comentario" class="form_textarea"><?=$validador->obtener_nota();?></textarea>
            <p class="mensaje_error"><?= $validador->obtener_error_nota(); ?></p>
        </div>
    </div>

    <center>
        <button type="submit" name="REGISTRAR_INS" class="btn btn_primary">Guardar Informacion</button> 
    </center>
</form>