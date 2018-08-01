<?php

  if($_SESSION['perfil'] == "Especial") {

    echo '<script>
            
            window.location = "inicio"

          </script>';

    return; 

  }


?>

<div class="content-wrapper">
  
    <section class="content-header">

      <h1>Administrar Ventas</h1>

      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li class="active">Ventas</li>
      </ol>

    </section>

    <section class="content">

      <div class="box">

        <div class="box-header with-border">

          <a href="crear-ventas">
            <button class="btn btn-primary">
              Agregar Venta
            </button>
          </a>

          <button type="button" class="btn btn-default pull-right" id="daterange-btn">
            <span>
              <i class="fa fa-calendar"></i> Rango de fecha
            </span>

            <i class="fa fa-caret-down"></i>
          </button>

        </div>

        <div class="box-body">
          
          <table class="tablas table table-hovered table-striped table-responsive" width="100%">

            <thead>
              <tr>
                <th style="width: 10px;">#</th>
                <th>Código de Factura</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Forma de Pago</th>
                <th>Neto</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Imprimir</th>
                
         <?php

            if($_SESSION['perfil'] == "Administrador") {

         echo   '<th>Editar</th>
                 <th>Eliminar</th>';

            }

            
            ?>
                
              </tr>
            </thead>

            <tbody>

              <?php 

                if(isset($_GET['fechaInicial'])) {

                $fechaInicial = $_GET['fechaInicial'];
                $fechaFinal = $_GET['fechaFinal'];

              } else {

                $fechaInicial = null;
                $fechaFinal = null; 

              }


                $ventas = SellsController::rangoFechas($fechaInicial, $fechaFinal);

                foreach($ventas as $key => $value) {

                  echo '<tr>
                          <td style="width: 10px;">'. ($key + 1)  .'</td>
                          <td>'. $value['codigo']  .'</td>';

                 

                    $itemCliente = "id";
                    $valorCliente = $value['id_cliente'];

                    $clientes = SellsController::mostrarClientes($itemCliente, $valorCliente);

                    echo '<td>'. $clientes['nombre']  .'</td>';

                    $itemVendedor = "id";
                    $valorVendedor = $value['id_vendedor'];
                        
                    $vendedor = SellsController::mostrarVendedor($itemVendedor, $valorVendedor);

                    echo '<td>'. $vendedor['nombre']  .'</td>';
                                
                    echo '<td>'. $value['metodo_pago']  .'</td>
                          <td>$ '. number_format($value['neto'], 2) .'</td>
                          <td>$ '. number_format($value['total_venta'], 2) .'</td> 
                          <td>'. $value['fecha']  .'</td>
                          <td class="text-center"><button class="btn btn-success btnImprimirVenta" codigoVenta="' . $value['codigo'] . '"><i class="fa fa-print"></i></button></td>';
          

                    if($_SESSION['perfil'] == "Administrador") {

                     echo  '<td class="text-center"><a href="index.php?ruta=editar-ventas&idVenta=' . $value['id'] . '"><button class="btn btn-warning btnEditarVenta"><i class="fa fa-pencil"></i></button></a></td>
                           <td class="text-center"><button class="btn btn-danger btnEliminarVenta" idVenta="' . $value['id'] . '"><i class="fa fa-times"></i></button></td>
                      </tr>'; 

                    }

                }


              ?>
                
            </tbody>
          </table>

      <?php

          $eliminarVenta = new SellsController();
          $eliminarVenta->eliminarVenta();

      ?>

        </div>
      
      </div>

    </section>

</div>


  