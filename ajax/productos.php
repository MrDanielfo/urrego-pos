<?php

require_once '../controllers/ProductsController.php';
require_once '../models/ProductsModel.php'; 

class ProductosAjax {

	public $idCategoria;

	public $idProducto;

	public $traerProductos;

	public $nombreProducto;

	public function mostrarCodigoAjax(){

		$item = 'id_categoria'; 
		$valor = $this->idCategoria;

		$tabla = 'productos';

		$respuesta = new ProductsController();
		$respuesta->mostrarCodigo($item, $valor, $tabla);

		return $respuesta; 

	}

	public function mostrarIdProductoAjax() {

		$item = 'id';
		$valor = $this->idProducto;
		$tabla = 'productos';
		$orden = "id";

		$respuesta = new ProductsController();
		$respuesta->mostrarIdProducto($item, $valor, $tabla, $orden);

		return $respuesta; 

	}

	public function traerProductosAjax() {

		if($this->traerProductos == 'ok') {

			$item = null;
			$valor = null;
			$tabla = 'productos';

		}

		
		$respuesta = new ProductsController();
		$respuesta->mostrarIdProducto($item, $valor, $tabla);

		return $respuesta; 

	}

	public function traerProductoResponsive() {

		$item = 'descripcion';
		$valor = $this->nombreProducto;
		$tabla = 'productos';

		$respuesta = new ProductsController();
		$respuesta->mostrarIdProducto($item, $valor, $tabla);

		return $respuesta;


	}


}

if(isset($_POST['idCategoria'])) {

 $codigoCategoria = new ProductosAjax();
 $codigoCategoria->idCategoria = $_POST['idCategoria'];
 $codigoCategoria->mostrarCodigoAjax();

}

if(isset($_POST['idProducto'])) {

	$idEditarProducto = new ProductosAjax();
	$idEditarProducto->idProducto = $_POST['idProducto'];
	$idEditarProducto->mostrarIdProductoAjax();

}

if(isset($_POST['traerProductos'])) {

	$todosProductos = new ProductosAjax();
	$todosProductos->traerProductos = $_POST['traerProductos']; 
	$todosProductos->traerProductosAjax();

}

if(isset($_POST['nombreProducto'])) {

	$productoResponsive = new ProductosAjax();
	$productoResponsive->nombreProducto = $_POST['nombreProducto'];
	$productoResponsive->traerProductoResponsive();


}