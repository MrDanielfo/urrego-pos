<?php

  $item = null;
  $valor = null;

  $ventas = SellsController::rangoFechas($item, $valor);

  $vendedores = SellsController::mostrarVendedor($item, $valor);

  $arrayVendedores = array();

  $arraylistaVendedores = array();

  foreach($ventas as $key => $valueVentas) {

    foreach($vendedores as $key => $valueVendedores ) {

      if($valueVendedores["id"] == $valueVentas["id_vendedor"]) {

        array_push($arrayVendedores, $valueVendedores["nombre"]); 

        $arraylistaVendedores = array($valueVendedores["nombre"] => $valueVentas["neto"]); 

        
        foreach($arraylistaVendedores as $key => $valueLista) {

             $sumaTotalVendedores[$key] += $valueLista; 

          }
        

      }

      
    }

  }

  $noRepetirNombres = array_unique($arrayVendedores);
?>


<div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Vendedores</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body chart-responsive">
      <div class="chart-responsive" id="bar-chart-vendedores" style="height: 300px;"></div>
    </div>
            <!-- /.box-body -->
</div>

<script>
  
  var bar = new Morris.Bar({
      element: 'bar-chart-vendedores',
      resize: true,
      data: [
      <?php

      foreach($noRepetirNombres as $value) {

        echo '{y: "'. $value  .'", a: '. $sumaTotalVendedores[$value] .' },';
      }


      ?>
        
      ],
      barColors: ['#0af'],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['ventas'],
      preUnits: '$',
      hideHover: 'auto'
    });
</script>