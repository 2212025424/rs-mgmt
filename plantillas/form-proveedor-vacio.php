<?php 
if (isset($_GET['proveedor'])) { 
?>
<form method="post" autocomplete="off">
    <div class="cont_form_sec">
        <div>
            <label>Razón Social</label>
            <input type="text" value="<?=$proveedor->getRazonsocial();?>" name="RAZ_SOC" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>RFC empresa</label>
            <input type="text" value="<?=$proveedor->getRFC();?>" name="RFC" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>Teléfono</label>
            <input type="text" value="<?=$proveedor->getTelefono();?>" name="TEL" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>Correo</label>
            <input type="email" value="<?=$proveedor->getCorreo();?>" name="CORREO" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>Comentario</label>
            <textarea name="COMENTARIO" placeholder="Ingresa comentario" class="form_textarea"><?=$proveedor->getNota();?></textarea>
        </div>
    </div>
    <center>
        <button type="submit" name="REGISTRAR_PRO" class="btn btn_primary">Guardar Informacion</button> 
    </center>
</form>
<?php 
}else{ 
?>
<form method="post" autocomplete="off">
    <div class="cont_form_sec">
        <div>
            <label>Razón Social</label>
            <input type="text" name="RAZ_SOC" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>RFC empresa</label>
            <input type="text" name="RFC" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>Teléfono</label>
            <input type="text" name="TEL" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>Correo</label>
            <input type="email" name="CORREO" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
        </div>
        <div>
            <label>Comentario</label>
            <textarea name="COMENTARIO" placeholder="Ingresa comentario" class="form_textarea"></textarea>
        </div>
    </div>
    <center>
        <button type="submit" name="REGISTRAR_PRO" class="btn btn_primary">Guardar Informacion</button> 
    </center>
</form>
<?php
}
?>








