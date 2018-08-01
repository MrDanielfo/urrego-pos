<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

          <?php  

           if($_SESSION['perfil'] == "Administrador") {

      echo '<li class="active">
              <a href="inicio"><i class="fa fa-home"></i><span>Inicio</span></a>
            </li>
            <li class="active">
              <a href="usuarios"><i class="fa fa-user"></i><span>Usuarios</span></a>
            </li>';

           }


            if($_SESSION['perfil'] == "Administrador" || $_SESSION['perfil'] == "Especial" ) {


      echo  '<li class="active">
              <a href="categorias"><i class="fa fa-th"></i><span>Categorías</span></a>
            </li>
            <li class="active">
              <a href="productos"><i class="fa fa-product-hunt"></i><span>Productos</span></a>
            </li>';


            }


            if($_SESSION['perfil'] == "Administrador" || $_SESSION['perfil'] == "Vendedor" ) { 


     echo  '<li class="active">
              <a href="clientes"><i class="fa fa-users"></i><span>Clientes</span></a>
            </li>'; 

            }

            if($_SESSION['perfil'] == "Administrador" || $_SESSION['perfil'] == "Vendedor" ) { 


    echo   '<li class="treeview">
              <a href="#">
                <i class="fa fa-list-ul"></i>
                <span>Ventas</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-right pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="ventas">
                    <i class="fa fa-circle-o"></i>
                    <span>Administrar Ventas</span>
                  </a>
                </li>
                <li>
                  <a href="crear-ventas">
                    <i class="fa fa-circle-o"></i>
                    <span>Crear Venta</span>
                  </a>
                </li>';

            }

            if($_SESSION['perfil'] == "Administrador") {

    echo       '<li>
                  <a href="reportes">
                    <i class="fa fa-circle-o"></i>
                    <span>Reporte de Ventas</span>
                  </a>
                </li>';

            }


           ?>
              </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>