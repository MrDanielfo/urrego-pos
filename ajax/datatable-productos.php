<?php

require_once '../controllers/ProductsController.php';
require_once '../models/ProductsModel.php'; 
require_once '../controllers/CategoriesController.php';
require_once '../models/CategoriesModel.php'; 

class DataTableProductosAjax {

	public function mostrarTablaProductos() {

		$item = null;
        $valor = null;
        $orden = "id";

        $productos = ProductsController::mostrarProductos($item, $valor, $orden);

        $datosJson =  '{
			"data": ['; 

		for ($i= 0; $i < count($productos) ; $i++) { 

			if($productos[$i]["stock"] <= 10) {

				$stock = "<button class='btn btn-danger'>". $productos[$i]["stock"] ."</button>";

			} else if ($productos[$i]["stock"] > 11 && $productos[$i]["stock"] <= 15) {

				$stock = "<button class='btn btn-warning'>". $productos[$i]["stock"] ."</button>";
			} else {

				$stock = "<button class='btn btn-success'>". $productos[$i]["stock"] ."</button>";
			}

			

			$imagen = "<img src='". $productos[$i]["imagen"] ."' class='img-thumbnail' width='40px'>";

			if(isset($_GET['perfilOculto']) &&  $_GET['perfilOculto'] == "Especial") {

				$botonEditar = "<button class='btn btn-warning btnEditarProducto' idproducto='" . $productos[$i]["id"] . "' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button>"; 

			} else {

				$botonEditar = "<button class='btn btn-warning btnEditarProducto' idproducto='" . $productos[$i]["id"] . "' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button>"; 
				$botonEliminar = "<button class='btn btn-danger btnEliminarProducto' idProducto='" . $productos[$i]["id"] . "' fotoProducto='" . $productos[$i]["imagen"] . "' codigoProducto='" . $productos[$i]["codigo"] . "'><i class='fa fa-times'></i></button>";

			}

				

			
			$item2 = "id";
        	$valor2 = $productos[$i]["id_categoria"]; 
            
        	$categorias = ProductsController::categoriaProducto($item2, $valor2);

			$datosJson .= '[
					   "'. ($i + 1)  .'",
					   "'. $imagen .'",
					   "'. $productos[$i]["codigo"] .'",
					   "'. $productos[$i]["descripcion"] .'",
					   "'. $categorias["categoria"] .'",
					   "'. $stock .'",
					   "$'. $productos[$i]["precio_compra"] .'",
					   "$'. $productos[$i]["precio_venta"] .'",
					   "'. $productos[$i]["fecha"] .'",
					   "'. $botonEditar .'",
					   "'. $botonEliminar .'"
					],'; 
				
			}

		$datosJson = substr($datosJson, 0, -1); 

		$datosJson .= '   
				]
			}'; 



		echo $datosJson; 

	}


} // fin de la clase

// Activar tabla de productos 

$activarProductos = new DataTableProductosAjax();
$activarProductos->mostrarTablaProductos(); 