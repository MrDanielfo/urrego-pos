<?php

require_once 'ConnectionModel.php';

class SellsModel {


	static public function mostrarVentas($item, $valor, $tabla) {

		if($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_INT);

			$stmt->execute();


			return $stmt->fetch();


		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();

		$stmt = null;



	} // fin del método

	static public function mostrarClientes($item, $valor, $tabla) {

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



	} // fin del método

	static public function mostrarVendedor($item, $valor, $tabla) {

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



	} // fin del método


	static public function crearVenta($tabla, $datos) {

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (codigo, id_cliente, id_vendedor, productos, impuesto, neto, total_venta, metodo_pago) VALUES (:codigo, :id_cliente, :id_vendedor, :productos, :impuesto, :neto, :total_venta, :metodo_pago)");
		
		$stmt->bindParam(":codigo", $datos['codigo'], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos['id_cliente'], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos['id_vendedor'], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos['productos'], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos['impuesto'], PDO::PARAM_INT);
		$stmt->bindParam(":neto", $datos['neto'], PDO::PARAM_INT);
		$stmt->bindParam(":total_venta", $datos['total_venta'], PDO::PARAM_INT);
		$stmt->bindParam(":metodo_pago", $datos['metodo_pago'], PDO::PARAM_STR);

		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

		$stmt = null;


	}

	static public function editarVenta($tabla, $datos) {

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cliente = :id_cliente, id_vendedor = :id_vendedor, productos = :productos, impuesto = :impuesto, neto = :neto, total_venta = :total_venta, metodo_pago = :metodo_pago WHERE codigo = :codigo");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos['id_cliente'], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos['id_vendedor'], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos['impuesto'], PDO::PARAM_INT);
		$stmt->bindParam(":neto", $datos['neto'], PDO::PARAM_INT);
		$stmt->bindParam(":total_venta", $datos['total_venta'], PDO::PARAM_INT);
		$stmt->bindParam(":metodo_pago", $datos['metodo_pago'], PDO::PARAM_STR);


		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

		$stmt = null;

	}

	static public function eliminarVenta($id, $tabla)  {

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		if($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();

		$stmt = null;

	}

	static public function rangoFechas($fechaInicial, $fechaFinal, $tabla) {

		if($fechaInicial == null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt->execute();

			return $stmt->fetchAll();

		} else if ($fechaInicial == $fechaFinal) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha LIKE '%$fechaFinal%'");
			$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);
			$stmt->execute();

			return $stmt->fetchAll();

		} else {

			$fechaActual = new DateTime();
			$fechaActual->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");
			$fechaFinalDos = new DateTime($fechaFinal);
			$fechaFinalDos->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinalDos->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno ) {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");

			} else {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");

			}

			
			$stmt->execute();
			return $stmt->fetchAll();

		}

		
		$stmt->close();

		$stmt = null;

	}


	static public function conteoNetoVentas($tabla) {

		$stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total  FROM $tabla");

		$stmt->execute();
		return $stmt->fetch();

		$stmt->close();

		$stmt = null;


	}

	

}