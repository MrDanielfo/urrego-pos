<?php


class SellsController {


	static public function mostrarVentas($item, $valor) {

		$tabla = "ventas"; 

		$respuesta = SellsModel::mostrarVentas($item, $valor, $tabla);

		return $respuesta;


	} // fin del método mostrarVentas

	static public function mostrarClientes($item, $valor) {

		$tabla = "clientes"; 

		$respuesta = SellsModel::mostrarClientes($item, $valor, $tabla);

		return $respuesta;


	} // fin del método mostrarCliente

	static public function mostrarVendedor($item, $valor) {

		$tabla = "usuarios"; 

		$respuesta = SellsModel::mostrarVendedor($item, $valor, $tabla);

		return $respuesta;


	} // fin del método mostrarCliente



    public function crearVenta() {

		if(isset($_POST['nuevaVenta'])) {

			/* Actualizar compras del cliente, reducir el stock y aumentar ventas de los productos */ 

			$listaProductos = json_decode($_POST['listaProductosVenta'], true); 
			$totalProductosComprados = array();

			//var_dump($listaProductos);

			foreach($listaProductos as $key => $value) {

				array_push($totalProductosComprados, $value['cantidad']); 

				$tablaProducto = "productos";
				$item = "id";
				$valor = $value['id'];
				$orden = "id";

				$traerProducto = ProductsModel::mostrarProductos($item, $valor, $tablaProducto, $orden);

				$item1 = $value['id'];
				$item2 = "ventas";
				$valor2 = $value['cantidad'] + $traerProducto['ventas'];

				$actualizarVenta = ProductsModel::editarVentaProducto($item1, $item2, $valor2, $tablaProducto); 

				$itemStock = "stock";
				$valorStock = $value['stockFinal']; 


				$actualizarStock = ProductsModel::editarVentaProducto($item1, $itemStock, $valorStock, $tablaProducto);


			}

			$tablaCliente = "clientes";

			$item = "id";
			$datos =  $_POST['seleccionarCliente'];

			$traerCliente = ClientsModel::mostrarIdCliente($datos, $item, $tablaCliente);

			//var_dump($traerCliente['total_compras']);

			$itemCliente = "total_compras";
			$valorCliente = array_sum($totalProductosComprados) + $traerCliente['total_compras'] ; 

			$actualizarCompraCliente = ClientsModel::actualizarCompraCliente($datos, $itemCliente, $valorCliente, $tablaCliente);

			date_default_timezone_set('America/Mexico_City');

			$fecha = date('Y-m-d');
		    $hora = date("H:i:s");

		    $fechaActual = $fecha. ' ' .$hora;

			$itemUltimaCompra = "ultima_compra";
			$valorUltimaCompra = $fechaActual;

			$ultimaCompraCliente = ClientsModel::actualizarCompraCliente($datos, $itemUltimaCompra, $valorUltimaCompra, $tablaCliente);
			/* fin de la sección */ 

			/* Guardar la Compra */ 

			$tabla = "ventas";

			$datos = array(
				"codigo" 		=> $_POST['nuevaVenta'],
				"id_cliente" 	=> $_POST['seleccionarCliente'],
				"id_vendedor" 	=> $_POST['idVendedor'],
				"productos"     => $_POST['listaProductosVenta'],
				"impuesto"		=> $_POST['nuevoPrecioImpuesto'],
				"neto"			=> $_POST['nuevoPrecioNeto'],
				"total_venta"   => $_POST['realTotalVenta'],
				"metodo_pago"   => $_POST['listaMetodoPago']
			);

			$respuesta = SellsModel::crearVenta($tabla, $datos);

			//var_dump($respuesta);

			if($respuesta == 'ok') {
					echo '<script>
							swal({
								type : "success",
								title: "La compra  fue realizada con éxito",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result) => {
								if(result.value) {
									window.location = "crear-ventas";
								}
							})
						</script>';
				}

		}


		
	} // fin del método 

