<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">

    <title>@yield('title', 'WebClass')</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/calendar/calendar.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

    <script src="{{ asset('assets/js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    
  </head>
  <body>

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
                        @yield('menu')
                        <li class="dropdown" align="center">
                            <a href="#" class="dropdown-toggle hvr-overline-from-left opciones" data-toggle="dropdown" >Opciones<b class="caret"></b></a>
                            <ul class="dropdown-menu">      
                                <li ><a class="chatsoporte" href="/login">Chat Soporte</a></li>
                                <li ><a class="ayuda" href="/login">Ayuda</a></li>                                
                                <li ><a class="salir" href="/logout">Salir</a></li>                     
                            </ul>
                        </li>                                
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    
    <div class="sidebar-right" >
        
        <ul class="nav nav-pills nav-stacked">   
        

        </ul>
    </div>
       
    <div id="wrap">
      <div class="container" id="container-alumno">
        @yield('content')
      </div>
    </div>
    
    @include ('footer') 


        <script src="{{ asset('assets/js/script_estilos.js') }}"></script>

        <!-- Calendar -->
            <script src="{{ asset('assets/js/underscore/underscore-min.js') }}"></script>
            <script src="{{ asset('assets/js/jstimezonedetect/jstz.min.js') }}"></script>
            <script src="{{ asset('assets/js/calendar/calendar.js') }}" src="js/calendar.js"></script>
            <script src="{{ asset('assets/js/calendar/language/es-ES.js') }}" src="js/language/es-ES.js"></script>
            <script src="{{ asset('assets/js/calendar/app.js') }}" src="js/app.js"></script>
    </body>
</html>