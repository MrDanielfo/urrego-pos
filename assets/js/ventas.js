/* Cargar la tabla de productos desde Ajax */ 

/* $.ajax({
	url: 'ajax/datatable-ventas.php',
	type: 'POST',
	dataType: 'json',
	success: function(response) {
		console.log(response)
	}

}) */ 


	$('.tablaVentas').DataTable({
		"ajax" : "ajax/datatable-ventas.php",
		"deferRender" : true,
		"retrieve" : true,
		"processing" : true
	})

	/* Agregar Productos a la venta desde la tabla */ 


	$(".tablaVentas tbody").on("click", "button.btnAgregarProducto", function(){

		idProducto = $(this).attr("idProducto")

		$(this).removeClass("btn-primary btnAgregarProducto");
		$(this).addClass("btn-default")

		var datos = new FormData();
		datos.append("idProducto", idProducto)

		$.ajax({
			url: 'ajax/productos.php',
			type: 'POST',
			dataType: 'json',
			data: datos,
			contentType: false,
			processData: false,
			cache: false,
			success: function(response) {
				var descripcion = response['descripcion'];
				var stock = response['stock'];
				var precio = response['precio_venta']; 

				// Evitar agregar producto cuando el stock está en CERO

				if(stock == 0) {

					swal({
						title: "No hay stock disponible",
						type : "error",
						confirmButtonText: "Cerrar"
					})

					var botonsinStock = $("button.recuperarBoton[idProducto="+ idProducto + "]")
						botonsinStock.addClass("btn-danger btnAgregarProducto")

						return; 
				}

				$('.nuevoProducto').append('<div class="row" style="padding: 5px 15px">' +
												'<div class="col-xs-6" style="padding-right: 0px">' + 
		                        
			                        				'<div class="input-group">' +
			                            
				                            			'<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+ response['id']  +'"><i class="fa fa-times"></i></button></span>' +

				                            			'<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+ response['id']  +'" name="agregarProducto"  value="'+ descripcion +'" readonly required>' +

		                                            '</div>' + 

		                      					'</div>' + 

						                        '<div class="col-xs-3">' +
						                          
						                            '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1"  stock="'+ stock +'" nuevoStock="'+ Number(stock - 1 ) +'" required>' + 

						                        '</div>' +

						                        '<div class="col-xs-3 ingresoPrecio" style="padding-left: 0px">' +

							                        '<div class="input-group">' +

							                          '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
							                          '<input type="text" class="form-control nuevoPrecioProducto" name="nuevoPrecioProducto" precioReal="'+ precio +'" value="'+ precio +'" readonly required>' +

							                        '</div>' +
		                        
		                                        '</div>' +
	                                        '</div>')
				// sumar total de Precio
				sumarTotalPrecios()
				agregarImpuesto()
				listarProductos()
				// poner formato de jquery Number
				$('.nuevoPrecioProducto').number(true, 2)
			}
		})
		
		
	})

	/* Quitar Productos de la Venta y recuperar botón CUANDO SE NAVEGUE en la tabla */ 

	// Sección LocalStorage //

	/* $('.tablaVentas').on("draw.dt", function(){

		if(localStorage.getItem("quitarProducto") != null)  {

			var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto")); 

			for(var i = 0; i < listaIdProductos.length; i++ ) {

				var botonStorage = $("button.recuperarBoton[idProducto="+listaIdProductos[i]["idProducto"]+"]")
					botonStorage.removeClass("btn-default")
					botonStorage.addClass("btn-primary btnAgregarProducto")

			}

		} else {

			

		}


	}) */ 

	// definiendo IdQuitarProducto

	/* var idQuitarProducto = [];

	localStorage.removeItem("quitarProducto"); */ 


	$('.formularioVenta').on('click', 'button.quitarProducto', function(){

		$(this).parent().parent().parent().parent().remove();
		var idProducto = $(this).attr("idProducto")
		console.log(idProducto)
		// Almacenar en el localStorage el Id del Producto a quitar

		/*if(localStorage.getItem("quitarProducto") == null)  {

			idQuitarProducto = [];

		} else {

			idQuitarProducto.concat(localStorage.getItem("quitarProducto"))

		}

		idQuitarProducto.push({
			"idProducto" : idProducto
		})

		localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto))*/ 


		// Fin de almacenamiento
		var botonRecuperado = $("button.recuperarBoton[idProducto="+ idProducto + "]")

		botonRecuperado.removeClass("btn-default")
		botonRecuperado.addClass("btn-primary btnAgregarProducto")

		

		if($(".nuevoProducto").children().length == 0) {

			$('#nuevoImpuestoVenta').val(0)
			$('#nuevoTotalVenta').val(0)
			$('#realTotalVenta').val(0)
			$('#nuevoTotalVenta').attr("total", 0)

		} else {

			// sumar total de Precio
			sumarTotalPrecios()
			agregarImpuesto()
			listarProductos()

		}


	})

	// Agregar Producto desde dispositivos 

	var numProductos = 0;

	$('.btnAgregarProductoResponsive').on('click', function(){

		numProductos++;

		var datos = new FormData();
		datos.append("traerProductos", "ok"); 

			$.ajax({
			url: 'ajax/productos.php',
			type: 'POST',
			dataType: 'json',
			data: datos,
			contentType: false,
			processData: false,
			cache: false,
			success: function(response) {
				$('.nuevoProducto').append('<div class="row" style="padding: 5px 15px">' +
												'<div class="col-xs-6" style="padding-right: 0px">' + 
		                        
			                        				'<div class="input-group">' +
			                            
				                            			'<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>' +

				                            			'<select class="form-control nuevaDescripcionProducto" id="producto'+ numProductos +'" idProducto name="nuevaDescripcionProducto" required>' +

				                            				'<option>Seleccione el Producto</option>' +

				                            			'</select>' +

		                                            '</div>' + 

		                      					'</div>' + 

						                        '<div class="col-xs-3 ingresoCantidad">' +
						                          
						                            '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock  nuevoStock  required>' + 

						                        '</div>' +

						                        '<div class="col-xs-3 ingresoPrecio" style="padding-left: 0px">' +

							                        '<div class="input-group">' +

							                          '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
							                          '<input type="text" class="form-control nuevoPrecioProducto" precioReal name="nuevoPrecioProducto" min="1" readonly required>' +

							                        '</div>' +
		                        
		                                        '</div>' +
	                                        '</div>')

				// Agregar productos al select 
				response.forEach(funcionForEach); 

				function funcionForEach(item, index) {

					if(item.stock != 0) {

						$('#producto'+numProductos).append(

									'<option idProducto="' + item.id  +'" value="'+ item.descripcion +'">'+ item.descripcion +'</option>'

														)

					} 
		
				}

			// sumar total de Precio
				sumarTotalPrecios()
				agregarImpuesto()
				listarProductos()
				$('.nuevoPrecioProducto').number(true, 2)


			}


		})


	})

	// Seleccionar Producto 

	$('.formularioVenta').on('change', 'select.nuevaDescripcionProducto', function(){

		var idProducto = $(this)
		var nombreProducto = $(this).val();

		var nuevaDescripcionProducto = $(this).parent().parent().parent().children().children().children('.nuevaDescripcionProducto')

		var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children('.nuevoPrecioProducto')

		var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children('.nuevaCantidadProducto')

		var datos = new FormData();
		datos.append("nombreProducto", nombreProducto)

		$.ajax({
			url: 'ajax/productos.php',
			type: 'POST',
			dataType: 'json',
			data: datos,
			contentType: false,
			processData: false,
			cache: false,
			success: function(response) {
				nuevaDescripcionProducto.attr("idProducto", response["id"] )
				nuevaCantidadProducto.attr("stock", response["stock"]);
				nuevaCantidadProducto.attr("nuevoStock", Number(response["stock"]) - 1);
				nuevoPrecioProducto.val(response["precio_venta"]);
				nuevoPrecioProducto.attr("precioReal", response['precio_venta'])
			}
		})


	})

	/* Modificar la cantidad de productos a elegir (stock)  */ 

	$('.formularioVenta').on('change', 'input.nuevaCantidadProducto', function(){ 

		 var precio = $(this).parent().parent().children(".ingresoPrecio").children().children('.nuevoPrecioProducto')

		 var precioFinal = $(this).val() * precio.attr("precioReal");

		 precio.val(precioFinal)

		 var stockFinal = Number($(this).attr("stock")) - Number($(this).val())

		 $(this).attr("nuevoStock", stockFinal)

		 if(Number($(this).val()) > Number($(this).attr("stock"))) {

		 	// si la cantidad es superior al stock, regresa los valores iniciales 

		 	$(this).val(1)

		 	var precioReal =  $(this).val() * precio.attr("precioReal")
		 	precio.val(precioReal)

		 	sumarTotalPrecios()

	 		swal({
					title: "No tenemos más unidades en el stock",
					text: "Sólo hay " + $(this).attr("stock") + " unidades",
					type : "error",
					confirmButtonText: "Cerrar"
				})

		 }

			sumarTotalPrecios()
			agregarImpuesto()
			listarProductos()

	})

	/* Sumar todos los precios */ 

	function sumarTotalPrecios() {

		var precioItem = $(".nuevoPrecioProducto")
		var sumaPrecio = [];

		for(var i = 0; i < precioItem.length; i++) {

			sumaPrecio.push(Number($(precioItem[i]).val())) 


		}

		function sumarArrayPrecios(total, numero) {

			return total + numero

		}

		var sumaTotal = sumaPrecio.reduce(sumarArrayPrecios)
		$('#nuevoTotalVenta').val(sumaTotal)
		$('#realTotalVenta').val(sumaTotal)
		$('#nuevoTotalVenta').attr("total", sumaTotal)

	}

	// Agregar impuesto a la venta

	function agregarImpuesto(){

		var impuesto = $('#nuevoImpuestoVenta').val()
		var precioTotal = $('#nuevoTotalVenta').attr("total")

		var precioImpuesto = Number(precioTotal * impuesto / 100)

		var totalConImpuesto = Number(precioImpuesto) + Number(precioTotal)

		$('#nuevoTotalVenta').val(totalConImpuesto)
		$('#realTotalVenta').val(totalConImpuesto)
		$('#nuevoPrecioImpuesto').val(precioImpuesto)
		$('#nuevoPrecioNeto').val(precioTotal)
		$('#nuevoTotalVenta').number(true, 2)

	}

	// Cuando cambia el impuesto

	$('#nuevoImpuestoVenta').on('change', function(){

		agregarImpuesto()

	})

	// Seleccionar método de pago 

	$('#nuevoMetodoPago').on('change', function(){

		var metodo = $(this).val()

		console.log(metodo)

		if(metodo == "Efectivo") {

			$(this).parent().parent().removeClass('col-xs-6').addClass('col-xs-4')

			$(this).parent().parent().parent().children('.cajasMetodoPago').html(
				
				'<div class="col-xs-4">' + 

					'<div class="input-group">' +

						'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' + 
						'<input type="text" class="form-control" id="nuevoValorEfectivo" name="nuevoValorEfectivo" placeholder="00000" required>' +

					'</div>' +

				'</div>' + 

				'<div class="col-xs-4 capturarCambioEfectivo" style="padding-left: 0px">' +

					'<div class="input-group">' +

						'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' + 
						'<input type="text" class="form-control" id="nuevoCambioEfectivo" name="nuevoCambioEfectivo" placeholder="00000" required>' +

					'</div>' +

				'</div>'

				)

			$('#nuevoValorEfectivo').number(true, 2)
			$('#nuevoCambioEfectivo').number(true, 2)
			listarMetodosPago()


		} else {

			$(this).parent().parent().removeClass('col-xs-4').addClass('col-xs-6')

			$(this).parent().parent().parent().children('.cajasMetodoPago').html(
				
				'<div class="col-xs-6" style="padding-left: 0px">' +

	                '<div class="input-group">' +

	                  	'<input type="text" class="form-control" id="nuevoCodigoTransaccion" name="nuevoCodigoTransaccion" placeholder="Código Transacción" required>' +

	                    '<span class="input-group-addon"><i class="fa fa-lock"></i></span>' +

	                '</div>' +
	                        
	            '</div>'

				)

		}

	})

	// Valores en el campo de efectivo 


	$('.formularioVenta').on('change', 'input#nuevoValorEfectivo', function(){ 


		var efectivo = $(this).val()
		var precio = $('#nuevoTotalVenta').val()

		var cambio = Number(efectivo) - Number(precio)

		var nuevoCambioEfectivo = $(this).parent().parent().parent().children('.capturarCambioEfectivo').children().children('#nuevoCambioEfectivo')

		nuevoCambioEfectivo.val(cambio)


	})

	// Valores en el campo de transacción por TC o TD

	$('.formularioVenta').on('change', 'input#nuevoCodigoTransaccion', function(){ 

		listarMetodosPago()
		

	})



	// Listar productos en datos JSON 

	function listarProductos(){

		//var id = $('.agregarProducto').attr('idProducto');

		var listaProductos = [];

		var descripcion = $('.nuevaDescripcionProducto');

		var cantidad = $('.nuevaCantidadProducto');

		var precio = $('.nuevoPrecioProducto');

		var impuesto = $('#nuevoImpuestoVenta')

		// var total = $('.nuevoPrecioProducto').attr('precioReal');

		for (var i = 0; i < descripcion.length; i++) {

			listaProductos.push({

				"id" : 			$(descripcion[i]).attr("idProducto"),
				"descripcion" : $(descripcion[i]).val(),
				"cantidad"	  : $(cantidad[i]).val(),
				"stock"       : $(cantidad[i]).attr("stock"),
				"stockFinal"  : $(cantidad[i]).attr("nuevoStock"),
				"precio"	  : $(precio[i]).attr("precioReal"),
				"total"		  : $(precio[i]).val()

			})

		}

		console.log(listaProductos)

		$('#listaProductosVenta').val(JSON.stringify(listaProductos))


	}

	/* Listar método de pago */

	function listarMetodosPago() {

	    var listaMetodos = "";

	    if ($('#nuevoMetodoPago').val() == "Efectivo") {

	        $('#listaMetodoPago').val("Efectivo")

	    } else {

	        $('#listaMetodoPago').val($('#nuevoMetodoPago').val() + "-" + $('#nuevoCodigoTransaccion').val())

	    }


	}

	/* Eliminar Venta */


	$(document).on('click', ".btnEliminarVenta", function(){

		var idVenta = $(this).attr("idVenta");
		
		swal({
				title: "¿Estás seguro que quieres eliminar la venta?",
				text: "Si es así, presiona aceptar",
				type : "warning",
				showCancelButton: true,
				confirmButtonText: "Aceptar",
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				cancelButtonText: "Cancelar"
			}).then(function(result)  {
				if(result.value) {

					window.location = "index.php?ruta=ventas&idVenta="+ idVenta; 

				}

			})

	})
