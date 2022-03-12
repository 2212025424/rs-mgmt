<form method="post" autocomplete="off">
    <div class="cont_form_sec">
        <div>
            <label>Nombre producto</label>
            <input type="text" id="NOMBRE_PRO_REG" name="NOMBRE_PRO" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
             <p class="mensaje_error" id="NOMBRE_PRO_REG_MEN"></p>
        </div>
        <div>
            <label>Precio venta</label>
            <input type="text" name="PRECIO_PRO" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>Cantidad existencias inicial</label>
            <input type="text" name="EXISTENCIAS_PRO" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>Cantidad Re Orden</label>
            <input type="text" name="REORDEN_PRO" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>Selecciona un proveedor</label>
            <select class="form_select" name="PROVEEDOR_PRO" required>
                <option value="">: : ELIJA</option>
                <?php  
                foreach ($proveedores as $i => $proveedor) {
                    ?>
                    <option value="<?= $proveedor->getClave(); ?>"><?= $proveedor->getRazonsocial(); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label>Selecciona un area producción</label>
            <select class="form_select" name="AREA_PRO" required>
                <option value="">: : ELIJA</option>
                <?php  
                foreach ($areas_prod as $i => $area) {
                    ?>
                    <option value="<?= $area->getClave(); ?>"><?= $area->getArea(); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label>Selecciona una categoria</label>
            <select class="form_select" name="CATEGORIA_PRO" required>
                <option value="">: : ELIJA</option>
                <?php  
                foreach ($categorias as $i => $categoria) {
                    ?>
                    <option value="<?= $categoria->getClave(); ?>"><?= $categoria->getCategoria(); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label>Selecciona una unidad de medida</label>
            <select class="form_select" name="UNIDAD_PRO" required>
                <option value="">: : ELIJA</option>
                <?php  
                foreach ($uniades as $i => $unidad) {
                    ?>
                    <option value="<?= $unidad->getClave(); ?>"><?= $unidad->getUnidad(); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label>Comentario</label>
            <textarea name="COMENTARIO_PRO" placeholder="Ingresa comentario" class="form_textarea"></textarea>
        </div>
    </div>

    <center>
        <input type="checkbox" id="check" name="ESTADO_PRO" class="form_checkbox" checked/>
        <label for="check">Actualmente disponible !</label>
        <button type="submit" name="REGISTRAR_PRO" class="btn btn_primary">Guardar informacion</button> 
    </center>
</form>