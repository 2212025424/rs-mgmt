
// -- Declaraciones iniciales ---------------------------------------------------------------

// Url del archivo controlador php
const urlControlador = "../../app/controlador/Insumo.controlador.php";

//Obtenermos los valores GET de la URL
const valores = window.location.search;
const urlParams = new URLSearchParams(valores);
const cvl_insumo = urlParams.get('insumo');

//Id de los elementos HTML
const var_nombre_ins_reg = $('#NOMBRE_INS_ACT');
const var_nombre_ins_reg_men = $('#NOMBRE_INS_ACT_MEN');

var_nombre_ins_reg.keyup(function(){
	let valorNombre = $(this).val();

	if (valorNombre !== "") {
		$.ajax({
			url: urlControlador,
			type: 'POST',
			data: {CLAVE_INS_ACT: cvl_insumo, NOMBRE_INS_ACT: valorNombre},
			success: function(response){
				if (response == 100) {
					var_nombre_ins_reg_men.text('Ya hay un insumo con este nombre');
				}else {
					var_nombre_ins_reg_men.text('');
				}
			}
		})
	}else{
		var_nombre_ins_reg_men.text('');
	}

});




