<?php

class CategoriesController {


	public function crearCategoria() {

		if(isset($_POST['nuevaCategoria'])) {

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['nuevaCategoria'])) {

				$tabla = "categorias";

				$valores =  $_POST['nuevaCategoria']; 

				$respuesta = CategoriesModel::crearCategoria($tabla, $valores);

				if($respuesta == 'ok') {
					echo '<script>
							swal({
								type : "success",
								title: "La categoría fue creada con éxito",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result) => {
								if(result.value) {
									window.location = "categorias";
								}
							})
						</script>';
				}

			} else {

				echo '<script>
						swal({
							type : "error",
							title: "El nombre de la categoría no debe llevar caracteres especiales",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result) => {
							if(result.value) {
								window.location = "categorias";
							}
						})
					</script>';

			}


		}


	} // fin del método crearCategoria 

	public function mostrarCategorias() {

		$tabla = "categorias";

		$item = null;
        $valor = null;

		$respuesta = CategoriesModel::mostrarCategorias($tabla, $item, $valor);

		foreach ($respuesta as $key => $item) {
			echo '<tr>
                    <td style="width: 10px;">'. ($key + 1)  .'</td>
                    <td class="text-uppercase">'. $item['categoria']  .'</td>
                    <td class="text-center"><button class="btn btn-warning btnEditarCategoria" idCategoria="' . $item['id'] . '" data-toggle="modal"  data-target="#modalEditarCategoria"><i class="fa fa-pencil"></i></button></td>';

                if($_SESSION['perfil'] == "Administrador") {
           echo     '<td class="text-center"><button class="btn btn-danger btnEliminarCategoria" idCategoria="' . $item['id'] . '"><i class="fa fa-times"></i></button></td>';
   			}
           echo  '</tr>'; 
		}

	} // fin del método público

	public function mostrarCategoriaAjax($datos) {

		$tabla = "categorias";
		$item = "id"; 
		$valor = $datos;

		$respuesta = CategoriesModel::mostrarCategorias($tabla, $item, $valor); 

		echo json_encode($respuesta);


	}

	public function editarCategoria(){

		if(isset($_POST['editarCategoria'])) {

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editarCategoria'])) {

				$tabla = "categorias";

				$valores = array(
					'idCategoria' => $_POST['idCategoria'],
					"nombreCategoria" => $_POST['editarCategoria'] 

				); 

				$respuesta = CategoriesModel::editarCategoria($tabla, $valores);

				if($respuesta == 'ok') {
					echo '<script>
							swal({
								type : "success",
								title: "La categoría fue editada con éxito",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result) => {
								if(result.value) {
									window.location = "categorias";
								}
							})
						</script>';
				}

			} else {

				echo '<script>
						swal({
							type : "error",
							title: "El nombre de la categoría no debe llevar caracteres especiales",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result) => {
							if(result.value) {
								window.location = "categorias";
							}
						})
					</script>';

			}


		}

	} // fin del método


	public function eliminarCategoria() {

		if(isset($_GET['idCategoria'])){

			$tabla = "categorias";

			$datos = $_GET['idCategoria'];

			$respuesta = CategoriesModel::eliminarCategoria($tabla, $datos);

			if($respuesta == 'ok') {

					echo '<script>
							swal({
								type : "success",
								title: "La Categoría fue eliminada con éxito",
								showConfirmButton: true,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
							}).then((result) => {
								if(result.value) {
									window.location = "categorias";
								}
							})
						</script>';


			}

		}


	} // fin del método 


	static public function mostrarCategoriasFrontal($item, $valor) {

		$tabla = "categorias";

		$respuesta = CategoriesModel::mostrarCategorias($tabla, $item, $valor);

		return $respuesta;


	}


} // fin de la clase 