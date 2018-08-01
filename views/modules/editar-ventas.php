<div class="content-wrapper">
  
    <section class="content-header">

      <h1>Editar Venta</h1>

      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li class="active">Editar Venta</li>
      </ol>

    </section>

    <section class="content">

      <div class="row">
        
        <!-- formulario -->
        <div class="col-lg-5 col-xs-12">
          
          <div class="box box-success">

            <div class="box-header with-border"></div>

            <form role="form" method="post" class="formularioVenta">

            <div class="box-body">

                  <div class="box">

                    <?php

                      if(isset($_GET['idVenta'])) {

                          $id = $_GET['idVenta']; 

                          $itemVenta = "id";
                          $valorVenta = $id; 

                          $ventas = SellsController::mostrarVentas($itemVenta, $valorVenta);

                            //var_dump($ventas);

                            $valorVendedor = $ventas['id_vendedor'];
                        
                            $vendedor = SellsController::mostrarVendedor($itemVenta, $valorVendedor);

                            $valorCliente = $ventas['id_cliente'];

                            $clientes = SellsController::mostrarClientes($itemVenta, $valorCliente);

                            $porcentajeImpuesto = $ventas['impuesto'] * 100  / $ventas['neto'];

                        }
                    ?>
                    
                    <div class="form-group">
                      
                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $vendedor['nombre'];    ?>" readonly>
                        <input type="hidden" name="editarIdVendedor" id="idVendedor" value="<?php echo $vendedor['id'];    ?>">

                      </div>

                    </div>

                    <div class="form-group">
                      
                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>

                          <input type="text" class="form-control" id="nuevaVenta" name="editarVenta" value="<?php echo $ventas['codigo']; ?>" readonly>
                          <input type="hidden" name="editarCodigoOculto" value="<?php echo $ventas['codigo']; ?>">
                        
                    </div>

                    </div>

                    <div class="form-group">
                      
                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-users"></i></span>
                        <select class="form-control" id="seleccionarCliente" name="editarSeleccionarCliente">

                          <option value="<?php echo  $clientes['id'];   ?>"><?php echo  $clientes['nombre'];   ?></option>

                          <?php

                            $item = null;
                            $valor = null;

                            $clientes = SellsController::mostrarClientes($item, $valor);

                            foreach($clientes as $key => $value) {

                                echo '<option value="'. $value['id']  .'">'. $value['nombre']  .'</option>';

                            }


                          ?>
                          
                          
                        </select>

                        <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar Cliente</button></span>

                      </div>

                    </div>

                    <div class="form-group row nuevoProducto">

                      <?php

                        $listaProductos = json_decode($ventas['productos'], true);

                        //var_dump($listaProductos);

                        foreach($listaProductos as $key => $valueProductos) {

                          echo '<div class="row" style="padding: 5px 15px">' .

                                  '<div class="col-xs-6" style="padding-right: 0px">' . 
                          
                                    '<div class="input-group">' .
                                
                                        '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'. $valueProductos['id']  .'"><i class="fa fa-times"></i></button></span>' .

                                        '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'. $valueProductos['id']  .'" name="agregarProducto"  value="'. $valueProductos['descripcion'] .'" readonly required>' .

                                    '</div>' . 

                                  '</div>' . 

                                  '<div class="col-xs-3">' .
                                    
                                      '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="'. $valueProductos['cantidad'] .'"  stock="'. $valueProductos['stock'] .'" nuevoStock="'. $valueProductos['stockFinal'] .'" required>' . 

                                  '</div>' .

                                  '<div class="col-xs-3 ingresoPrecio" style="padding-left: 0px">' .

                                    '<div class="input-group">' .

                                      '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' .
                                      '<input type="text" class="form-control nuevoPrecioProducto" name="nuevoPrecioProducto" precioReal="'. $valueProductos['precio'] .'" value="'. $valueProductos['total'] .'" readonly required>' .

                                    '</div>' .
                          
                                  '</div>' .
                              '</div>';


                          }
                      ?>
                    
                    </div>

                    <input type="hidden" id="listaProductosVenta" name="listaProductosVenta">

                    <button type="button" class="btn btn-default hidden-lg btnAgregarProductoResponsive">Agregar Producto</button>
                    <hr>

                    <div class="row">
                      
                      <div class="col-xs-8 pull-right">

                        <table class="table">

                          <thead>

                            <tr>
                              <th>Impuesto</th>
                              <th>Total</th>
                            </tr>

                          </thead>
                          <tbody>

                            <tr>

                              <td style="width: 50%">

                                <div class="input-group">  
                                  <input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" value="<?php echo $porcentajeImpuesto; ?>" required>
                                  <input type="hidden" name="editarPrecioImpuesto" id="nuevoPrecioImpuesto" value="<?php echo $ventas['impuesto']; ?>">
                                  <input type="hidden" name="editarPrecioNeto" id="nuevoPrecioNeto" value="<?php echo $ventas['neto']; ?>">
                                  <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                </div>  

                              </td>

                              <td style="width: 50%">

                                <div class="input-group">

                                  <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                  <input type="text" class="form-control input-lg" min="1" id="nuevoTotalVenta" total="<?php echo $ventas['neto']; ?>" name="nuevoTotalVenta" value="<?php echo $ventas['total_venta']; ?>" readonly required>
                                  <input type="hidden" name="editarRealTotalVenta" id="realTotalVenta" value="<?php echo $ventas['total_venta']; ?>">
                                  
                                </div>
                                
                              </td>

                            </tr>

                          </tbody>
                          
                        </table>

                      </div>

                    </div>
                    <hr>

                    <div class="form-group row">
                      
                      <div class="col-xs-6" style="padding-right: 0px">

                        <div class="input-group">

                          <select class="form-control" name="nuevoMetodoPago" id="nuevoMetodoPago" required>

                            <option value="">Seleccione método de Pago</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="TC">Tarjeta de Crédito</option>
                            <option value="TD">Tarjeta de Débito</option>
                            
                          </select>

                        </div>
                        
                      </div>


                      <div class="cajasMetodoPago"></div>

                      <input type="hidden" name="editarListaMetodoPago" id="listaMetodoPago">

                    </div>
                    <br>

                  </div>

            </div>

            <div class="box-footer">

              <button type="submit" class="btn btn-primary pull-right">Editar Venta</button>

            </div>

            </form>

            <?php 

                $editarVenta = new SellsController();
                $editarVenta->editarVenta();
            ?>
            
          </div>

        </div>

        <!-- Tabla de Productos -->

        <div class="col-lg-7 hidden-md hiddem-sm hidden-xs">
            
            <div class="box box-warning">

              <div class="box-header with-border"></div>

              <div class="box-body">

                <table class="table table-bordered table-striped table-responsive tablaVentas">

                  <thead>
                    
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Imagen</th>
                      <th>Código</th>
                      <th>Descripción</th>
                      <th>Stock</th>
                      <th>Acciones</th>
                    </tr>

                  </thead>
       
                </table>
                
              </div>
            
            </div>

        </div>


      </div>

    </section>

