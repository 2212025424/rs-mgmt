<form method="post" autocomplete="off">
    <div class="cont_form_sec">
        <div>
            <label>Razón Social</label>
            <input type="text" name="RAZ_SOC" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required value="<?=$validador->obtener_razonsocial();?>" />
            <p class="mensaje_error"><?= $validador->obtener_error_razonsocial(); ?></p>
        </div>
        <div>
            <label>RFC empresa</label>
            <input type="text" name="RFC" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required value="<?=$validador->obtener_RFC();?>"/>
            <p class="mensaje_error"><?= $validador->obtener_error_RFC(); ?></p>
        </div>
        <div>
            <label>Teléfono</label>
            <input type="text" name="TEL" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required value="<?=$validador->obtener_telefono();?>"/>
            <p class="mensaje_error"><?= $validador->obtener_error_telefono(); ?></p>
        </div>
        <div>
            <label>Correo</label>
            <input type="email" name="CORREO" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required value="<?=$validador->obtener_correo();?>"
            />
            <p class="mensaje_error"><?= $validador->obtener_error_correo(); ?></p>
        </div>
        <div>
            <label>Comentario</label>
            <textarea name="COMENTARIO" placeholder="Ingresa comentario" class="form_textarea"><?=$validador->obtener_nota();?></textarea>
            <p class="mensaje_error"><?= $validador->obtener_error_nota(); ?></p>
        </div>
    </div>
    <center>
        <button type="submit" name="REGISTRAR_PRO" class="btn btn_primary">Guardar Informacion</button> 
    </center>
</form>