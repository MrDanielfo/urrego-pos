<?php

  $item = null;
  $valor = null;

  $ventas = SellsController::rangoFechas($item, $valor);

  $clientes = SellsController::mostrarClientes($item, $valor);


  $arrayClientes = array();

  $arraylistaClientes = array();

  foreach($ventas as $key => $valueVentas) {

    foreach($clientes as $key => $valueClientes ) {

      if($valueClientes["id"] == $valueVentas["id_cliente"]) {

        array_push($arrayClientes, $valueClientes["nombre"]); 

        $arraylistaClientes = array($valueClientes["nombre"] => $valueVentas["neto"]); 

        
        foreach($arraylistaClientes as $key => $valueLista) {

            $sumaTotalClientes[$key] += $valueLista; 

          }

      }
 
    }

  }

  $noRepetirNombres = array_unique($arrayClientes);


?>

<div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">Compradores</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body chart-responsive">
      <div class="chart-responsive" id="bar-chart-compradores" style="height: 300px;"></div>
    </div>
            <!-- /.box-body -->
</div>

<script>
  
  var bar = new Morris.Bar({
      element: 'bar-chart-compradores',
      resize: true,
      data: [
        <?php

        foreach($noRepetirNombres as $value) {

          echo '{y: "'. $value  .'", a: '. $sumaTotalClientes[$value] .' },';
        }

      ?>
      ],
      barColors: ['#f6a'],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['compras'],
      preUnits: '$',
      hideHover: 'auto'
    });

</script>