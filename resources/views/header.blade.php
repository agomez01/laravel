	<style>

			

	</style>




	<header class="alumno-header" >
		<nav class="navbar navbar-default" role="navigation" id="top-navbar-alumno">
			  <div class="container-fluid">

				    <div class="navbar-header">
					      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					      </button>
				          <a class="navbar-brand" href="/">{{ Session::get('full-name') }}</a>
				    </div>

				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
							@if ( Session::get('logeado') )
								<li class="dropdown"> <a href="{{ Salir::link() }}" target='blank' class='dropdown-toggle hvr-overline-from-left'>Proyectos</a></li>
								<li class="dropdown"><a href="http://capacitacion.webescuela.cl"  target='blank'  class='dropdown-toggle hvr-overline-from-left'>Ayuda</a></li>
								<li class="dropdown"><a href="/logout" class='dropdown-toggle hvr-overline-from-left'>Salir</a></li>				
							@endif
						</ul>
			    	</div>
			  </div>
		</nav>

	</header>

<!--
	<header role="banner" class="navbar navbar-fixed-top navbar-inverse">
    	<div class="container">
			<div class="navbar-header">
				<button data-toggle="collapse-side" data-target=".side-collapse" data-target-2=".side-collapse-container" type="button" class="navbar-toggle pull-left">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<div class="navbar-inverse side-collapse in">
				<nav role="navigation" class="navbar-collapse">
					<ul class="nav navbar-nav">
							@if ( Session::get('logeado') )

								<li ><a href="{{ Salir::link() }}" target='blank'>Proyectos</a></li>
								<li ><a href="/login">Chat Soporte</a></li>
								<li ><a href="/login">Ayuda</a></li>
								<li ><a href="/logout">Salir</a></li>				

							@endif
					</ul>
				</nav>
			</div>
		</div>
    </header>-->