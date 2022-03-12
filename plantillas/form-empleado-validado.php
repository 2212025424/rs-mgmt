<?php
if (isset($_GET['empleado'])) {
    
    ?>
    <form method="post" autocomplete="off">
        <div class="cont_form_sec">
            <div>
                <label>Puesto de trabajo</label>
                <select class="form_select" name="PUESTO_EMP" required>
                    <option value="">: : ELIJA</option>
                    <?php
                    Conexion::abrir_conexion();
                    $puestos = RepositorioPuesto::obtener_puestos(Conexion::obtener_conexion());
                    Conexion::cerrar_conexion();

                    foreach ($puestos as $i => $puesto) {
                        ?>
                        <option value="<?= $puesto->getClave(); ?>" <?= Escritor::auto_select_options($validador->obtener_puesto(), $puesto->getClave()); ?>><?= $puesto->getPuesto(); ?></option>
                        <?php
                    }
                    ?>
                </select>
                <p class="mensaje_error"><?= $validador->obtener_error_puesto(); ?></p>
            </div>
            <div>
                <label>Nombre de la persona</label>
                <input type="text" value="<?= $validador->obtener_nombre(); ?>" name="NOMBRE_EMP" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
                <p class="mensaje_error"><?= $validador->obtener_error_nombre(); ?></p>
            </div>
            <div>
                <label>Apellido paterno</label>
                <input type="text" value="<?= $validador->obtener_apaterno(); ?>" name="APA_EMP" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
                <p class="mensaje_error"><?= $validador->obtener_error_apaterno(); ?></p>
            </div>
            <div>
                <label>Apellido materno</label>
                <input type="text" value="<?= $validador->obtener_amaterno(); ?>" name="AMA_EMP" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
                <p class="mensaje_error"><?= $validador->obtener_error_amaterno(); ?></p>
            </div>
            <div>
                <label>Fecha nacimiento</label>
                <input type="date" value="<?= $validador->obtener_fecha(); ?>" name="FECHA_EMP" class="form_cuadro_texto" required/>
                <p class="mensaje_error"><?= $validador->obtener_error_fecha(); ?></p>
            </div>
        </div>

        <center>
            <button type="submit" name="REGISTRAR_EMP" class="btn btn_primary">Guardar Informacion</button> 
        </center>
    </form>


    <?php
} else {
    ?>

    <form method="post" autocomplete="off">
        <div class="cont_form_sec">
            <div>
                <label>Puesto de trabajo</label>
                <select class="form_select" name="PUESTO_EMP" required>
                    <option value="">: : ELIJA</option>
                    <?php
                    Conexion::abrir_conexion();
                    $puestos = RepositorioPuesto::obtener_puestos(Conexion::obtener_conexion());
                    Conexion::cerrar_conexion();

                    foreach ($puestos as $i => $puesto) {
                        ?>
                        <option value="<?= $puesto->getClave(); ?>" <?= Escritor::auto_select_options($validador->obtener_puesto(), $puesto->getClave()); ?>><?= $puesto->getPuesto(); ?></option>
                        <?php
                    }
                    ?>
                </select>
                <p class="mensaje_error"><?= $validador->obtener_error_puesto(); ?></p>
            </div>
            <div>
                <label>Clave empleado</label>
                <input type="text" name="CLAVE_EMP" value="<?= $validador->obtener_clave(); ?>" class="form_cuadro_texto" placeholder="ejem.. EMP-098" required/>
                <p class="mensaje_error"><?= $validador->obtener_error_clave(); ?></p>
            </div>
            <div>
                <label>Nombre de la persona</label>
                <input type="text" value="<?= $validador->obtener_nombre(); ?>" name="NOMBRE_EMP" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
                <p class="mensaje_error"><?= $validador->obtener_error_nombre(); ?></p>
            </div>
            <div>
                <label>Apellido paterno</label>
                <input type="text" value="<?= $validador->obtener_apaterno(); ?>" name="APA_EMP" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
                <p class="mensaje_error"><?= $validador->obtener_error_apaterno(); ?></p>
            </div>
            <div>
                <label>Apellido materno</label>
                <input type="text" value="<?= $validador->obtener_amaterno(); ?>" name="AMA_EMP" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
                <p class="mensaje_error"><?= $validador->obtener_error_amaterno(); ?></p>
            </div>
            <div>
                <label>Fecha nacimiento</label>
                <input type="date" value="<?= $validador->obtener_fecha(); ?>" name="FECHA_EMP" class="form_cuadro_texto" required/>
                <p class="mensaje_error"><?= $validador->obtener_error_fecha(); ?></p>
            </div>
        </div>

        <center>
            <button type="submit" name="REGISTRAR_EMP" class="btn btn_primary">Guardar Informacion</button> 
        </center>
    </form>


    <?php
}
?>
