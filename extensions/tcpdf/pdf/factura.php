<?php

require_once "../../../controllers/SellsController.php";
require_once "../../../models/SellsModel.php";

require_once "../../../controllers/ProductsController.php";
require_once "../../../models/ProductsModel.php";


class ImprimirFactura  {

public $codigo;

public function imprimirVentaPos() {

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setFontSubsetting(true);

$pdf->SetFont('dejavusans', '', 11, '', true);

$pdf->startPageGroup();

$pdf->AddPage();

$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

$codigoVenta = $this->codigo;

$item = 'codigo'; 
$valor = $this->codigo;

$tabla = 'ventas';

$respuesta = SellsController::codigoImprimir($item, $valor, $tabla);

// Información del cliente 

$itemCliente = "id";
$valorCliente = $respuesta['id_cliente'];

$respuestaCliente = SellsController::mostrarClientes($itemCliente, $valorCliente);

$nombreCliente = $respuestaCliente['nombre'];


// Información del vendedor}

$itemVendedor = "id";
$valorVendedor = $respuesta['id_vendedor'];

$respuestaVendedor = SellsController::mostrarVendedor($itemVendedor, $valorVendedor);

$nombreVendedor = $respuestaVendedor['nombre'];


$bloque1 = <<<EOF

	<table style="margin-bottom: 50px;">
		<tr>

			<td style="width: 150px"><img src="images/logo-negro-bloque.png"></td>
			<td style="background-color: white; width: 140px;">
				<div style="font-size:8.5px; text-align: right; line-height: 15px;">
					<br>
					NIT: 71.759.962-9
					<br>
					Dirección: Calle 44B 92-11
				</div>
			</td>

			<td style="background-color: white; width: 140px;">
				<div style="font-size:8.5px; text-align: right; line-height: 15px;">
					<br>
					Teléfono: 300 786 52 49
					<br>
					ventas@inventorysystem.com
				</div>
			</td>

			<td style="background-color: white; width: 110px; text-align: center; color: red">
				<br>
				<br>
				FACTURA N.<br>
				$codigoVenta
			</td>

		</tr>
	</table>



EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$fecha = substr($respuesta["fecha"], 0, -8);
$productos = json_decode($respuesta["productos"], true);
$neto = number_format($respuesta["neto"], 2);
$impuesto = number_format($respuesta["impuesto"], 2);
$total = number_format($respuesta["total_venta"], 2);



$bloque2 = <<<EOF
	
	<table style="margin-top: 20px; padding: 10px 10px; font-size:10px">
		<tr>
			<td style="border: 1px solid #666; backgroud-color:white; width: 390px">
				Cliente: $nombreCliente
			</td>
			<td style="border: 1px solid #666; backgroud-color:white; width: 150px">
				Fecha: $fecha
			</td>
		</tr>
		<tr>
			<td style="border: 1px solid #666; backgroud-color:white; width: 540px">
				Vendedor: $nombreVendedor
			</td>
		</tr>
		<tr>
			<td style="border: none; backgroud-color:white; width: 540px"></td>
		</tr>
					
	</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, ''); 	

$bloque3 = <<<EOF

	<table style="font-size: 10px; padding: 10px 10px;">

		<tr>
			<td style="border: 1px solid #666; background-color:white; width: 260px; text-align: center">Producto</td>
			<td style="border: 1px solid #666; background-color:white; width: 80px; text-align: center">Cantidad</td>
			<td style="border: 1px solid #666; background-color:white; width: 100px; text-align: center">Valor Unitario</td>
			<td style="border: 1px solid #666; background-color:white; width: 100px; text-align: center">Valor Total</td>
		</tr>

	</table>



EOF;

$pdf->writeHTML($bloque3, false, false, false, false, ''); 	

foreach($productos as $key => $item) {

$tablaProducto = "productos";
$itemProducto = "descripcion";
$valorProducto = $item['descripcion'];
$orden = "id";

$traerProducto = ProductsModel::mostrarProductos($itemProducto, $valorProducto, $tablaProducto, $orden);

$valorUnitario = number_format($item['precio'], 2);
$valorTotal = number_format($item['total'], 2);

$bloque4 = <<<EOF

	<table style="font-size: 10px; padding: 10px 10px;">

		<tr>
			<td style="border: 1px solid #666; background-color:white; width: 260px; text-align: center">$item[descripcion]</td>
			<td style="border: 1px solid #666; background-color:white; width: 80px; text-align: center"> $item[cantidad]</td>
			<td style="border: 1px solid #666; background-color:white; width: 100px; text-align: center">$ $valorUnitario</td>
			<td style="border: 1px solid #666; background-color:white; width: 100px; text-align: center">$ $valorTotal</td>
		</tr>

	</table>



EOF;

$pdf->writeHTML($bloque4, false, false, false, false, ''); 


}

$bloque5 = <<<EOF

	<table style="font-size: 10px; padding: 10px 10px;">
		
		<tr>
			<td style="color: #333; backgroud-color:white; width: 340px"></td>
			<td style="border-bottom: 1px solid #666; background-color:white; width: 100px; text-align: center"></td>
			<td style="border-bottom: 1px solid #666; background-color:white; color: #333; width: 100px; text-align: center"></td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #666; color: #333; background-color:white; width: 340px; text-align:center"></td>
			<td style="border: 1px solid #666; background-color:white; width: 100px; text-align: center">Neto: </td>
			<td style="border: 1px solid #666; background-color:white; width: 100px; text-align: center">$ $neto</td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #666; color: #333; background-color:white; width: 340px; text-align:center"></td>
			<td style="border: 1px solid #666; background-color:white; width: 100px; text-align: center">Impuesto: </td>
			<td style="border: 1px solid #666; background-color:white; width: 100px; text-align: center">$ $impuesto</td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #666; color: #333; background-color:white; width: 340px; text-align:center"></td>
			<td style="border: 1px solid #666; background-color:white; width: 100px; text-align: center">Total: </td>
			<td style="border: 1px solid #666; background-color:white; width: 100px; text-align: center">$ $total</td>
		</tr>

	</table>



EOF;

$pdf->writeHTML($bloque5, false, false, false, false, ''); 

	



$pdf->Output('factura.pdf');



} // fin del método


}

$imprimirVentaPos = new ImprimirFactura();
$imprimirVentaPos->codigo = $_GET['cVenta'];
$imprimirVentaPos->imprimirVentaPos();


?>






