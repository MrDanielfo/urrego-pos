<?php

class UsersController {

	 public function ingresoUsuario(){

		if(isset($_POST['usuarioIngreso'])) { 

			if( preg_match('/^[a-zA-Z0-9]+$/', $_POST['usuarioIngreso']) &&
			    preg_match('/^[a-zA-Z0-9]+$/', $_POST['passIngreso']) ) {

				$encriptado = crypt($_POST['passIngreso'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
				$tabla = 'usuarios';

				$item = 'usuario';
				$valor = $_POST['usuarioIngreso'];

				$respuesta = UsersModel::ingresoUsuario($tabla, $item, $valor ); 

				if($respuesta['usuario'] == $_POST['usuarioIngreso'] && $respuesta['pass'] == $encriptado) {

					if($respuesta['estado'] == 1) {

						$_SESSION['validar'] = 'ok';
					    $_SESSION['id'] = $respuesta['id'];
					    $_SESSION['nombre'] = $respuesta['nombre'];
					    $_SESSION['usuario'] = $respuesta['usuario'];
					    $_SESSION['foto'] = $respuesta['foto'];
					    $_SESSION['perfil'] = $respuesta['perfil'];

					    /* Registrar fecha para saber último Login */ 
					    date_default_timezone_set('America/Mexico_City');

					    $fecha = date('Y-m-d');
					    $hora = date("H:i:s");

					    $fechaActual = $fecha. ' ' .$hora;

					    $item1 = $respuesta['id'];
					    $item2 = $fechaActual; 

					    $ultimoLogin = UsersModel::actualizarHoraLogin($item1, $item2, $tabla); 

					    if($ultimoLogin == "ok"){

					    	echo 	'<script>
										window.location = "inicio";
					    			</script>';

					    }  

					} else {
						echo '<div class="alert alert-danger" style="margin: 10px auto;">El usuario se encuentra desactivado, no puede ingresar</div>';
					}

		    	}  else {
					echo '<div class="alert alert-danger" style="margin: 10px auto;">Error al ingresar los datos, inténtalo de nuevo</div>';
		    	}

			}

		}

	}

	// Registro de Usuario 

	public function crearUsuario() {

		if(isset($_POST['nuevoUsuario'])) {

			if( preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['nuevoNombre']) &&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST['nuevoUsuario']) &&
			    preg_match('/^[a-zA-Z0-9]+$/', $_POST['nuevoPassword']) ) {

			$ruta = "";

				
			// Validar Imagen
			if(isset($_FILES['nuevaFoto']['tmp_name'])) {

				list($ancho, $alto) = getimagesize($_FILES['nuevaFoto']['tmp_name']);
				
				$nuevoAncho = 500;
				$nuevoAlto = 500;

				// crear directorio para guardar imagen del usuario 

				$directorio = "assets/img/usuarios/" . $_POST['nuevoUsuario'];
				mkdir($directorio, 0755);
				// De acuerdo al tipo de imagen se aplican las funciones por defecto
				if($_FILES['nuevaFoto']['type'] == 'image/jpeg') {

					// guardar imagen en el directorio
					$aleatorio = mt_rand(100, 999);

					$ruta = "assets/img/usuarios/" . $_POST['nuevoUsuario'] . "/" . $aleatorio . ".jpg";
					$origen = imagecreatefromjpeg($_FILES['nuevaFoto']['tmp_name']);
					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
					imagejpeg($destino, $ruta);

				}

				if($_FILES['nuevaFoto']['type'] == 'image/png') {

					// guardar imagen en el directorio
					$aleatorio = mt_rand(100, 999);

					$ruta = "assets/img/usuarios/" . $_POST['nuevoUsuario'] . "/" . $aleatorio . ".png";
					$origen = imagecreatefromjpeg($_FILES['nuevaFoto']['tmp_name']);
					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
					imagejpeg($destino, $ruta);


				}


			}	
				
				$tabla = 'usuarios';

				$encriptado = crypt($_POST['nuevoPassword'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$'); 

				$valores = array(
					"nombre" => $_POST['nuevoNombre'],
					"usuario" => $_POST['nuevoUsuario'],
				    "pass"    => $encriptado,
					"perfil"  => $_POST['nuevoPerfil'],
					"foto"	  => $ruta 
				); 

				$respuesta = UsersModel::crearUsuario($tabla, $valores);

				if($respuesta == 'ok') {
					echo '<script>
							swal({
								type : "success",
								title: "El Usuario fue creado con éxito",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result) => {
								if(result.value) {
									window.location = "usuarios";
								}
							})
						</script>';
				} 

			} else {

				echo '<script>
						swal({
							type : "error",
							title: "Ni el usuario ni el password deben llevar caracteres especiales",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result) => {
							if(result.value) {
								window.location = "usuarios";
							}
						})
					</script>';

			}

		}

	} // fin del método

	public function mostrarUsuarios(){

		$tabla = "usuarios";
		// no concatenar un if, se debe dividir el ECHO

		$respuesta = UsersModel::mostrarUsuarios($tabla);

		foreach ($respuesta as $key => $item) {
			echo '<tr>
                	<td style="width: 10px;">' . ($key + 1) . '</td>
                	<td>' . $item['nombre'] . '</td>
                	<td>' . $item['usuario'] . '</td>';
        	if($item['foto'] != "") {
            	echo '<td><img src="' . $item['foto'] . '" alt="anony" class="img-thumbnail" width="40px"></td>';
                	} else { 
            	echo '<td><img src="assets/img/usuarios/anonymous.png" alt="anony" class="img-thumbnail" width="40px"></td>';
            		} 
                echo '<td>' . $item['perfil'] . '</td>';

                if($item['estado'] != 0) {
                	echo '<td><button class="btn btn-success btn-xs btnActivar" id="' . $item['id'] . '" estado="0">Activado</button></td>';	
                } else {
                	echo '<td><button class="btn btn-danger btn-xs btnActivar" id="' . $item['id'] . '" estado="1">Desactivado</button></td>'; 
                }

                echo '<td>' . $item['ultimo_login'] . '</td>
                	<td class="text-center"><button class="btn btn-warning btnEditarUsuario" idUsuario="' . $item['id'] . '" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-pencil"></i></button></td>
                	<td class="text-center"><button class="btn btn-danger btnEliminarUsuario" idUsuario="' . $item['id'] . '" fotoUsuario="'. $item['foto'] .'" nombreUsuario="'. $item['usuario'] .'"><i class="fa fa-times"></i></button></td>
              	</tr>';
		}

	}

	public function mostrarUsuarioAjax($tabla, $item, $valor) {

		$respuesta = UsersModel::mostrarUsuarioAjax($tabla, $item, $valor);

		echo json_encode($respuesta);

	}

	public function editarUsuario(){

		if(isset($_POST['editarUsuario'])) {

			if( preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editarNombre'])) {

			$ruta = $_POST['fotoActual'];

			if(isset($_FILES['editarFoto']['tmp_name']) && !empty($_FILES['editarFoto']['tmp_name'])) {

				list($ancho, $alto) = getimagesize($_FILES['editarFoto']['tmp_name']);
				
				$nuevoAncho = 500;
				$nuevoAlto = 500;

				$directorio = "assets/img/usuarios/" . $_POST['editarUsuario'];
				// Preguntar si existe imagen // 

				if(!empty($_POST['fotoActual'])) {
					unlink($_POST['fotoActual']);
				} else {
					mkdir($directorio, 0755);
				}

				
				if($_FILES['editarFoto']['type'] == 'image/jpeg') {

					$aleatorio = mt_rand(100, 999);

					$ruta = "assets/img/usuarios/" . $_POST['editarUsuario'] . "/" . $aleatorio . ".jpg";
					$origen = imagecreatefromjpeg($_FILES['editarFoto']['tmp_name']);
					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
					imagejpeg($destino, $ruta);

				}

				if($_FILES['editarFoto']['type'] == 'image/png') {

					$aleatorio = mt_rand(100, 999);

					$ruta = "assets/img/usuarios/" . $_POST['editarUsuario'] . "/" . $aleatorio . ".png";
					$origen = imagecreatefromjpeg($_FILES['editarFoto']['tmp_name']);
					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
					imagejpeg($destino, $ruta);


				}


			}	
				
				$tabla = 'usuarios';

				if($_POST['editarPassword'] != "") {

					if(preg_match('/^[a-zA-Z0-9]+$/', $_POST['editarPassword'])) {
						$encriptado = crypt($_POST['editarPassword'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$'); 
					} else {
						echo '<script>
								swal({
									type : "error",
									title: "El password no debe llevar caracteres especiales",
									showConfirmButton: true,
									confirmButtonText: "Cerrar",
									closeOnConfirm: false
								}).then((result) => {
									if(result.value) {
										window.location = "usuarios";
									}
								})
							</script>';
					}

					
				} else {
					$encriptado = $_POST['passwordActual'];
				}

				$valores = array(
					"nombre" => $_POST['editarNombre'],
					"usuario" => $_POST['editarUsuario'],
				    "pass"    => $encriptado,
					"perfil"  => $_POST['editarPerfil'],
					"foto"	  => $ruta 
				); 

				$respuesta = UsersModel::editarUsuario($tabla, $valores);

				if($respuesta == 'ok') {
					echo '<script>
							swal({
								type : "success",
								title: "El Usuario fue editado con éxito",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result) => {
								if(result.value) {
									window.location = "usuarios";
								}
							})
						</script>';
				} 

			} else {

				echo '<script>
						swal({
							type : "error",
							title: "El usuario no debe llevar caracteres especiales",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result) => {
							if(result.value) {
								window.location = "usuarios";
							}
						})
					</script>';

			}

		}

	}

	public function detectarUsuario($tabla, $item, $valor) {

		$respuesta = UsersModel::mostrarUsuarioAjax($tabla, $item, $valor);

		echo json_encode($respuesta);

	}

	public function borrarUsuario() {

		if(isset($_GET['idUsuario'])){

			$tabla = "usuarios";
			$datos = $_GET['idUsuario'];
			$nombreUsuario = $_GET['nombreUsuario'];

			if($_GET['fotoUsuario'] != " ") {

				$foto = $_GET['fotoUsuario'];
				unlink($foto);
				$directorio = "assets/img/usuarios/" . $nombreUsuario;
				rmdir($directorio);

			}
				
			$respuesta = UsersModel::borrarUsuario($datos, $tabla);

			if($respuesta == 'ok') {
					echo '<script>
							swal({
								type : "success",
								title: "El Usuario fue eliminado con éxito",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result) => {
								if(result.value) {
									window.location = "usuarios";
								}
							})
						</script>';
			} 

		}

	}

}