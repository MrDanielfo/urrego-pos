<?php


require_once '../controllers/CategoriesController.php';
require_once '../models/CategoriesModel.php';

class CategoriasAjax {

	public $idCategoria;

	public function editarCategoriaAjax(){

		$datos = $this->idCategoria;

		$respuesta = new CategoriesController();
		$respuesta->mostrarCategoriaAjax($datos);
		return $respuesta; 

	}


}

if(isset($_POST['idCategoria'])) {

	$editarCategoria = new CategoriasAjax();
	$editarCategoria->idCategoria = $_POST['idCategoria'];
	$editarCategoria->editarCategoriaAjax();


}

