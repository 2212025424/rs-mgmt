<form method="post" autocomplete="off">
    <div class="cont_form_sec">

        <div>
            <label>Selecciona un rol de usuario</label>
            <select class="form_select" name="CVL_ROL" required>
                <option value="">: : ELIJA</option>
                <?php
                foreach ($roles as $rol) {
                    ?>
                    <option value="<?= $rol->getClave(); ?>"><?= $rol->getRol(); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>

        <div>
            <label>Selecciona un empleado</label>
            <select class="form_select" name="CLV_EMP" required>
                <option value="">: : ELIJA</option>
                <?php
                foreach ($empleados as $empleado) {
                    ?>
                    <option value="<?= $empleado->getClave(); ?>"><?= $empleado->getClave() . ' | ' . $empleado->getNombre(); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>

        <div>
            <label>Ingresa una contraseña</label>
            <input type="password" name="PASS_1" class="form_cuadro_texto" placeholder="Ingresa la contraseña. . ." required/>
        </div>

        <div>
            <label>Repite la contraseña</label>
            <input type="password" name="PASS_2" class="form_cuadro_texto" placeholder="Confirma la contraseña. . ." required/>
        </div>

    </div>
    <center>
            <input type="checkbox" id="check" name="ESTADO_USR" class="form_checkbox" checked/>
            <label for="check">Actualmente con acceso !</label>
            <button type="submit" name="REGISTRAR_USR" class="btn btn_primary">Guardar informacion</button> 
        </center>
</form>
