<?php

  if($_SESSION['perfil'] == "Especial") {

    echo '<script>
            
            window.location = "inicio";

          </script>';

    return; 

  }


?>


<div class="content-wrapper">
  
    <section class="content-header">

      <h1>Administrar Clientes</h1>

      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li class="active">Clientes</li>
      </ol>

    </section>

    <section class="content">

      <div class="box">

        <div class="box-header with-border">

          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
            Agregar Cliente
          </button>

        </div>

        <div class="box-body">
          
          <table class="tablas table table-hovered table-striped table-responsive" width="100%">

            <thead>
              <tr>
                <th style="width: 10px;">#</th>
                <th>Nombre</th>
                <th>Documento ID</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Fecha de Nacimiento</th>
                <th style="width: 10px;">Total Compras</th>
                <th>Última Compra</th>
                <th>Ingreso al Sistema</th>
                <th>Editar</th>
            <?php

            if($_SESSION['perfil'] == "Administrador") {

         echo   '<th>Eliminar</th>';

            }

            
            ?>
        
              </tr>
            </thead>

            <tbody>

              <?php 

                $clientes = new ClientsController();
                $clientes->mostrarClientes();


              ?>
                <!--<tr>
                  <td style="width: 10px;">1</td>
                  <td>Juan Gallardo</td>
                  <td>8161123</td>
                  <td>juan@gallardo.com</td>
                  <td>555 57 77 12</td>
                  <td>Huejotzingo #18</td>
                  <td>1982-15-11</td> 
                  <td style="width: 10px;">35</td>
                  <td>2017-12-11 12:05:32</td>
                  <td>2017-12-08 12:05:32</td>
                  <td class="text-center"><button class="btn btn-warning btnEditarProducto" data-toggle="modal" data-target="#modalEditarProducto"><i class="fa fa-pencil"></i></button></td>
                  <td class="text-center"><button class="btn btn-danger btnEliminarProducto" ><i class="fa fa-times"></i></button></td>
                </tr>-->

            </tbody>
          </table>

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

<!-- Editar Cliente -->

<!-- Ventana Modal Editar Cliente -->

<div id="modalEditarCliente" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <form method="post" role="form">

      <div class="modal-content">

        <div class="modal-header" style="background-color:#3c8dbc">
          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title" style="color: white">Editar Cliente</h4>

        </div>

        <div class="modal-body">

          <div class="box-body">

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" id="editarNombreCliente" value="" name="editarNombreCliente" required>
                <input type="hidden" name="editarIdCliente" value="" id="editarIdCliente">
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="number" min="0" class="form-control input-lg" id="editarDniCliente" value="" name="editarDniCliente" required>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control input-lg" id="editarEmailCliente" name="editarEmailCliente" required>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" data-inputmask="'mask' : '(999) 999-9999'" value="" data-mask class="form-control input-lg" id="editarTelefonoCliente" name="editarTelefonoCliente" required>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input type="text" class="form-control input-lg" id="editarDireccionCliente" value="" name="editarDireccionCliente" required>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask class="form-control input-lg" id="editarNacimientoCliente" name="editarNacimientoCliente" value="" required>
              </div>

            </div>

        </div>

      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-primary">Editar Cliente</button>

      </div>

    </div>

      <?php

        $editarCliente = new ClientsController();
        $editarCliente->editarCliente();


      ?>

    </form>

  </div>

</div>

<?php

    $eliminarCliente = new ClientsController();
    $eliminarCliente->eliminarCliente();

?>