// Eliminar Categoría 

$(document).on('click', '.btnEditarCategoria', function(){

	var idCategoria = $(this).attr("idCategoria")

	console.log(idCategoria)

	var datos = new FormData()
	datos.append('idCategoria', idCategoria)

	$.ajax({
		url: "ajax/categorias.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(response) {
			console.log(response);
			$('#editarCategoria').val(response["categoria"]) 
			$('#idCategoria').val(response["id"])
		}
	})

})

// Eliminar Categoría

$(document).on('click', '.btnEliminarCategoria', function(){

	var idCategoria = $(this).attr("idCategoria")

	console.log(idCategoria)

	swal({
			title: "¿Estás seguro que quieres eliminar la categoria?",
			text: "Si es así, presiona aceptar",
			type : "warning",
			showCancelButton: true,
			confirmButtonText: "Aceptar",
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar"
		}).then(function(result)  {
			if(result.value) {

				window.location = "index.php?ruta=categorias&idCategoria="+ idCategoria; 

			}

		})


})
