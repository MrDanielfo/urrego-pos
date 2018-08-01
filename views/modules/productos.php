<?php

  if($_SESSION['perfil'] == "Vendedor") {

    echo '<script>
            
            window.location = "inicio"

          </script>';

    return; 

  }


?>


<div class="content-wrapper">
  
    <section class="content-header">

      <h1>Administrar Productos</h1>

      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li class="active">Productos</li>
      </ol>

    </section>

    <section class="content">

      <div class="box">

        <div class="box-header with-border">

          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
            Agregar Producto
          </button>

        </div>

        <div class="box-body">
          
          <table class="table table-hovered table-striped table-responsive tablaProductos" width="100%">

            <thead>
              <tr>
                <th style="width: 10px;">#</th>
                <th>Imagen</th>
                <th>Código</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Precio de Compra</th>
                <th>Precio de Venta</th>
                <th>Agregado</th>
              <?php   
              if($_SESSION['perfil'] == "Especial") {

          echo '<th>Editar</th>';

              } else {

         echo  '<th>Editar</th>
               <th>Eliminar</th>';
              }

              ?>
                
                
              </tr>
            </thead>

          </table>

          <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" id="perfilOculto">

        </div>
      
      </div>

    </section>

</div>

<!-- Ventana Modal Agregar Producto -->

<div id="modalAgregarProducto" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <form method="post" role="form" enctype="multipart/form-data">

      <div class="modal-content">

        <div class="modal-header" style="background-color:#3c8dbc">
          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title" style="color: white">Agregar Producto</h4>

        </div>

        <div class="modal-body">

          <div class="box-body">

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <select name="nuevaCategoria" id="nuevaCategoria" class="form-control input-lg" required>
                  <option value="">Selecciona la Categoría</option>

                  <?php


                    $item = null;
                    $valor = null;

                    $categorias = ProductsController::categoriaProducto($item, $valor);

                    foreach($categorias as $key => $item) {

                      echo '<option value="'. $item['id']   .'">'. $item['categoria']   .'</option>';

                    }

                  ?>
                </select>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                <input type="text" class="form-control input-lg" placeholder="Ingresar Código" name="nuevoCodigo" id="nuevoCodigo" value="" readonly required>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                <input type="text" class="form-control input-lg" placeholder="Descripción" name="nuevaDescripcion" required>
              </div>

            </div>

            
            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                <input type="number" class="form-control input-lg" placeholder="Stock" min="0" name="nuevoStock" required>
              </div>

            </div>

            <div class="form-group row">

              <div class="col-sm-6">

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                  <input type="number" class="form-control input-lg" id="nuevoCompra" step="any" placeholder="Precio de Compra" min="0" name="nuevoCompra" required>
                </div>

              </div>

              <div class="col-sm-6 col-xs-12">

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                  <input type="number" class="form-control input-lg" id="nuevoVenta" step="any" placeholder="Precio de Venta" min="0" name="nuevoVenta" required>
                </div>

                <br>

              

                <div class="col-sm-6 col-xs-12">

                  <div class="form-group">
                    <label>
                      <input type="checkbox" class="minimal porcentaje" checked>
                      Utilizar Porcentaje
                    </label>
                  </div>
                  
                </div>

                <div class="col-sm-6 col-xs-12" style="padding:0;">

                  <div class="input-group">
                    <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                  </div>
                  
                </div>
              </div>

            </div>

            <div class="form-group">
              <div class="panel">Subir Imagen</div>
                <input type="file" class="nuevaImagen" name="nuevaImagenProducto">
                <p class="help-block">Peso Máximo de la foto 2MB</p>
                <img src="assets/img/productos/default/anonymous.png" alt="anony" class="img-thumbnail previsualizar" width="100px">
              
            </div>

          </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Ingresar Producto</button>

        </div>

      </div>

      <?php

        $crearProducto = new ProductsController();
        $crearProducto->crearProducto();


      ?>

    </form>

  </div>

</div>

<!-- Ventana Modal Editar Producto -->

<div id="modalEditarProducto" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <form method="post" role="form" enctype="multipart/form-data">

      <div class="modal-content">

        <div class="modal-header" style="background-color:#3c8dbc">
          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title" style="color: white">Editar Producto</h4>

        </div>

        <div class="modal-body">

          <div class="box-body">

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <select name="editarCategoriaProducto"  class="form-control input-lg" readonly required>
                  <option id="editarCategoriaProducto"></option>
                </select>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                <input type="text" class="form-control input-lg" name="editarCodigo" id="editarCodigo" value="" readonly required>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                <input type="text" class="form-control input-lg" value="" id="editarDescripcion" name="editarDescripcion" required>
              </div>

            </div>

            
            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                <input type="number" class="form-control input-lg" id="editarStock" value="" min="0" name="editarStock" required>
              </div>

            </div>

            <div class="form-group row">

              <div class="col-sm-6">

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                  <input type="number" class="form-control input-lg" id="editarPrecioCompra" step="any" min="0" name="editarPrecioCompra" required>
                </div>

              </div>

              <div class="col-sm-6 col-xs-12">

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                  <input type="number" class="form-control input-lg" id="editarPrecioVenta" step="any" min="0" name="editarPrecioVenta" readonly required>
                </div>

                <br>

              

                <div class="col-sm-6 col-xs-12">

                  <div class="form-group">
                    <label>
                      <input type="checkbox" class="minimal porcentaje" checked>
                      Utilizar Porcentaje
                    </label>
                  </div>
                  
                </div>

                <div class="col-sm-6 col-xs-12" style="padding:0;">

                  <div class="input-group">
                    <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                  </div>
                  
                </div>
              </div>

            </div>

            <div class="form-group">
              <div class="panel">Subir Imagen</div>
                <input type="file" class="nuevaImagen" name="editarImagenProducto">
                <input type="hidden" value="" id="imagenActualProducto" name="imagenActualProducto">

                <p class="help-block">Peso Máximo de la foto 2MB</p>
                <img src="assets/img/productos/default/anonymous.png" alt="anony" class="img-thumbnail previsualizar" width="100px">
              
            </div>

          </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Editar Producto</button>

        </div>

      </div>

      <?php

        $editarProducto = new ProductsController();
        $editarProducto->editarProducto();


      ?>

    </form>

  </div>

</div>

<?php

    $borrarProducto = new ProductsController();
    $borrarProducto->borrarProducto();

?>