<?php


require_once 'ConnectionModel.php'; 


class ClientsModel {

	static public function crearCliente($tabla, $datos) {

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, identificacion, email, telefono, direccion, fecha_nacimiento) VALUES (:nombre, :identificacion, :email, :telefono, :direccion, :fecha_nacimiento)");
		$stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
		$stmt->bindParam(":identificacion", $datos['identificacion'], PDO::PARAM_INT);
		$stmt->bindParam(":email", $datos['email'], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos['telefono'], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos['direccion'], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos['fecha_nacimiento'], PDO::PARAM_STR);

		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

		$stmt = null;


	}

	static public function mostrarClientes($tabla) {

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

		$stmt = null;


	}

	static public function mostrarIdCliente($datos, $item, $tabla) {

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt->bindParam(":$item", $datos, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

		$stmt = null;


	}

	static public function editarCliente($tabla, $datos) {

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, identificacion = :identificacion, email = :email, telefono = :telefono, direccion = :direccion, fecha_nacimiento = :fecha_nacimiento WHERE id = :id");

		$stmt->bindParam(":id", $datos['id'], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
		$stmt->bindParam(":identificacion", $datos['identificacion'], PDO::PARAM_INT);
		$stmt->bindParam(":email", $datos['email'], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos['telefono'], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos['direccion'], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos['fecha_nacimiento'], PDO::PARAM_STR);

		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

		$stmt = null;


	}


	static public function eliminarCliente($id, $tabla) {

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = $id");

		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

		$stmt = null;

	}

	static public function actualizarCompraCliente($item1, $item2, $valor2, $tablaCliente) {

		$stmt = Conexion::conectar()->prepare("UPDATE $tablaCliente SET $item2 = :$item2 WHERE id = :id");

		$stmt->bindParam(":id", $item1, PDO::PARAM_INT);
		$stmt->bindParam(":".$item2, $valor2, PDO::PARAM_INT);

		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

		$stmt = null;

	}



}