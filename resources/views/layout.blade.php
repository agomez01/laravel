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
        <div class="container row">

            <div class="navbar-header">
                <button data-toggle="collapse-side" data-target=".side-collapse" data-target-2=".side-collapse-container" type="button" class="navbar-toggle pull-left">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="top_line col-md-12 col-sm-12"><!-- top_line -->    
    <div class="top_usuario" style="color:#fff;">    
    </div>
    <div class="top_btn" title="Salir">
        <a href="#" >
            Salir
            <img src="../assets/img/webclass-btn-salir.png" alt="Salir" width="24" height="24"   />
        </a>
    </div>

    <div class="top_btn" title="Ayuda">
        <a href="http://webclass.com/tutoriales" target="_blank" >
            Ayuda
            <img src="../assets/img/webclass-btn-pregunta.png" alt="Ayuda" width="24" height="24"/>
        </a>
    </div>
    <div class="top_btn" title="Soprte">
        <a id="islpronto_link" href="mailto:soporte@webclass.com">
            Chat Soporte
            <img src="../assets/img/webclass-btn-soporte.png" alt=">Chat Soporte" name="islpronto_image" width="24" height="24" id="islpronto_image" style="border:none"/>
        </a>
    </div>
    <div class="top_btn">
        <a href="#" title="Cambiar tema">
            Cambiar tema
            <img src="../assets/img/webclass-btn-configuracion.png" alt="Cambiar tema"  width="24" height="24"/>
        </a>
    </div>
    <div class="top_selector" title="Cambiar rol de usuario">
        <img src="../assets/img/webclass-btn-cambiar_vista.png" width="24" height="24"/>
        <span>    
            <div id="cambioColegio">
                <select name="comboboxcolegio" onChange="">
                    <option  value="">Cambiar vista</option>         
                    <option value=""></option>              
                </select>
            </div>
        </span>     
    </div>
</div>
            
            <div class="navbar-inverse side-collapse in">            
                <nav role="navigation" class="navbar-collapse">                    
                    <ul class="nav navbar-nav">                                    
                        @yield('menu')                                                 
                    </ul>
                </nav>
            </div>
        </div>
    </header>  

    
       
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
            <script src="{{ asset('assets/js/reloj/reloj.js') }}" src="js/app.js"></script>
    </body>
</html>