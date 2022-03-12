<?php  

include_once 'Validador.inc.php';

class ValidadorAcceso extends Validador{

	private $error;
	private $usuario;

	public function __construct($clave, $contrasenia, $conexion){
		$this->error = "";
		$this->usuario = null;

		if (!$this->variable_iniciada($clave) || !$this->variable_iniciada($contrasenia)) {
			$this->error = "Debes ingresar la clave usuario y contraseña";
		}else{
			$this->usuario = RepositorioUsuario::obtener_usuario_por_clave($clave, $conexion);

			if (is_null($this->usuario) || md5($contrasenia) !== $this->usuario->getContrasenia()) {
				$this->error = "Los datos ingresados son inválidos";
			}
			if (!is_null($this->usuario) && $this->usuario->getEstado() != 1) {
				$this->error = "EL usuario está suspendido o bloqueado";
			}

		}

	}

	public function obtener_usuario () {
		return $this->usuario;
	}

	public function obtener_error () {
		return $this->error;
	}

}
