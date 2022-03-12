<?php

if (isset($_GET['insumo'])) {
?>
<form method="post" autocomplete="off">
    <div class="cont_form_sec">
        <div>
            <label>Nombre insumo</label>
            <input type="text" id="NOMBRE_INS_ACT" value="<?=$insumo->getInsumo();?>" name="NOMBRE_INS" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            <p class="mensaje_error" id="NOMBRE_INS_ACT_MEN"></p>
        </div>
        <div>
            <label>Cantidad existencias inicial</label>
            <input type="text" value="<?=$insumo->getExistencias();?>" name="EXISTENCIAS_INS" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>Cantidad re Orden</label>
            <input type="text" value="<?=$insumo->getReorden();?>" name="REORDEN_INS" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>Selecciona un proveedor</label>
            <select class="form_select" name="PROVEEDOR_INS" required>
                <option value="">: : ELIJA</option>
                <?php  
                foreach ($proveedores as $i => $proveedor) {
                    ?>
                    <option value="<?= $proveedor->getClave(); ?>" <?= Escritor::auto_select_options($insumo->getCvl_proveedor(), $proveedor->getClave()); ?>><?= $proveedor->getRazonsocial(); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label>Selecciona una categoria</label>
            <select class="form_select" name="CATEGORIA_INS" required>
                <option value="">: : ELIJA</option>
                <?php  
                foreach ($categorias as $i => $categoria) {
                    ?>
                    <option value="<?= $categoria->getClave(); ?>" <?= Escritor::auto_select_options($insumo->getCvl_categoria(), $categoria->getClave()); ?>><?= $categoria->getCategoria(); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label>Selecciona una unidad de medida</label>
            <select class="form_select" name="UNIDAD_INS" required>
                <option value="">: : ELIJA</option>
                <?php  
                foreach ($uniades as $i => $unidad) {
                    ?>
                    <option value="<?= $unidad->getClave(); ?>" <?= Escritor::auto_select_options($insumo->getCvl_unidad(), $unidad->getClave()); ?>><?= $unidad->getUnidad(); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label>Comentario</label>
            <textarea name="COMENTARIO_INS" placeholder="Ingresa comentario" class="form_textarea"><?=$insumo->getNota();?></textarea>
        </div>
    </div>

    <center>
        <button type="submit" name="REGISTRAR_INS" class="btn btn_primary">Guardar Informacion</button> 
    </center>
</form>


<?php
}else{
?>

<form method="post" autocomplete="off">
    <div class="cont_form_sec">
        <div>
            <label>Nombre insumo</label>
            <input id="NOMBRE_INS_REG" type="text" name="NOMBRE_INS" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            <p class="mensaje_error" id="NOMBRE_INS_REG_MEN"></p>
        </div>
        <div>
            <label>Cantidad existencias inicial</label>
            <input type="text" name="EXISTENCIAS_INS" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>Cantidad re Orden</label>
            <input type="text" name="REORDEN_INS" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>Selecciona un proveedor</label>
            <select class="form_select" name="PROVEEDOR_INS" required>
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
            <label>Selecciona una categoria</label>
            <select class="form_select" name="CATEGORIA_INS" required>
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
            <select class="form_select" name="UNIDAD_INS" required>
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
            <textarea name="COMENTARIO_INS" placeholder="Ingresa comentario" class="form_textarea"></textarea>
        </div>
    </div>

    <center>
        <button type="submit" name="REGISTRAR_INS" class="btn btn_primary">Guardar Informacion</button> 
    </center>
</form>

<?php
}
?>
