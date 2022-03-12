
// -- Declaraciones iniciales ---------------------------------------------------------------

// Url del archivo controlador php
const urlControlador = "../../app/controlador/Insumo.controlador.php";

//Id de los elementos HTML
const var_nombre_ins_reg = $('#NOMBRE_INS_REG');
const var_nombre_ins_reg_men = $('#NOMBRE_INS_REG_MEN');

var_nombre_ins_reg.keyup(function(){
	let valorNombre = $(this).val();

	if (valorNombre !== "") {
		$.ajax({
			url: urlControlador,
			type: 'POST',
			data: {NOMBRE_INS_REG: valorNombre},
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




