<?php

require_once '../controllers/UsersController.php';
require_once '../models/UsersModel.php';

class UsuariosAjax {

	public $idUsuario;
	public $idUsuarioEstado;
	public $estadoUsuario;
	public $usuarioRepetido; 

	public function editarUsuarioAjax() {

		$valor =  $this->idUsuario;
		$item = "id";
		$tabla = "usuarios";
		$respuesta = new UsersController();
		$respuesta->mostrarUsuarioAjax($tabla, $item, $valor);
		return $respuesta; 

	}

	public function activarEstadoAjax() {

		$datosAjax = array(
			"idUsuarioEstado" => $this->idUsuarioEstado,
			"estadoUsuario" => $this->estadoUsuario
		);

		$tabla = "usuarios";

		$respuesta = UsersModel::activarEstado($datosAjax, $tabla );

		return $respuesta;

	}


	public function detectarUsuarioAjax() {

		
		$valor = $this->usuarioRepetido;

		$tabla = "usuarios";
		$item = "usuario";

		$respuesta = new UsersController();
		$respuesta->detectarUsuario($tabla, $item, $valor);

		return $respuesta;

	}


}

if(isset($_POST['idUsuario'])) {

	$editarUsuario = new UsuariosAjax();

	$editarUsuario->idUsuario = $_POST['idUsuario'];
	$editarUsuario->editarUsuarioAjax();

}

if(isset($_POST['idUsuarioEstado'])) {

	$activarEstado = new UsuariosAjax();
	$activarEstado->idUsuarioEstado = $_POST['idUsuarioEstado'];
	$activarEstado->estadoUsuario = $_POST['estadoUsuario'];
	$activarEstado->activarEstadoAjax();

}

if(isset($_POST['usuario'])) {

	$usuario = new UsuariosAjax();
	$usuario->usuarioRepetido = $_POST['usuario'];
	$usuario->detectarUsuarioAjax();

}

