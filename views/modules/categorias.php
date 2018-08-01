<?php

  if($_SESSION['perfil'] == "Vendedor") {

    echo '<script>
            
            window.location = "inicio";

          </script>';

    return; 

  }


?>


<div class="content-wrapper">
  
    <section class="content-header">

      <h1>Categorías</h1>

      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li class="active">Categorías</li>
      </ol>

    </section>

    <section class="content">

      <div class="box">

        <div class="box-header with-border">

          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCategoria">
            Agregar Categorías
          </button>

        </div>

        <div class="box-body">
          
          <table class="tablas table table-hovered table-striped table-responsive" width="100%">

            <thead>
              <tr>
                <th style="width: 10px;">#</th>
                <th>Nombre</th>

              
                <th class="text-center">Editar</th>
                <?php
                if($_SESSION['perfil'] == "Administrador") {

          echo '<th>Eliminar</th>';

                }


                ?>
                
              </tr>
            </thead>

            <tbody>

              <?php 

                $categorias = new CategoriesController();
                $categorias->mostrarCategorias();


              ?>

            </tbody>
          </table>

        </div>
      
      </div>

    </section>

</div>

<!-- Ventana Modal Agregar Categoría -->

<div id="modalAgregarCategoria" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <form method="post" role="form">

      <div class="modal-content">

        <div class="modal-header" style="background-color:#3c8dbc">
          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title" style="color: white">Agregar Categoría</h4>

        </div>

        <div class="modal-body">

          <div class="box-body">

            <!-- Nombre Categoría -->

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <input type="text" class="form-control input-lg" placeholder="Nombre de Categoría" name="nuevaCategoria" required>
              </div>

            </div>

            <!-- Fin de Nombre Categoría -->

        </div>

      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-primary">Ingresar Categoría</button>

      </div>

    </div>

      <?php

        $crearCategoria = new CategoriesController();
        $crearCategoria->crearCategoria();


      ?>

    </form>

  </div>

</div>

<!-- Ventana Modal Editar Usuario -->

<div id="modalEditarCategoria" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <form method="post" role="form">

      <div class="modal-content">

        <div class="modal-header" style="background-color:#3c8dbc">
          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title" style="color: white">Editar Categoría</h4>

        </div>

        <div class="modal-body">

          <div class="box-body">

            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" id="editarCategoria" name="editarCategoria" value="">
                <input type="hidden" name="idCategoria" id="idCategoria" value="">
              </div>

            </div>

          </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>

        </div>

      </div>

      <?php

        $editarCategoria = new CategoriesController();
        $editarCategoria->editarCategoria();


      ?>

    </form>

  </div>

</div>

<?php

    $eliminarCategoria = new CategoriesController();
    $eliminarCategoria->eliminarCategoria();

?>