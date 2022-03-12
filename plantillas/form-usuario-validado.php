<form method="post" autocomplete="off">
    <div class="cont_form_sec">

        <div>
            <label>Selecciona un rol de usuario</label>
            <select class="form_select" name="CVL_ROL" required>
                <option value="">: : ELIJA</option>
                <?php
                foreach ($roles as $rol) {
                    ?>
                    <option value="<?= $rol->getClave(); ?>"  <?= Escritor::auto_select_options($validador->obtener_rol(), $rol->getClave()); ?> ><?= $rol->getRol(); ?></option>
                    <?php
                }
                ?>
            </select>
            <p class="mensaje_error"><?= $validador->obtener_error_rol(); ?></p>
        </div>



        <div>
            <label>Selecciona un empleado</label>
            <select class="form_select" name="CLV_EMP" required>
                <option value="">: : ELIJA</option>
                <?php
                foreach ($empleados as $empleado) {
                    ?>
                    <option value="<?= $empleado->getClave(); ?>" <?= Escritor::auto_select_options($validador->obtener_empleado(), $empleado->getClave()); ?>><?= $empleado->getClave() . ' ' . $empleado->getNombre(); ?></option>
                    <?php
                }
                ?>
            </select>
            <p class="mensaje_error"><?= $validador->obtener_error_empleado(); ?></p>
        </div>


        <div>
            <label>Ingresa una contraseña</label>
            <input type="password" name="PASS_1" class="form_cuadro_texto" placeholder="Ingresa la contraseña. . ." required/>
            <p class="mensaje_error"><?= $validador->obtener_error_error_pass1(); ?></p>
        </div>

        <div>
            <label>Repite la contraseña</label>
            <input type="password" name="PASS_2" class="form_cuadro_texto" placeholder="Confirma la contraseña. . ." required/>
            <p class="mensaje_error"><?= $validador->obtener_error_error_pass2(); ?></p>
        </div>

    </div>
    <center>
            <input type="checkbox" id="check" name="ESTADO_USR" class="form_checkbox" checked/>
            <label for="check">Actualmente con acceso !</label>
            <button type="submit" name="REGISTRAR_USR" class="btn btn_primary">Guardar informacion</button> 
        </center>
</form>
