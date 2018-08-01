<?php

require_once 'ConnectionModel.php';

class UsersModel extends Conexion {

	static public function ingresoUsuario($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

		$stmt = null;

	}

	static public function crearUsuario($tabla, $valores) {

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, usuario, pass, perfil, foto) VALUES (:nombre, :usuario, :pass, :perfil, :foto)");
		$stmt->bindParam(":nombre", $valores['nombre'], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $valores['usuario'], PDO::PARAM_STR);
		$stmt->bindParam(":pass", $valores['pass'], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $valores['perfil'], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $valores['foto'], PDO::PARAM_STR);

		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

		$stmt = null;


	}

	static public function mostrarUsuarios($tabla) {

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

		$stmt = null;


	}

	static public function mostrarUsuarioAjax($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

		$stmt = null;

	}

	static public function editarUsuario($tabla, $valores) {

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, pass = :pass, perfil = :perfil, foto = :foto WHERE usuario = :usuario");

		$stmt->bindParam(":nombre", $valores['nombre'], PDO::PARAM_STR);
		$stmt->bindParam(":pass", $valores['pass'], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $valores['perfil'], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $valores['foto'], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $valores['usuario'], PDO::PARAM_STR);

		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

		$stmt = null;


	}

	static public function activarEstado($datosAjax, $tabla) {

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE id = :id");

		$stmt->bindParam(":id", $datosAjax['idUsuarioEstado'], PDO::PARAM_INT);
		$stmt->bindParam(":estado", $datosAjax['estadoUsuario'], PDO::PARAM_INT);

		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

		$stmt = null;

	}

	static public function actualizarHoraLogin($item1, $item2, $tabla) {

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET ultimo_login = :ultimo_login WHERE id = :id");

		$stmt->bindParam(":id", $item1, PDO::PARAM_INT);
		$stmt->bindParam(":ultimo_login", $item2, PDO::PARAM_INT);

		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

		$stmt = null;

	}

	static public function borrarUsuario($datos, $tabla) {

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);
		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

		$stmt = null;

	}


}

