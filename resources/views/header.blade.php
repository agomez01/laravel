	<style>

			#top-navbar-alumno
			{
					margin:0; padding:0; border-radius:0; border:0; background:#CCC;
			}

			#subTop-navbar-alumno
			{
				margin:0; padding:0; border-radius:0; border:0;
			}

	</style>

	<header class="alumno-header" >
		<nav class="navbar navbar-default" role="navigation" id="top-navbar-alumno">
			  <div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">

					      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					      </button>

				          <a class="navbar-brand" href="/">{{ Session::get('full-name') }}</a>

				    </div>

				    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

						<ul class="nav navbar-nav navbar-right">

							@if ( Session::get('logeado') )

								<li class="dropdown"><a href="/login" class='dropdown-toggle hvr-overline-from-left'><imgCambiar Tema<span class="sr-only">(current)</span></a></li>

								<li class="dropdown"><a href="/login" class='dropdown-toggle hvr-overline-from-left'>Chat Soporte<span class="sr-only">(current)</span></a></li>

								<li class="dropdown"><a href="/login" class='dropdown-toggle hvr-overline-from-left'>Ayuda<span class="sr-only">(current)</span></a></li>

								<li class="dropdown"><a href="/logout" class='dropdown-toggle hvr-overline-from-left'>Salir<span class="sr-only">(current)</span></a></li>				

							@endif
							
						</ul>

			    	</div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
		</nav>

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

							@if ( Session::get('logeado') )

								<li class="dropdown"><a href="/admin/compras" class='dropdown-toggle hvr-overline-from-left'>Mis Cuadernos<span class="sr-only">(current)</span></a></li>

								<li class="dropdown"><a href="/admin/compras" class='dropdown-toggle hvr-overline-from-left'>Mis Notas<span class="sr-only">(current)</span></a></li>

								<li class="dropdown"><a href="/admin/compras" class='dropdown-toggle hvr-overline-from-left'>Mi Asistencia<span class="sr-only">(current)</span></a></li>

								<li class="dropdown"><a href="/admin/compras" class='dropdown-toggle hvr-overline-from-left'>Explorar Recursos<span class="sr-only">(current)</span></a></li>

								<li class="dropdown"><a href="/logout" class='dropdown-toggle hvr-overline-from-left'>Comunicación<span class="sr-only">(current)</span></a></li>				

							@endif
							
						</ul>

			    	</div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
		</nav>
	</header>