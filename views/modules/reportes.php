<?php

  if($_SESSION['perfil'] == "Vendedor" || $_SESSION['perfil'] == "Especial") {

    echo '<script>
            
            window.location = "inicio";

          </script>';

    return; 

  }


?>

<div class="content-wrapper">
  
    <section class="content-header">

      <h1>Reportes de Ventas</h1>

      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li class="active">Reportes</li>
      </ol>

    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">

          <div class="input-group">
              
            <button type="button" class="btn btn-default" id="daterange-btnreportes">
                <span>
                  <i class="fa fa-calendar"></i> Rango de fecha
                </span>

                <i class="fa fa-caret-down"></i>
            </button>

          </div>


          <div class="box-tools pull-right">

            <?php
                if(isset($_GET['fechaInicial'])) {

                $fechaInicial = $_GET['fechaInicial'];
                $fechaFinal = $_GET['fechaFinal'];

                echo '<a href="views/modules/descargar-reporte.php?reporte=reporte&fechaInicial='. $fechaInicial .'&fechaFinal='. $fechaFinal .'">';

              } else {
                echo '<a href="views/modules/descargar-reporte.php?reporte=reporte">';
              }


            ?>
              <button class="btn btn-success" style="margin-top: 5px">Descargar reporte en Excel</button>
            </a>

          </div>
        </div>


        <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
                
                <?php

                  include "reportes/grafico-ventas.php";

                ?>
              </div>
              <div class="col-md-6 col-xs-12">
                <?php

                  include "reportes/mas-vendidos.php";
                  
                ?>
              </div>
              <div class="col-md-6 col-xs-12">
                <?php

                  include "reportes/vendedores.php";
                  
                ?>
              </div>

              <div class="col-md-6 col-xs-12">
                <?php

                  include "reportes/compradores.php";
                  
                ?>
              </div>
            </div>
          
        </div>
        <!-- /.box-body -->
        
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->