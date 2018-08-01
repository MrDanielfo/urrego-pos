$(document).ready(function(){

	// Editar Cliente con Ajax
	// Mostrar IdCliente 

	$(".btnEditarCliente").on('click', function(){

	var idCliente = $(this).attr("idCliente");

	var datos = new FormData();
	datos.append("idCliente", idCliente);

		$.ajax({
			url: "ajax/clientes.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(response) {
				console.log(response);
				$('#editarIdCliente').val(response["id"]) 
				$('#editarNombreCliente').val(response["nombre"]) 
				$('#editarDniCliente').val(response["identificacion"]) 
				$('#editarEmailCliente').val(response["email"])
				$('#editarTelefonoCliente').val(response["telefono"])
				$('#editarDireccionCliente').val(response["direccion"])
				$('#editarNacimientoCliente').val(response["fecha_nacimiento"])
				
				
			}
		})

	}) // fin editar Cliente con Ajax

	// Borrar Cliente

	$('.btnEliminarCliente').on('click', function(){

		var idCliente = $(this).attr("idCliente");

	swal({
			title: "¿Estás seguro que quieres eliminar al cliente?",
			text: "Si es así, presiona aceptar",
			type : "warning",
			showCancelButton: true,
			confirmButtonText: "Aceptar",
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar"
		}).then(function(result)  {
			if(result.value) {

				window.location = "index.php?ruta=clientes&idCliente="+ idCliente; 

			}

		})


	}) // fin de Eliminar Cliente




})