    public function editarVenta() {

		if(isset($_POST['editarCodigoOculto'])) {

			/* formatear tablas */ 

			$tabla = "ventas";
			$item = "codigo";
			$valor = $_POST['editarCodigoOculto'];

			$traerVentaFormateada = SellsModel::mostrarVentas($item, $valor, $tabla);

			/* Condicional para saber si vienen productos editados */ 


			if($_POST['listaProductosVenta'] == "") {

				$listaProductos = $traerVentaFormateada['productos'];
				$cambioProducto = false;

			} else {

				$listaProductos = $_POST['listaProductosVenta']; 
				$cambioProducto = true;

			}

			if($cambioProducto) {

				$productosFormateados = json_decode($traerVentaFormateada['productos'], true); 

				$totalProductosCompradosFormateados = array();

				//var_dump($productosFormateados);

					foreach($productosFormateados as $key => $value) {

						array_push($totalProductosCompradosFormateados, $value['cantidad']); 

						$tablaProductoF = "productos";
						$itemF = "id";
						$valorF = $value['id'];
						$orden = "id";

						$traerProductoF = ProductsModel::mostrarProductos($itemF, $valorF, $tablaProductoF, $orden);

						$itemIdF = $value['id'];
						$itemVentaF = "ventas";
						$valorVentaF =  $traerProductoF['ventas'] - $value['cantidad'] ;

						$actualizarVentaF = ProductsModel::editarVentaProducto($itemIdF, $itemVentaF, $valorVentaF, $tablaProductoF); 

						$itemStockF = "stock";
						$valorStockF = $value['cantidad'] + $traerProductoF['stock']; 


						$actualizarStockF = ProductsModel::editarVentaProducto($itemIdF, $itemStockF, $valorStockF, $tablaProductoF);


					}

					$tablaClienteF = "clientes";

					$itemClienteF = "id";
					$datosClienteF =  $_POST['editarSeleccionarCliente'];

					$traerClienteF = ClientsModel::mostrarIdCliente($datosClienteF, $itemClienteF, $tablaClienteF);

					$itemClienteFormateado = "total_compras";
					$valorClienteFormateado = $traerClienteF['total_compras'] - array_sum($totalProductosCompradosFormateados); 

					$actualizarCompraCliente = ClientsModel::actualizarCompraCliente($datosClienteF, $itemClienteFormateado, $valorClienteFormateado, $tablaClienteF);

				/* Finaliza formateado de tablas */ 


					$listaProductosFinal = json_decode($listaProductos, true); 
					$totalProductosComprados = array();

					foreach($listaProductosFinal as $key => $value) {

						array_push($totalProductosComprados, $value['cantidad']); 

						$tablaProducto = "productos";
						$item = "id";
						$valor = $value['id'];
						$orden = "id";

						$traerProducto = ProductsModel::mostrarProductos($item, $valor, $tablaProducto, $orden);

						$item1 = $value['id'];
						$item2 = "ventas";
						$valor2 = $value['cantidad'] + $traerProducto['ventas'];

						$actualizarVenta = ProductsModel::editarVentaProducto($item1, $item2, $valor2, $tablaProducto); 

						$itemStock = "stock";
						$valorStock = $value['stockFinal']; 


						$actualizarStock = ProductsModel::editarVentaProducto($item1, $itemStock, $valorStock, $tablaProducto);


					}

					$tablaCliente = "clientes";

					$item = "id";
					$datos =  $_POST['editarSeleccionarCliente'];

					$traerCliente = ClientsModel::mostrarIdCliente($datos, $item, $tablaCliente);

					$itemCliente = "total_compras";
					$valorCliente = array_sum($totalProductosComprados) + $traerCliente['total_compras'] ; 

					$actualizarCompraCliente = ClientsModel::actualizarCompraCliente($datos, $itemCliente, $valorCliente, $tablaCliente);

					date_default_timezone_set('America/Mexico_City');

					$fecha = date('Y-m-d');
				    $hora = date("H:i:s");

				    $fechaActual = $fecha. ' ' .$hora;

					$itemUltimaCompra = "ultima_compra";
					$valorUltimaCompra = $fechaActual;

					$ultimaCompraCliente = ClientsModel::actualizarCompraCliente($datos, $itemUltimaCompra, $valorUltimaCompra, $tablaCliente);

			}
			/* fin de la sección */ 

			/* Guardar la Compra */ 

			 $datos = array(
				"codigo" 		=> $_POST['editarCodigoOculto'],
				"id_cliente" 	=> $_POST['editarSeleccionarCliente'],
				"id_vendedor" 	=> $_POST['editarIdVendedor'],
				"productos"     => $listaProductos,
				"impuesto"		=> $_POST['editarPrecioImpuesto'],
				"neto"			=> $_POST['editarPrecioNeto'],
				"total_venta"   => $_POST['editarRealTotalVenta'],
				"metodo_pago"   => $_POST['editarListaMetodoPago']
			);

			$respuesta = SellsModel::editarVenta($tabla, $datos);

			//var_dump($respuesta);

			if($respuesta == 'ok') {
					echo '<script>
							swal({
								type : "success",
								title: "La compra  fue editada con éxito",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result) => {
								if(result.value) {
									window.location = "ventas";
								}
							})
						</script>';
				}

		}


		
	} // fin del método 

