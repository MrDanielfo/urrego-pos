
$(document).on('click', '.btnImprimirVenta', function() {

	var codigoVenta = $(this).attr("codigoVenta")

	window.open("extensions/tcpdf/pdf/factura.php?cVenta="+codigoVenta, "_blank")
})
