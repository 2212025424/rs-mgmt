
// -- Declaraciones iniciales ---------------------------------------------------------------

// Url del archivo controlador php
const urlControlador = "../../app/controlador/Producto.controlador.php";

//Id de los elementos HTML
const var_nombre_pro_reg = $('#NOMBRE_PRO_REG');
const var_nombre_pro_reg_men = $('#NOMBRE_PRO_REG_MEN');

var_nombre_pro_reg.keyup(function(){
	let valorNombre = $(this).val();

	if (valorNombre !== "") {
		$.ajax({
			url: urlControlador,
			type: 'POST',
			data: {NOMBRE_PRO_REG: valorNombre},
			success: function(response){
				if (response == 100) {
					var_nombre_pro_reg_men.text('Ya hay un producto con este nombre');
				}else {
					var_nombre_pro_reg_men.text('');
				}
			}
		})
	}else{
		var_nombre_pro_reg_men.text('');
	}

});




