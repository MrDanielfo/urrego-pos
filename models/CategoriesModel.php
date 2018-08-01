<?php


require_once 'ConnectionModel.php';

class CategoriesModel {

	static public function crearCategoria($tabla, $valores) {

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (categoria) VALUES (:categoria)");
		$stmt->bindParam(":categoria", $valores, PDO::PARAM_STR); 

		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

	} // fin del método estático

	static public function mostrarCategorias($tabla, $item, $valor) {

		if($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt->execute();

			return $stmt->fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();
		$stmt = null;
		

	} // fin del método mostrarCategorias

	static public function editarCategoria($tabla, $valores) {

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET categoria = :categoria WHERE id = :id");
		$stmt->bindParam(":categoria", $valores['nombreCategoria'], PDO::PARAM_STR); 
		$stmt->bindParam(":id", $valores['idCategoria'], PDO::PARAM_INT);

		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();


	} // fin del méotodo editarCategoria

	static public function eliminarCategoria($tabla, $datos) {


		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();


	}




} // fin de la clase