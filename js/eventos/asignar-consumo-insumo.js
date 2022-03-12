

// ------------------------------------------ // Obtenemos la URL del sitio web y seleccionamos los parametros GET
//Obtenermos los valores GET de la URL
const valores = window.location.search;
//Creamos la instancia
const urlParams = new URLSearchParams(valores);
//Accedemos a los valores
const producto = urlParams.get('producto');



// ------------------------------------------ // Implementacion de la funcionalidad del sitio ConsumoInsumo

const urlControlador = "../../app/controlador/ConsumoInsumo.controlador.php";
//elemento contenedro de insumos en modal
const contenedorTablaInsumos = $('#lista_insumos');
//elemento contenedro de insumos en modal
const contenedorTablaConsumos = $('#lista_consumos');
//elementoS del formulario
const var_form_ins = $('#form_ins');
const var_form_clave_ins = $('#form_clave_ins');//Se rellena
const var_form_nom_ins = $('#form_nom_ins');//Se rellena
const var_form_unidad_ins = $('#form_unidad_ins');//Se rellena
const var_form_num_ins = $('#form_num_ins');
const var_form_canmin_ins = $('#form_canmin_ins');
const var_form_canmax_ins = $('#form_canmax_ins');
const var_btn_form_ins = $('#btn_form_ins');

var registrarConsumo = true;

obtener_insumos_sin_asignar_a_producto();
obtener_consumos_producto();



function obtener_consumos_producto() {
    $.ajax({
        url: urlControlador,
        type: 'POST',
        data: {OPERACION: 'OBTENER_CONSMOS_PRODUCTO', CVL_PRODUCTO: producto},
        success: function (response) {
            let consumos = JSON.parse(response);

            let plantilla = '';

            if (consumos.length > 0) {
                consumos.forEach(consumo => {
                    plantilla += `
                    <tr>
                        <td>${consumo.insumo}</td>
                        <td>${consumo.numProductos}</td>
                        <td>${consumo.cantMin}</td>
                        <td>${consumo.cantMax}</td>
                        <td>${consumo.unidad}</td>
                        <td><a class="btn_sm btn_alerta js_mostrar_en_form_editar"  cvl_insumo="${consumo.cvl_insumo}">editar</a></td>
                        <td><a class="btn_sm btn_peligro js_eliminar_consumo" cvl_insumo="${consumo.cvl_insumo}">eliminar</a></td>
                    </tr>`;
                });
            } else {
                plantilla += `<tr><td colspan="7">No hay insumos agregados</td></tr>`;
            }
            contenedorTablaConsumos.html(plantilla);
        }
    });
}

$(document).on('click', '.js_eliminar_consumo', function () {

    let elemento = $(this)[0];
    let cvl_insumo = $(elemento).attr('cvl_insumo');

    $.ajax({
        url: urlControlador,
        type: 'POST',
        data: {OPERACION: 'ELIMINAR_CONSUMO', CVL_INSUMO: cvl_insumo, CVL_PRODUCTO: producto},
        success: function () {
            var_form_ins[0].reset();
            var_form_clave_ins.val('');
            obtener_insumos_sin_asignar_a_producto();
            obtener_consumos_producto();
            mostrarMensajeOperacion('EXITO: Se ha eliminado el consumo', 'alerta_exito');
        }
    });


});

$(document).on('submit', '#form_ins', function (e) {

    let operacion_a_realizar = 'INSERTAR_CONSUMO';

    if (!registrarConsumo) {
        operacion_a_realizar = 'ACTUALIZAR_CONSUMO';
        registrarConsumo = true;
    }

    if (var_form_clave_ins.val() !== "") {
        let insumoPOST = {
            OPERACION: operacion_a_realizar,
            CVL_PRODUCTO: producto,
            CVL_INSUMO: var_form_clave_ins.val(),
            NUM_PRODUCTOS: var_form_num_ins.val(),
            CANT_MIN: var_form_canmin_ins.val(),
            CANT_MAX: var_form_canmax_ins.val()
        };

        $.ajax({
            url: urlControlador,
            type: 'POST',
            data: insumoPOST,
            success: function () {
                var_form_ins[0].reset();
                var_form_clave_ins.val('');
                obtener_insumos_sin_asignar_a_producto();
                obtener_consumos_producto();
                mostrarMensajeOperacion('EXITO: Se ha relizado la operacion', 'alerta_exito');
            }
        });
    } else {
        mostrarMensajeOperacion('ERROR: Selecciona el insumo de la lista', 'alerta_error');
    }

    e.preventDefault();
});



$(document).on('click', '.js_mostrar_en_form_editar', function () {

    let elemento = $(this)[0];
    let cvl_insumo = $(elemento).attr('cvl_insumo');

    $.ajax({
        url: urlControlador,
        type: 'POST',
        data: {OPERACION: 'OBTENER_CONSUMO_CLAVE', CVL_PRODUCTO: producto, CVL_INSUMO: cvl_insumo},
        success: function (response) {
            let insumo = JSON.parse(response);
            insumoObj = insumo[0];

            //Se rellenan los valores del formulario
            var_form_nom_ins.val(insumoObj.insumo);
            var_form_unidad_ins.val(insumoObj.unidad);
            var_form_clave_ins.val(insumoObj.cvl_insumo);
            var_form_num_ins.val(insumoObj.numProductos);
            var_form_canmin_ins.val(insumoObj.cantMin);
            var_form_canmax_ins.val(insumoObj.cantMax);
            var_btn_form_ins.text('realizar cambios');

            registrarConsumo = false;
        }
    });
});



$(document).on('click', '.js_mostrar_en_form', function () {

    let elemento = $(this)[0];
    let cvl_insumo = $(elemento).attr('cvl_insumo');

    $.ajax({
        url: urlControlador,
        type: 'POST',
        data: {OPERACION: 'OBTENER_INSUMO_CLAVE', CVL_INSUMO: cvl_insumo},
        success: function (response) {
            let insumo = JSON.parse(response);
            insumoObj = insumo[0];
            //reseteamos el formulario
            var_form_ins[0].reset();
            var_form_clave_ins.val('');
            //Se rellenan los valores del formulario
            var_form_nom_ins.val(insumoObj.insumo);
            var_form_unidad_ins.val(insumoObj.unidad);
            var_form_clave_ins.val(insumoObj.cvl_insumo);
            var_btn_form_ins.text('guardar consumo');
        }
    });
});



function obtener_insumos_sin_asignar_a_producto() {
    $.ajax({
        url: urlControlador,
        type: 'POST',
        data: {OPERACION: 'OBTENER_INSUMOS', CVL_PRODUCTO: producto},
        success: function (response) {
            let insumos = JSON.parse(response);

            plantilla = '';

            if (insumos.length > 0) {
                insumos.forEach(insumo => {
                    plantilla += `
                    <tr>
                            <td>${insumo.insumo}</td>
                            <td>${insumo.unidad}</td>
                            <td>${insumo.categoria}</td>
                            <td><a class="btn_sm btn_exito js_mostrar_en_form js_close_modal" cvl_insumo="${insumo.cvl_insumo}" modal="modal_lista_de_insumos">listar</a></td>
                    </tr>`;
                });

            } else {
                plantilla += `<tr><td colspan="4">No hay insumos que agregar</td></tr>`;
            }

            contenedorTablaInsumos.html(plantilla);
        }
    });
}










