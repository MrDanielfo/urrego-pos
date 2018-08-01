<header class="main-header">
	<a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">
      	<img src="assets/img/plantilla/icono-blanco.png" class="img-responsive" style="padding: 10px;">
      </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
      	<img src="assets/img/plantilla/logo-blanco-lineal.png" class="img-responsive" style="padding: 10px 0px;">
      </span>
    </a>
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
	    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
	        <span class="sr-only">Toggle navigation</span>
	    </a>
      <!-- Perfil de Usuario -->
      	<div class="navbar-custom-menu">
	      	<ul class="nav navbar-nav">
	      		<li class="dropdown user user-menu">
	      			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
	      				<?php if($_SESSION['foto'] != " ") {
	      					echo '<img src="' . $_SESSION['foto'] .'" class="user-image" alt="User Image">';
	      				} else {
      						echo "<img src='assets/img/usuarios/anonymous.png' class='user-image' alt='User Image'>";
	      					
      					}  ?>
	              		<span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
	            	</a>
	            	<ul class="dropdown-menu">
		              <!-- Menu Body -->
		              	<li class="user-body">
			                <div class="pull-right">
				              	<a href="logout" class="btn btn-default btn-flat">Salir</a>
			                </div>
		                <!-- /.row -->
		              	</li>
	            	</ul>
	  			</li>
      		</ul>
  		</div>
  	</nav>
</header>