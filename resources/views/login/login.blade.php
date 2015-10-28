<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="\assets\img\favicon.ico">

    <title>@yield('title', 'WebClass')</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

    <script src="{{ asset('assets/js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-1.11.3.min.js') }}"></script>
      <script src="{{ asset('assets/js/funciones.js') }}"></script>
<script>
    $(document).ready(function(){    
            $("#show").click(function(){
            $("#recuperar").show();
            });
        });
</script>   
  
  </head>
  <body style="background:#F4F4F4;">  
<div class="collapse navbar-collapse">

    <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="">
                <img alt="" src="../../assets/img/isotipo_mono.svg" width="25">
            </a>
        </div>
        <ul class="nav navbar-nav header-nav">
            <li ><a href="http://webclass.com" target="_blank">webclass.com</a></li>
            <li><a href="http://www.webclass.com/tutoriales/inicio/" target="_blank">Capacitación</a></li>
            <li><a href="#" onclick="javascript:window.open('http://proyecto.webescuela.cl/sistema/testing/soporte.php', '' , 'width=700 , height=800' , true)">Soporte</a></li>
        </ul>
    </nav>
</div>
 <div class="col-md-12 box-alertas" width="300px">
            <div class="alert alert-success password-login" id="recuperar" style="display:none;">
                <button type="button" class="close"  data-dismiss="alert">&times;</button>
                <p>Ingrese nombre de usuario y presione 'Olvidé mi contraseña'. Le enviaremos la contraseña a su correo.</p>
                <a href="http://www.webclass.com/tutoriales/recuperar-contrasena-de-usuario/" target="_blank">Ver video explicativo</a>
            </div>
                {{-- Preguntamos si hay algún mensaje de error y si hay lo mostramos  --}}               

                @if ($errors->any())
                  <div class="alert alert-danger error-login">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Por favor corrige los siguentes errores:</strong>
                    <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                    </ul>                            
                  </div>
                @endif
        </div>

    <div class="row-fluid contenedor-login col-sm-12 col-xs-12" >

        <div class="col-md-3 col-sm-12 col-xs-12 col-md-offset-5 box-login">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="#" class="active" id="login-form-link"><img src="assets/img/logo_flat.svg" width="180"></a>
                        </div>
                    </div>
                    <hr>
                </div>
                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form  id="login-form" action="{{ URL::to('login') }}" method="post" role="form" style="display: block;">
                                <div class="form-group">
                                    <input type="text" name="username" id="username" tabindex="1" class="form-control box-input-1" placeholder="Usuario" value="">
                                    <a class="img-input-1"></a>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" tabindex="2" class="form-control box-input-2" placeholder="Contraseña">
                                    <span class="img-input-2"></span>
                                </div>

                                @if(Session::has('mensaje_error'))
                                    <div class="alert alert-danger error-login">
                                {{ Session::get('mensaje_error') }}
                                    </div>                                        
                                @endif
                        
                                <!--
                                <div class="form-group text-center">
                                    <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                    <label for="remember">Recordar contraseña</label>
                                </div>
                            -->
                                <div class="form-group">                                                                                                                                                                           
                                    <div class="text-center" id="show" >
                                        <a href="#"  tabindex="5" >Olvidé mi contraseña</a>                                                
                                    </div>
                                    <div>
                                         <input class=" btn-success btn-entrar" type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Entrar">
                                    </div>                             
                                </div>

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
 
    </div>

    <div class=" col-md-12 row box-footer-1">       
        <div class="col-md-9 box-footer-2">
            <div class="img-pie-1">
                <img src="../../assets/img/support.svg" width="55" alt="">
            </div> 
            <div class="texto-pie-1">
                <span>SERVICIO ATENCIÓN AL CLIENTE</span>
                <p>Tel.: strong(+56) 22 869 9100 <br>
                E-mail: sac@webclass.com</p>
            </div>            
        </div>
    </div>

  </body>
</html>