</div>

<!-- Ventana Modal Agregar Cliente -->

<div id="modalAgregarCliente" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <form method="post" role="form">

      <div class="modal-content">

        <div class="modal-header" style="background-color:#3c8dbc">
          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title" style="color: white">Agregar Cliente</h4>

        </div>

        <div class="modal-body">

          <div class="box-body">

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" placeholder="Nombre del Cliente" name="nuevoCliente" required>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="number" min="0" class="form-control input-lg" placeholder="DNI del Cliente" name="nuevoDniCliente" required>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control input-lg" placeholder="Email del Cliente" name="nuevoEmailCliente" required>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" data-inputmask="'mask' : '(999) 999-9999'" data-mask class="form-control input-lg" placeholder="Telefono del Cliente" name="nuevoTelefonoCliente" required>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input type="text" class="form-control input-lg" placeholder="Dirección del Cliente" name="nuevaDireccionCliente" required>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask class="form-control input-lg" placeholder="Fecha de Nacimiento Cliente" name="nuevoNacimientoCliente" required>
              </div>

            </div>

        </div>

      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-primary">Ingresar Cliente</button>

      </div>

    </div>

      <?php

        $crearCliente = new ClientsController();
        $crearCliente->crearCliente();


      ?>

    </form>

  </div>

</div>
