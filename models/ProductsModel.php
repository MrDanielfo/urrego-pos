<?php

require_once 'ConnectionModel.php';

class ProductsModel {

	static public function mostrarProductos($item, $valor, $tabla, $orden) {

		if($item != null) {

			if($item == 'id_categoria' ) {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $orden DESC");

			} else {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
			}

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_INT); 

			$stmt->execute();

			return $stmt->fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC");

			$stmt->execute();

			return $stmt->fetchAll();

		}

			$stmt->close();

			$stmt = null;
		
	}


	static public function mostrarIdProducto($item, $valor, $tabla) {

		if($item != null) {
 
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_INT); 

			$stmt->execute();

			return $stmt->fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt->execute();

			return $stmt->fetchAll();

		}

			$stmt->close();

			$stmt = null;


	}

	static public function categoriaProducto($item, $valor, $tabla) {

		if($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_INT); 

			$stmt->execute();

			return $stmt->fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt->execute();

			return $stmt->fetchAll();

		}


		$stmt->close();

		$stmt = null;


	}


	static public function crearProducto($datos, $tabla) {

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_categoria, codigo, descripcion, imagen, stock, precio_compra, precio_venta) VALUES (:id_categoria, :codigo, :descripcion, :imagen, :stock, :precio_compra, :precio_venta)");
		$stmt->bindParam(":id_categoria", $datos['id_categoria'], PDO::PARAM_INT);
		$stmt->bindParam(":codigo", $datos['codigo'], PDO::PARAM_INT);
		$stmt->bindParam(":descripcion", $datos['descripcion'], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos['imagen'], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos['stock'], PDO::PARAM_INT);
		$stmt->bindParam(":precio_compra", $datos['precio_compra'], PDO::PARAM_INT);
		$stmt->bindParam(":precio_venta", $datos['precio_venta'], PDO::PARAM_INT);

		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

		$stmt = null;

	}

	static public function editarProducto($datos, $tabla) {

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET descripcion = :descripcion, imagen = :imagen, stock = :stock, precio_compra = :precio_compra, precio_venta = :precio_venta WHERE codigo = :codigo");

		$stmt->bindParam(":codigo", $datos['codigo'], PDO::PARAM_INT);
		$stmt->bindParam(":descripcion", $datos['descripcion'], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos['imagen'], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos['stock'], PDO::PARAM_INT);
		$stmt->bindParam(":precio_compra", $datos['precio_compra'], PDO::PARAM_INT);
		$stmt->bindParam(":precio_venta", $datos['precio_venta'], PDO::PARAM_INT);

		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

		$stmt = null;

	}

	static public function borrarProducto($datos, $tabla) {

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

	static public function editarVentaProducto($item1, $item2, $valor2, $tablaProducto) {

		$stmt = Conexion::conectar()->prepare("UPDATE $tablaProducto SET $item2 = :$item2 WHERE id = :id");

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

	static public function sumaVentas($tabla) {

		$stmt = Conexion::conectar()->prepare("SELECT SUM(ventas) as total  FROM $tabla");
	
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

		$stmt = null;

	}




}