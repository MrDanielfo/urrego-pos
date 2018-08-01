<?php

class ProductsController {

	static public function mostrarProductos($item, $valor, $orden){

		$tabla = "productos";

		$respuesta = ProductsModel::mostrarProductos($item, $valor, $tabla, $orden);

		return $respuesta; 


	}

	static public function categoriaProducto($item, $valor) {

		$tabla = "categorias";

		$respuesta = ProductsModel::categoriaProducto($item, $valor, $tabla);

		return $respuesta;

	}

  public function mostrarCodigo($item, $valor, $tabla, $orden) {

    $respuesta = ProductsModel::mostrarProductos($item, $valor, $tabla, $orden);

    echo json_encode($respuesta);

  }

  public function mostrarIdProducto($item, $valor, $tabla) {

    $respuesta = ProductsModel::mostrarIdProducto($item, $valor, $tabla);

    echo json_encode($respuesta);


  }

  public function crearProducto(){

    if(isset($_POST['nuevoCodigo'])) {

      if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['nuevaDescripcion']) &&
         preg_match('/^[0-9]+$/', $_POST['nuevoStock']) &&
         preg_match('/^[0-9.]+$/', $_POST['nuevoCompra']) &&
         preg_match('/^[0-9.]+$/', $_POST['nuevoVenta']) ) {

          $ruta = "assets/img/productos/default/anonymous.png";

          // Validar Imagen
          if(isset($_FILES['nuevaImagenProducto']['tmp_name'])) {

            list($ancho, $alto) = getimagesize($_FILES['nuevaImagenProducto']['tmp_name']);
            
            $nuevoAncho = 500;
            $nuevoAlto = 500;

            $directorio = "assets/img/productos/" . $_POST['nuevoCodigo'];
            mkdir($directorio, 0755);

            // De acuerdo al tipo de imagen se aplican las funciones por defecto
            if($_FILES['nuevaImagenProducto']['type'] == 'image/jpeg') {

              $aleatorio = mt_rand(100, 999);

              $ruta = "assets/img/productos/" . $_POST['nuevoCodigo'] . "/" . $aleatorio . ".jpg";
              $origen = imagecreatefromjpeg($_FILES['nuevaImagenProducto']['tmp_name']);
              $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

              imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
              imagejpeg($destino, $ruta);

            }

            if($_FILES['nuevaImagenProducto']['type'] == 'image/png') {

              $aleatorio = mt_rand(100, 999);

              $ruta = "assets/img/productos/" . $_POST['nuevoCodigo'] . "/" . $aleatorio . ".png";
              $origen = imagecreatefromjpeg($_FILES['nuevaImagenProducto']['tmp_name']);
              $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

              imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
              imagejpeg($destino, $ruta);

            }


          }

          $tabla = "productos"; 

          $datos = array( 
            'id_categoria' => $_POST['nuevaCategoria'],
            'codigo'    => $_POST['nuevoCodigo'],
            'descripcion' => $_POST['nuevaDescripcion'],
            'stock'     => $_POST['nuevoStock'],
            'precio_compra' => $_POST['nuevoCompra'],
            'precio_venta'  =>  $_POST['nuevoVenta'],
            'imagen'       => $ruta 
          );

          $respuesta = ProductsModel::crearProducto($datos, $tabla);

          if($respuesta == 'ok') {
          echo '<script>
                  swal({
                    type : "success",
                    title: "El producto fue creado con éxito",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                  }).then((result) => {
                    if(result.value) {
                      window.location = "productos";
                    }
                  })
            </script>';
        } 

        } else {

          echo '<script>
                  swal({
                    type : "error",
                    title: "Los campos no deben llevar caracteres especiales",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                  }).then((result) => {
                    if(result.value) {
                      window.location = "productos";
                    }
                  })
            </script>';

          }


        }

    } // fin del método

    public function editarProducto() {


      if(isset($_POST['editarCodigo'])) {

      if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editarDescripcion']) &&
         preg_match('/^[0-9]+$/', $_POST['editarStock']) &&
         preg_match('/^[0-9.]+$/', $_POST['editarPrecioCompra']) &&
         preg_match('/^[0-9.]+$/', $_POST['editarPrecioVenta']) ) {

          $ruta = $_POST['imagenActualProducto'];

        
          if(isset($_FILES['editarImagenProducto']['tmp_name']) && !empty($_FILES['editarImagenProducto']['tmp_name'])) {

              list($ancho, $alto) = getimagesize($_FILES['editarImagenProducto']['tmp_name']);
              
              $nuevoAncho = 500;
              $nuevoAlto = 500;

              $directorio = "assets/img/productos/" . $_POST['editarCodigo'];

              if(!empty($_POST['imagenActualProducto']) && $_POST['imagenActualProducto'] != "assets/img/productos/default/anonymous.png") {

                  unlink($_POST['imagenActualProducto']);

                } else {
                  mkdir($directorio, 0755);
                }
              

              
              if($_FILES['editarImagenProducto']['type'] == 'image/jpeg') {

                $aleatorio = mt_rand(100, 999);

                $ruta = "assets/img/productos/" . $_POST['editarCodigo'] . "/" . $aleatorio . ".jpg";
                $origen = imagecreatefromjpeg($_FILES['editarImagenProducto']['tmp_name']);
                $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                imagejpeg($destino, $ruta);

              }

              if($_FILES['editarImagenProducto']['type'] == 'image/png') {

                $aleatorio = mt_rand(100, 999);

                $ruta = "assets/img/productos/" . $_POST['editarCodigo'] . "/" . $aleatorio . ".png";
                $origen = imagecreatefromjpeg($_FILES['editarImagenProducto']['tmp_name']);
                $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                imagejpeg($destino, $ruta);

              }


          }

            $tabla = "productos"; 

            $datos = array( 
              'id_categoria' => $_POST['editarCategoriaProducto'],
              'codigo'    => $_POST['editarCodigo'],
              'descripcion' => $_POST['editarDescripcion'],
              'stock'     => $_POST['editarStock'],
              'precio_compra' => $_POST['editarPrecioCompra'],
              'precio_venta'  =>  $_POST['editarPrecioVenta'],
              'imagen'       => $ruta 
            );

            $respuesta = ProductsModel::editarProducto($datos, $tabla);

            if($respuesta == 'ok') {
            echo '<script>
                    swal({
                      type : "success",
                      title: "El producto fue editado con éxito",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar",
                      closeOnConfirm: false
                    }).then((result) => {
                      if(result.value) {
                        window.location = "productos";
                      }
                    })
              </script>';
          } 

        } else {

          echo '<script>
                  swal({
                    type : "error",
                    title: "Los campos no deben llevar caracteres especiales",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                  }).then((result) => {
                    if(result.value) {
                      window.location = "productos";
                    }
                  })
            </script>';

          }


        }


    } // fin del método editarProducto()

    public function borrarProducto(){

      if(isset($_GET['idProducto'])){

        $tabla = "productos";
        $datos = $_GET['idProducto'];
        $codigoProducto = $_GET['codigoProducto'];

      if($_GET['fotoProducto'] != " ") {

          $foto = $_GET['fotoProducto'];
          unlink($foto);
          $directorio = "assets/img/productos/" . $codigoProducto;
          rmdir($directorio);

        }
        
        $respuesta = ProductsModel::borrarProducto($datos, $tabla);

        if($respuesta == 'ok') {
            echo '<script>
                swal({
                  type : "success",
                  title: "El Producto fue eliminado con éxito",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar",
                  closeOnConfirm: false
                }).then((result) => {
                  if(result.value) {
                    window.location = "productos";
                  }
                })
              </script>';
        } 

    }


    }

    static public function sumaVentas() {

      $tabla = "productos";
      $respuesta  = ProductsModel::sumaVentas($tabla);

      return $respuesta;
    }


} // fin de la clase 

