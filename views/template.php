<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Inventory System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" href="assets/img/plantilla/icono-blanco.png">

  <!-- Plugins de CSS -->
 
  <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="assets/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.css">
  <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="assets/plugins/iCheck/all.css">

  <link rel="stylesheet" href="assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">

  <link rel="stylesheet" href="assets/bower_components/morris.js/morris.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- Plugins de Javascript -->

  <!-- jQuery 3 -->
	<script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="assets/bower_components/fastclick/lib/fastclick.js"></script>
  <script src="assets/dist/js/adminlte.min.js"></script>
  <script src="assets/dist/js/demo.js"></script>
  <script src="assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="assets/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="assets/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
  <script src="assets/plugins/sweetAlert/sweetAlert-all.js"></script>
  <script src="assets/plugins/iCheck/icheck.min.js"></script>
  <!-- InputMask -->
  <script src="assets/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <!-- jquery Number -->
  <script src="assets/plugins/jQuery-number/jquery.number.min.js"></script>
  <script src="assets/bower_components/moment/min/moment.min.js"></script>
  <script src="assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

  <script src="assets/bower_components/raphael/raphael.min.js"></script>
  <script src="assets/bower_components/morris.js/morris.min.js"></script>
  <script src="assets/bower_components/chart.js/Chart.min.js"></script>

</head>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
<!-- Site wrapper -->


  <?php



  if(isset($_SESSION['validar']) && $_SESSION['validar'] == 'ok') {

    print('<div class="wrapper">');

    include 'modules/header.php';

    include 'modules/menu.php';

    if(isset($_GET['ruta'])) {

      $ruta = $_GET['ruta']; 
      
      if( $ruta == "inicio" || 
          $ruta == "usuarios" || 
          $ruta == "categorias" || 
          $ruta == "productos" || 
          $ruta == "clientes" || 
          $ruta == "ventas" || 
          $ruta == "crear-ventas" ||
          $ruta == "editar-ventas" ||
          $ruta == "reportes" ||
          $ruta == "logout") {

        include 'modules/'.$ruta.'.php';
      } else {
        include 'modules/404.php';
      }
    } else {

      $ruta = 'index';

    }

    include 'modules/footer.php';

    print('</div>');

  }  else {

    include 'modules/login.php';

  }
  

  ?>
  


<script src="assets/js/plantilla.js"></script>
<script src="assets/js/usuarios.js"></script>
<script src="assets/js/categorias.js"></script>
<script src="assets/js/productos.js"></script>
<script src="assets/js/clientes.js"></script>
<script src="assets/js/ventas.js"></script>
<script src="assets/js/imprimir-ventas.js"></script>
<script src="assets/js/reportes.js"></script>

</body>
</html>

