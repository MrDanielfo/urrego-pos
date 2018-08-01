<?php

require_once '../controllers/ClientsController.php';
require_once '../models/ClientsModel.php';


class ClientesAjax {

	public $idCliente;

	public function mostrarIdClienteAjax() {

		$item = "id";
		$datos = $this->idCliente;
		$tabla = "clientes";

		$respuesta = new ClientsController();
		$respuesta->mostrarIdCliente($datos, $item, $tabla);

		return $respuesta;


	}


}

if(isset($_POST['idCliente'])) {

	$clienteAjax = new ClientesAjax();
	$clienteAjax->idCliente = $_POST['idCliente'];
	$clienteAjax->mostrarIdClienteAjax();

}