	public function eliminarVenta() {

		if(isset($_GET['idVenta'])) {

			$tabla = "ventas";
			$id = $_GET['idVenta'];

			// Actualizar la última hora de compra del cliente

			$item = "id";
			$valor = $id;


			$traerVenta = SellsModel::mostrarVentas($item, $valor, $tabla);

			// Traer todas las ventas

			$itemTodasVentas = null;
			$valorTodasVentas = null;

			$traerTodasVentas = SellsModel::mostrarVentas($itemTodasVentas, $valorTodasVentas, $tabla);

			$guardarFechas = array();

			$tablaCliente = "clientes";

			foreach($traerTodasVentas as $key => $value) {

				if($value['id_cliente'] == $traerVenta['id_cliente']) {

					array_push($guardarFechas, $value['fecha']);

				}

			}

			if(count($guardarFechas) > 1) {

				if($traerVenta['fecha'] > $guardarFechas[count($guardarFechas) - 2]) {

					//var_dump($guardarFechas[0]) también se puede ejemplificar con esta forma y no con el - 2;

					$itemActualizarCompra = "ultima_compra";
					$valorActualizarCompra = $guardarFechas[count($guardarFechas) - 2];

					$idCliente = $traerVenta['id_cliente'];

					$actualizarCompraCliente = ClientsModel::actualizarCompraCliente($idCliente, $itemActualizarCompra, $valorActualizarCompra, $tablaCliente); 

				} else {

					$itemActualizarCompra = "ultima_compra";
					$valorActualizarCompra = $guardarFechas[count($guardarFechas) - 1];

					$idCliente = $traerVenta['id_cliente'];

					$actualizarCompraCliente = ClientsModel::actualizarCompraCliente($idCliente, $itemActualizarCompra, $valorActualizarCompra, $tablaCliente);

				}


			} else {

				$itemActualizarCompra = "ultima_compra";
				$valorActualizarCompra = "0000-00-00 00:00:00";

				$idCliente = $traerVenta['id_cliente'];

				$actualizarCompraCliente = ClientsModel::actualizarCompraCliente($idCliente, $itemActualizarCompra, $valorActualizarCompra, $tablaCliente);

			}

			// Actualizar tabla productos 

			$productosActualizados = json_decode($traerVenta['productos'], true); 

				$totalProductosCompradosActualizados = array();

				//var_dump($productosFormateados);

					foreach($productosActualizados as $key => $value) {

						array_push($totalProductosCompradosActualizados, $value['cantidad']); 

						$tablaProductoF = "productos";
						$itemF = "id";
						$valorF = $value['id'];
						$orden = "id";

						$traerProductoF = ProductsModel::mostrarProductos($itemF, $valorF, $tablaProductoF, $orden);

						$itemIdF = $value['id'];
						$itemVentaF = "ventas";
						$valorVentaF =  $traerProductoF['ventas'] - $value['cantidad'] ;

						$actualizarVentaF = ProductsModel::editarVentaProducto($itemIdF, $itemVentaF, $valorVentaF, $tablaProductoF); 

						$itemStockF = "stock";
						$valorStockF = $value['cantidad'] + $traerProductoF['stock']; 


						$actualizarStockF = ProductsModel::editarVentaProducto($itemIdF, $itemStockF, $valorStockF, $tablaProductoF);


					}

					$tablaClienteF = "clientes";

					$itemClienteF = "id";
					$datosClienteF =  $traerVenta['id_cliente'];

					$traerClienteF = ClientsModel::mostrarIdCliente($datosClienteF, $itemClienteF, $tablaClienteF);

					$itemClienteFormateado = "total_compras";
					$valorClienteFormateado = $traerClienteF['total_compras'] - array_sum($totalProductosCompradosActualizados); 

					$actualizarCompraCliente = ClientsModel::actualizarCompraCliente($datosClienteF, $itemClienteFormateado, $valorClienteFormateado, $tablaClienteF);

			// Petición al Modelo para eliminar venta

			$respuesta = SellsModel::eliminarVenta($id, $tabla);

			if($respuesta == 'ok') {
            echo '<script>
                swal({
                  type : "success",
                  title: "La venta fue eliminada con éxito",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar",
                  closeOnConfirm: false
                }).then((result) => {
                  if(result.value) {
                    window.location = "ventas";
                  }
                })
              </script>';
        	} 

		} 


	} // fin del método


