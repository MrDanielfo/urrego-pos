<?php

require_once '../controllers/ProductsController.php';
require_once '../models/ProductsModel.php'; 


class DataTableVentasAjax {

	public function mostrarTablaProductosVentas() {

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

			$botonAgregar = "<button class='btn btn-primary btnAgregarProducto recuperarBoton' idProducto='" . $productos[$i]["id"] . "'>Agregar</button>"; 

			$datosJson .= '[
					   "'. ($i + 1)  .'",
					   "'. $imagen .'",
					   "'. $productos[$i]["codigo"] .'",
					   "'. $productos[$i]["descripcion"] .'",
					   "'. $stock .'",
					   "'. $botonAgregar .'"
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

$activarProductos = new DataTableVentasAjax();
$activarProductos->mostrarTablaProductosVentas(); 