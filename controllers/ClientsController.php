<?php

class ClientsController {

	public function crearCliente() {

		if(isset($_POST['nuevoCliente'])) {

			if( preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['nuevoCliente']) &&
				preg_match('/^[0-9]+$/', $_POST['nuevoDniCliente']) && 
				preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,4}))$/', $_POST['nuevoEmailCliente']) &&
				preg_match('/^[()\-0-9 ]+$/', $_POST['nuevoTelefonoCliente']) &&
				preg_match('/^[#\.\-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['nuevaDireccionCliente']) ) {

				$tabla = 'clientes';

				
				$datos = array(
					"nombre" 			=> $_POST['nuevoCliente'],
					"identificacion" 	=> $_POST['nuevoDniCliente'],
				    "email"    			=> $_POST['nuevoEmailCliente'],
					"telefono"  		=> $_POST['nuevoTelefonoCliente'],
					"direccion"	  		=> $_POST['nuevaDireccionCliente'],
					"fecha_nacimiento"  => $_POST['nuevoNacimientoCliente']
				); 

				$respuesta = ClientsModel::crearCliente($tabla, $datos);

				if($respuesta == 'ok') {
					echo '<script>
							swal({
								type : "success",
								title: "El Cliente fue agreado con éxito",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result) => {
								if(result.value) {
									window.location = "clientes";
								}
							})
						</script>';
				} 

			} else {

				echo '<script>
						swal({
							type : "error",
							title: "Debes respetar los campos y no introducir caracteres especiales",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result) => {
							if(result.value) {
								window.location = "clientes";
							}
						})
					</script>';

			}

		}

	} // fin del método

	public function mostrarClientes(){

		$tabla = "clientes";
		// no concatenar un if, se debe dividir el ECHO

		$respuesta = ClientsModel::mostrarClientes($tabla);

		foreach ($respuesta as $key => $item) {
			echo '<tr>
                  <td style="width: 10px;">'. ($key + 1) .'</td>
                  <td>'. $item['nombre'] .'</td>
                  <td>'. $item['identificacion'] .'</td>
                  <td>'. $item['email'] .'</td>
                  <td>'. $item['telefono'] .'</td>
                  <td>'. $item['direccion'] .'</td>
                  <td>'. $item['fecha_nacimiento'] .'</td> 
                  <td style="width: 10px;">'. $item['total_compras'] .'</td>
                  <td>'. $item['ultima_compra'] .'</td>
                  <td>'. $item['fecha_ingreso'] .'</td>
                  <td class="text-center"><button class="btn btn-warning btnEditarCliente"  idCliente="'. $item['id'] .'" data-toggle="modal" data-target="#modalEditarCliente"><i class="fa fa-pencil"></i></button></td>';
          if($_SESSION['perfil'] == "Administrador") {

          	echo '<td class="text-center"><button class="btn btn-danger btnEliminarCliente" idCliente="'. $item['id'] .'" ><i class="fa fa-times"></i></button></td>
                </tr>'; 
          	}
                  
		}

	}

	public function mostrarIdCliente($datos, $item, $tabla) {


		$respuesta = ClientsModel::mostrarIdCliente($datos, $item, $tabla);

		echo json_encode($respuesta);


	}

	public function editarCliente() {

		if(isset($_POST['editarNombreCliente'])) {

			if( preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editarNombreCliente']) &&
				preg_match('/^[0-9]+$/', $_POST['editarDniCliente']) && 
				preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,4}))$/', $_POST['editarEmailCliente']) &&
				preg_match('/^[()\-0-9 ]+$/', $_POST['editarTelefonoCliente']) &&
				preg_match('/^[#\.\-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editarDireccionCliente']) ) {

				$tabla = 'clientes';

				
				$datos = array(
					"id" 				=> $_POST['editarIdCliente'],
					"nombre" 			=> $_POST['editarNombreCliente'],
					"identificacion" 	=> $_POST['editarDniCliente'],
				    "email"    			=> $_POST['editarEmailCliente'],
					"telefono"  		=> $_POST['editarTelefonoCliente'],
					"direccion"	  		=> $_POST['editarDireccionCliente'],
					"fecha_nacimiento"  => $_POST['editarNacimientoCliente']
				); 

				$respuesta = ClientsModel::editarCliente($tabla, $datos);

				if($respuesta == 'ok') {
					echo '<script>
							swal({
								type : "success",
								title: "El Cliente fue editado con éxito",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result) => {
								if(result.value) {
									window.location = "clientes";
								}
							})
						</script>';
				} 

			} else {

				echo '<script>
						swal({
							type : "error",
							title: "Debes respetar los campos y no introducir caracteres especiales",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result) => {
							if(result.value) {
								window.location = "clientes";
							}
						})
					</script>';

			}

		}


	} // fin del método

	public function eliminarCliente() {

		if(isset($_GET['idCliente'])) {

			$id = $_GET['idCliente'];
			$tabla = "clientes";

			$respuesta = ClientsModel::eliminarCliente($id, $tabla);

			if($respuesta == 'ok') {
					echo '<script>
							swal({
								type : "success",
								title: "El Cliente fue eliminado con éxito",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result) => {
								if(result.value) {
									window.location = "clientes";
								}
							})
						</script>';
				} 


		}

	}


}