	static public function codigoImprimir($item, $valor, $tabla) {


		$respuesta = SellsModel::mostrarVentas($item, $valor, $tabla);

		return $respuesta;



	} // fin del método 

	static public function rangoFechas($fechaInicial, $fechaFinal) {

		$tabla = "ventas"; 

		$respuesta = SellsModel::rangoFechas($fechaInicial, $fechaFinal, $tabla);
		return $respuesta; 


	}

	public function descargarReporte() {

		if(isset($_GET['reporte'])) {

			$tablaCliente = "clientes";
			$tablaVendedor = "usuarios";
			$tabla = "ventas";

			if(isset($_GET['fechaInicial']) && isset($_GET['fechaFinal'])) {

				$fechaInicial = $_GET['fechaInicial'];
				$fechaFinal = $_GET['fechaFinal'];

				$ventas = SellsModel::rangoFechas($fechaInicial, $fechaFinal, $tabla);

			} else {

				$item = null;
				$valor = null;

               	$ventas = SellsModel::mostrarVentas($item, $valor, $tabla); 	

			}

			/* Descargar Excel */ 

			$nombreArchivo = $_GET['reporte'].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel");
			header("Cache-Control: cache, must-revalidate");
			header('Content-Description: FileTransfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public");
			header('Content-Disposition:; filename="'.$nombreArchivo.'"');
			header("Content-Transfer-Encoding: binary");

			echo utf8_decode("<table border='0'>
								<tr>
									<td style='font-weight: bold; border: 1px solid #eee;'>CÓDIGO</td>
									<td style='font-weight: bold; border: 1px solid #eee;'>CLIENTE</td>
									<td style='font-weight: bold; border: 1px solid #eee;'>VENDEDOR</td>
									<td style='font-weight: bold; border: 1px solid #eee;'>CANTIDAD</td>
									<td style='font-weight: bold; border: 1px solid #eee;'>PRODUCTOS</td>
									<td style='font-weight: bold; border: 1px solid #eee;'>IMPUESTO</td>
									<td style='font-weight: bold; border: 1px solid #eee;'>NETO</td>
									<td style='font-weight: bold; border: 1px solid #eee;'>TOTAL</td>
									<td style='font-weight: bold; border: 1px solid #eee;'>MÉTODO DE PAGO</td>
									<td style='font-weight: bold; border: 1px solid #eee;'>FECHA</td>
								</tr>");

			foreach($ventas as $row => $item) {

				$valorCliente = $item['id_cliente'];
				$valorVendedor = $item['id_vendedor'];

				$cliente = SellsModel::mostrarClientes("id", $valorCliente, $tablaCliente);
				$vendedor = SellsModel::mostrarVendedor("id", $valorVendedor, $tablaVendedor);

				echo utf8_decode("<tr>
									<td style='border: 1px solid #eee;'>".$item["codigo"]."</td>
									<td style='border: 1px solid #eee;'>".$cliente["nombre"]."</td>
									<td style='border: 1px solid #eee;'>".$vendedor["nombre"]."</td>
									<td style='border: 1px solid #eee;'>");
				$productos = json_decode($item['productos'], true);
				foreach($productos as $key => $valueProductos) {

					echo utf8_decode($valueProductos["cantidad"]."<br>");

				}

				echo utf8_decode("</td><td style='border: 1px solid #eee;'>");
				foreach($productos as $key => $valueProductos) {

					echo utf8_decode($valueProductos["descripcion"]."<br>");

				}

				echo utf8_decode("	</td>
									<td style='border: 1px solid #eee;'>".number_format($item["impuesto"], 2)."</td>
									<td style='border: 1px solid #eee;'>".number_format($item["neto"], 2)."</td>
									<td style='border: 1px solid #eee;'>".number_format($item["total_venta"], 2)."</td>
									<td style='border: 1px solid #eee;'>".$item["metodo_pago"]."</td>
									<td style='border: 1px solid #eee;'>".substr($item["metodo_pago"], 0, 10)."</td>
								</tr>");

			}

			echo utf8_decode("</table>");
		}

	} // fin del método

	static public function conteoNetoVentas() {

		$tabla = "ventas";

		$respuesta = SellsModel::conteoNetoVentas($tabla);

		return $respuesta;

	}



}