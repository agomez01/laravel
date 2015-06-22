<header>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">Login Webclass</a>

    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

<ul class="nav navbar-nav">
	

</ul>


		<ul class="nav navbar-nav navbar-right">

			@if ( Session::get('logeado') )

				<li class="active "><a href="/admin/compras" class='hvr-overline-from-left'>Menu 1 <span class="sr-only">(current)</span></a></li>				


			
				<li class="dropdown">

					<a href="#" class="dropdown-toggle hvr-overline-from-left" data-toggle="dropdown">Menu 2 <b class="caret"></b></a>
					
					<ul class="dropdown-menu">
						<li><a href="/admin/">Sub Menu 1</a></li>
						<li><a href="/admin/">Sub Menu 2</a></li>
						<li class="divider"></li>
						<li><a href="/admin/users">Sub Menu 3</a></li>
					</ul>
				</li>

			@endif

			<li class="dropdown">
				<a href="#" class="dropdown-toggle hvr-overline-from-left" data-toggle="dropdown">Opciones <b class="caret"></b></a>

				<ul class="dropdown-menu">

					@if ( Session::get('logeado') )			
						<li><a href="/logout">Cerrar Sesión</a></li>
        			@endif

					
				</ul>
			</li>


			
		</ul>




    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</header>