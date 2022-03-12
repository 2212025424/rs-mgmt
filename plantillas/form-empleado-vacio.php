



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
                        <option value="<?= $puesto->getClave(); ?>" <?= Escritor::auto_select_options($empleado->getCvl_puesto(), $puesto->getClave()); ?>><?= $puesto->getPuesto(); ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div>
                <label>Nombre de la persona</label>
                <input type="text" value="<?= $empleado->getNombre() ?>" name="NOMBRE_EMP" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            </div>
            <div>
                <label>Apellido paterno</label>
                <input type="text" value="<?= $empleado->getApaterno() ?>" name="APA_EMP" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            </div>
            <div>
                <label>Apellido materno</label>
                <input type="text" value="<?= $empleado->getAmaterno() ?>"  name="AMA_EMP" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            </div>
            <div>
                <label>Fecha nacimiento</label>
                <input type="date" value="<?= $empleado->getFechaNac() ?>"  name="FECHA_EMP" class="form_cuadro_texto" required/>
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
                        <option value="<?= $puesto->getClave(); ?>"><?= $puesto->getPuesto(); ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div>
                <label>Clave empleado</label>
                <input type="text" name="CLAVE_EMP" value="EMP-" class="form_cuadro_texto" placeholder="ejem.. EMP-098" required/>
            </div>
            <div>
                <label>Nombre de la persona</label>
                <input type="text" name="NOMBRE_EMP" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            </div>
            <div>
                <label>Apellido paterno</label>
                <input type="text" name="APA_EMP" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            </div>
            <div>
                <label>Apellido materno</label>
                <input type="text" name="AMA_EMP" class="form_cuadro_texto" placeholder="Ingresa el dato. . ." required/>
            </div>
            <div>
                <label>Fecha nacimiento</label>
                <input type="date" name="FECHA_EMP" class="form_cuadro_texto" required/>
            </div>
        </div>

        <center>
            <button type="submit" name="REGISTRAR_EMP" class="btn btn_primary">Guardar Informacion</button> 
        </center>
    </form>
    <?php
}
?>




