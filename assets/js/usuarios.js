/* Cambiar imagen de perfil al momento de agregar usuario */ 

$('.nuevaFoto').on('change', function(){

	var imagen = this.files[0] // propiedad que funciona en inputs de tipo file
	console.log(imagen)
	var formato = imagen["type"]
	var imageSize = imagen["size"];

	if(formato != "image/jpeg" && formato != "image/png") {

		$(".nuevaFoto").val("")
		swal({
			title: "Error al subir imagen",
			type : "error",
			text: "Formato de imagen no permitido",
			confirmButtonText: "Cerrar",
		})
	} else if (imageSize > 2000000 ) {
		$(".nuevaFoto").val("")
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

/* Editar Usuario con Ajax */ 

$(document).on('click', ".btnEditarUsuario", function(){

	var idUsuario = $(this).attr("idUsuario");

	var datos = new FormData();
	datos.append("idUsuario", idUsuario);

	$.ajax({
		url: "ajax/usuarios.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(response) {
			console.log(response);
			$('#editarNombre').val(response["nombre"]) 
			$('#editarUsuario').val(response["usuario"]) 
			$('#editarPerfil').html(response["perfil"])
			$('#editarPerfil').val(response["perfil"])
			$('#fotoActual').val(response["foto"])
			$('#passwordActual').val(response["pass"])
			if(response["foto"] != "") {
				$('#editarFoto').attr("src", response["foto"])
			}
			
		}
	})

})

/* Activar estado de usuario */ 

$(document).on('click', '.btnActivar', function(){

	var idUsuarioEstado = $(this).attr('id')
	var estadoUsuario = $(this).attr('estado')

	console.log(idUsuarioEstado, estadoUsuario)

	var datosUsuario = new FormData();
	datosUsuario.append('idUsuarioEstado', idUsuarioEstado)
	datosUsuario.append('estadoUsuario', estadoUsuario)

	$.ajax({
		url: 'ajax/usuarios.php',
		type: 'POST',
		data: datosUsuario,
		cache: false,
		contentType: false,
		processData: false,
		success: function(response) {
			if(window.matchMedia("(max-width:767px)").matches) {

				swal({
					type : "success",
					title: "El Usuario fue actualizado con éxito",
					showConfirmButton: true,
					confirmButtonText: "Cerrar",
					closeOnConfirm: false
					}).then((result) => {
						if(result.value) {
							window.location = "usuarios";
						}
				})

			}
		}

	})

	if(estadoUsuario == 0) {

		$(this).removeClass("btn-success").addClass("btn-danger").html('Desactivado').attr("estado", 1); 

	} else {

		$(this).removeClass("btn-danger").addClass("btn-success").html('Activado').attr("estado", 0); 

	}
	

})

// Detectar si un nombre de usuario ya existe 



$('#nuevoUsuario').on('change', function(){

	$('.alert').remove();

	var usuario = $(this).val();

	console.log(usuario);

	var nombreUsuario = new FormData();
	nombreUsuario.append("usuario", usuario);
		$.ajax({
			url: 'ajax/usuarios.php',
			type: 'POST',
			data: nombreUsuario,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(response) {
				console.log(response);
				if(response) {
					$('#nuevoUsuario').parent().after('<div class="alert alert-danger">Este nombre de usuario ya existe</div>');
					$('#nuevoUsuario').val(" ");
				}
				
			}
			
		})
	
})

/* Eliminar Usuario */ 

$(document).on('click', ".btnEliminarUsuario", function(){

	var idUsuario = $(this).attr("idUsuario");
	var fotoUsuario = $(this).attr("fotoUsuario");
	var nombreUsuario = $(this).attr("nombreUsuario");

	swal({
			title: "¿Estás seguro que quieres eliminar al usuario?",
			text: "Si es así, presiona aceptar",
			type : "warning",
			showCancelButton: true,
			confirmButtonText: "Aceptar",
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar"
		}).then(function(result)  {
			if(result.value) {

				window.location = "index.php?ruta=usuarios&idUsuario="+ idUsuario +"&fotoUsuario="+ fotoUsuario + "&nombreUsuario="+ nombreUsuario; 

			}

		})

})