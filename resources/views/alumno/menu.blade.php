<nav class="navbar navbar-default" role="navigation" id="subTop-navbar-alumno" >
	<div class="container-fluid">
	<!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">

		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">

		        	<span class="sr-only">Toggle navigation</span>
		        	<span class="icon-bar"></span>
		        	<span class="icon-bar"></span>
		        	<span class="icon-bar"></span>

		      </button>


	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">

			<ul class="nav navbar-nav navbar-right">


					<li class="dropdown">
						<a href="{{ Salir::link('alumno/mis_clases.php') }}" target='blank' class='dropdown-toggle hvr-overline-from-left'>Mis Cuadernos</a>
					</li>

					<li class="dropdown">
						<a href="{{ Salir::link('libro_clases_alumno/notas_alumno.php') }}" target='blank' class='dropdown-toggle hvr-overline-from-left'>Mis Notas</a>
					</li>

					<li class="dropdown">
						<a href="{{ Salir::link('libro_clases_alumno/asistencia_alumno.php') }}" target='blank' class='dropdown-toggle hvr-overline-from-left'>Mi Asistencia</a>
					</li>

					<li class="dropdown">
						<a href="{{ Salir::link('libro_clases_alumno/anotaciones_alumno.php') }}" target='blank' class='dropdown-toggle hvr-overline-from-left'>Mis anotaciones</a>
					</li>

					<li class="dropdown">
						<a href="{{ Salir::link('recursos/buscadoralumnos.php?page=0') }}" target='blank' class='dropdown-toggle hvr-overline-from-left'>Explorar Recursos</a>
					</li>

					<li class="dropdown">
						<a href="{{ Salir::link('mensajeria') }}" target='blank' class='dropdown-toggle hvr-overline-from-left'>Comunicación</a>
					</li>				

				
			</ul>

		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>