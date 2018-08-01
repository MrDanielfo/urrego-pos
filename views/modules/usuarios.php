<?php

  if($_SESSION['perfil'] == "Vendedor" || $_SESSION['perfil'] == "Especial" ) {

    echo '<script>
            
            window.location = "inicio";

          </script>';

    return; 

  }


?>



<div class="content-wrapper">
  
    <section class="content-header">

      <h1>Usuarios</h1>

      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li class="active">Usuarios</li>
      </ol>

    </section>

    <section class="content">

      <div class="box">

        <div class="box-header with-border">

          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">
            Agregar Usuario
          </button>

        </div>

        <div class="box-body">
          
          <table class="tablas table table-hovered table-striped table-responsive" width="100%">

            <thead>
              <tr>
                <th style="width: 10px;">#</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Foto</th>
                <th>Perfil</th>
                <th>Estado</th>
                <th>Último Login</th>
                <th>Editar</th>
                <th>Eliminar</th>
              </tr>
            </thead>

            <tbody>

              <?php 

                $usuarios = new UsersController();
                $usuarios->mostrarUsuarios();
              ?>
            </tbody>
          </table>

        </div>
      
      </div>

    </section>

</div>

<!-- Ventana Modal Agregar Usuario -->

<div id="modalAgregarUsuario" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <form method="post" role="form" enctype="multipart/form-data">

      <div class="modal-content">

        <div class="modal-header" style="background-color:#3c8dbc">
          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title" style="color: white">Agregar Usuario</h4>

        </div>

        <div class="modal-body">

          <div class="box-body">

            <!-- Nombre Usuario -->

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" placeholder="Nombre" name="nuevoNombre" required>
              </div>

            </div>

            <!-- Fin de Nombre Usuario -->

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" placeholder="Usuario" name="nuevoUsuario" id="nuevoUsuario" required>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control input-lg" placeholder="Password" name="nuevoPassword" required>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select name="nuevoPerfil" class="form-control input-lg">
                  <option value="">Seleccione el Perfil</option>
                  <option value="Administrador">Administrador</option>
                  <option value="Especial">Especial</option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>

            </div>

            <div class="form-group">
              <div class="panel">Subir Imagen</div>
                <input type="file" class="nuevaFoto" name="nuevaFoto" required>
                <p class="help-block">Peso Máximo de la foto 2MB</p>
                <img src="assets/img/usuarios/anonymous.png" alt="anony" class="img-thumbnail previsualizar" width="100px">
              
            </div>

          </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Ingresar Usuario</button>

        </div>

      </div>

      <?php

        $crearUsuario = new UsersController();
        $crearUsuario->crearUsuario();


      ?>

    </form>

  </div>

</div>

<!-- Ventana Modal Editar Usuario -->

<div id="modalEditarUsuario" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <form method="post" role="form" enctype="multipart/form-data">

      <div class="modal-content">

        <div class="modal-header" style="background-color:#3c8dbc">
          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title" style="color: white">Editar Usuario</h4>

        </div>

        <div class="modal-body">

          <div class="box-body">

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" value="">
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" id="editarUsuario"  name="editarUsuario" value="" readonly>
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control input-lg" placeholder="Escriba una nueva contraseña" name="editarPassword">
                <input type="hidden" id="passwordActual" name="passwordActual">
              </div>

            </div>

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select name="editarPerfil" class="form-control input-lg">
                  <option value="" id="editarPerfil">Seleccione el Perfil</option>
                  <option value="Administrador">Administrador</option>
                  <option value="Especial">Especial</option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>

            </div>

            <div class="form-group">
              <div class="panel">Subir Imagen</div>
                <input type="file" class="editarFoto" name="editarFoto">
                <p class="help-block">Peso Máximo de la foto 2MB</p>
                <img id="editarFoto" src="assets/img/usuarios/anonymous.png" alt="anony" class="img-thumbnail previsualizar" width="100px">
                <input type="hidden" name="fotoActual" id="fotoActual">
            </div>

          </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Editar Usuario</button>

        </div>

      </div>

      <?php

        $editarUsuario = new UsersController();
        $editarUsuario->editarUsuario();


      ?>

    </form>

  </div>

</div>

<?php

    $borrarUsuario = new UsersController();
    $borrarUsuario->borrarUsuario();

?>