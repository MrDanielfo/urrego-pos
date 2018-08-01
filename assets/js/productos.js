/* Cargar la tabla de productos desde Ajax */ 

//var productos = new FormData();

/*$.ajax({
	url: 'ajax/datatable-productos.php',
	//type: 'POST',
	//dataType: 'json',
	//data: productos,
	success: function(response) {
		//console.log(response)
	}

})*/ 

var perfilOculto = $('#perfilOculto').val();

/* Esto porque la variable de SESSION no se puede pasar tal cual en Ajax */ 


$('.tablaProductos').DataTable({
	"ajax" : "ajax/datatable-productos.php?perfil="+perfilOculto,
	"deferRender" : true,
	"retrieve" : true,
	"processing" : true
})

// capturando la categoria 

$('#nuevaCategoria').on('change', function(){

	var idCategoria = $(this).val();
	console.log(idCategoria)

	var datos = new FormData();
	datos.append('idCategoria', idCategoria);
	$.ajax({
		url: 'ajax/productos.php',
		type: 'POST',
		dataType: 'json',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(response) {

			if(!response) {
				var nuevoCodigo = idCategoria + "01"; 
				$('#nuevoCodigo').val(nuevoCodigo);
			} else {
				var nuevoCodigo = Number(response['codigo']) + 1;
				$('#nuevoCodigo').val(nuevoCodigo);
			}

			

			console.log(nuevoCodigo); 
		}
	})
	
})

// agregando precio de compra 

$('#nuevoCompra, #editarPrecioCompra').on('change', function(){

	if($('.porcentaje').prop("checked")) {

		var valorPorcentaje = $('.nuevoPorcentaje').val();
		console.log(valorPorcentaje);

		var porcentaje = Number(($('#nuevoCompra').val() * valorPorcentaje / 100 )) + Number($('#nuevoCompra').val());
		console.log(porcentaje)
		var editarPorcentaje = Number(($('#editarPrecioCompra').val() * valorPorcentaje / 100 )) + Number($('#editarPrecioCompra').val());

		$('#nuevoVenta').val(porcentaje)
		$('#nuevoVenta').prop("readonly", true)

		$('#editarPrecioVenta').val(editarPorcentaje)
		$('#editarPrecioVenta').prop("readonly", true)

	}

})

// Cambio de Porcentaje 
 
$('.nuevoPorcentaje').on('change', function(){

	if($('.porcentaje').prop("checked")) {

		var valorPorcentaje = $(this).val();
		

		var porcentaje = Number(($('#nuevoCompra').val() * valorPorcentaje / 100 )) + Number($('#nuevoCompra').val());
		var editarPorcentaje = Number(($('#editarPrecioCompra').val() * valorPorcentaje / 100 )) + Number($('#editarPrecioCompra').val());

		$('#nuevoVenta').val(porcentaje)
		$('#nuevoVenta').prop("readonly", true)

		$('#editarPrecioVenta').val(editarPorcentaje)
		$('#editarPrecioVenta').prop("readonly", true)

	}

	
})


$('.porcentaje').on("ifUnchecked", function(){

	$('#nuevoVenta').prop("readonly", false)
	$('#editarPrecioVenta').prop("readonly", false)

})

$('.porcentaje').on("ifChecked", function(){

	$('#nuevoVenta').prop("readonly", true)
	$('#editarPrecioVenta').prop("readonly", true)

}) 

// Imagen de Producto

/* Cambiar imagen de perfil al momento de agregar usuario */ 

$('.nuevaImagen').on('change', function(){

	var imagen = this.files[0] // propiedad que funciona en inputs de tipo file
	console.log(imagen)
	var formato = imagen["type"]
	var imageSize = imagen["size"];

	if(formato != "image/jpeg" && formato != "image/png") {

		$(".nuevaImagen").val("")
		swal({
			title: "Error al subir imagen",
			type : "error",
			text: "Formato de imagen no permitido",
			confirmButtonText: "Cerrar",
		})
	} else if (imageSize > 2000000 ) {
		$(".nuevaImagen").val("")
		swal({
			title: "Error al subir imagen",
			type : "error",
			text: "El tamaño de la imagen excede los 2 MB",
			confirmButtonText: "Cerrar",
		})
	} else {
		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);

		$(datosImagen).on("load", function(event){
			var rutaImagen = event.target.result;

			$('.previsualizar').attr("src", rutaImagen)
		})
	}

})

// Editar Producto 

$('.tablaProductos tbody').on('click', 'button.btnEditarProducto', function(){


	var idProducto = $(this).attr("idproducto")

	var datos = new FormData();

	datos.append('idProducto', idProducto)

	$.ajax({
		url: 'ajax/productos.php',
		type: 'POST',
		dataType: 'json',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(response) {

			var datosCategoria = new FormData();
			datosCategoria.append('idCategoria', response['id_categoria']);

			// Segundo llamado de Ajax para la categoría 

			$.ajax({
				url: 'ajax/categorias.php',
				type: 'POST',
				dataType: 'json',
				data: datosCategoria,
				cache: false,
				contentType: false,
				processData: false,
				success: function(response) {

					$('#editarCategoriaProducto').val(response['id'])
					$('#editarCategoriaProducto').html(response['categoria'])

				}
			})

			$('#editarCodigo').val(response['codigo'])
			$('#editarDescripcion').val(response['descripcion'])
			$('#editarStock').val(response['stock'])
			$('#editarPrecioCompra').val(response['precio_compra'])
			$('#editarPrecioVenta').val(response['precio_venta'])

			if(response['imagen'] != " ") {

				$('#imagenActual').val(response['imagen'])
				$('.previsualizar').attr("src", response['imagen'])

			} else {


			}




		}
	})

})

// Eliminar Producto

$(document).on('click', ".btnEliminarProducto", function(){

	var idProducto = $(this).attr("idProducto");
	var fotoProducto = $(this).attr("fotoProducto");
	var codigoProducto = $(this).attr("codigoProducto");

	swal({
			title: "¿Estás seguro que quieres eliminar el producto?",
			text: "Si es así, presiona aceptar",
			type : "warning",
			showCancelButton: true,
			confirmButtonText: "Aceptar",
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar"
		}).then(function(result)  {
			if(result.value) {

				window.location = "index.php?ruta=productos&idProducto="+ idProducto +"&fotoProducto="+ fotoProducto + "&codigoProducto="+ codigoProducto; 
			}

		})

})


