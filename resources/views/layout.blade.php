<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="\assets\img\favicon.ico">

    <title>@yield('title', 'WebClass')</title>

    {{-- Bootstrap --}}
    
    {{!! HTML::style('assets/css/bootstrap.min.css') !!}}

	{{-- Estilos --}}
    {{ HTML::style('assets/css/style.css', array('media' => 'screen')) }}
    {{ HTML::style('assets/css/iconos.css', array('media' => 'screen')) }}
    {{ HTML::style('assets/css/hover-min.css', array('media' => 'screen')) }}

    {{-- jQuery UI v1.9.2--}}
    {{ HTML::style('assets/css/jqueryui.css', array('media' => 'screen')) }}

    {{-- Chosen --}}
    <!--{{ HTML::style('script/chosen/style.css', array('media' => 'screen')) }}-->
    {{ HTML::style('script/chosen/prism.css', array('media' => 'screen')) }}
    {{ HTML::style('script/chosen/chosen.min.css', array('media' => 'screen')) }}

    {{-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries --}}
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      {{ HTML::script('assets/js/html5shiv.js') }}
      {{ HTML::script('assets/js/respond.min.js') }}
    <![endif]-->
  </head>
  <body>

    @include ('header') 

    <div id="wrap">
      <div class="container">
        <h1>@yield('content')</h1>
      </div>
    </div>

    {{-- jQuery (necessary for Bootstrap's JavaScript plugins) --}}

    {{-- jQuery 1.11.0 --}}
    {{ HTML::script('assets/js/jquery.min.js') }}

    {{-- Include all compiled plugins (below), or include individual files as needed --}}
    {{ HTML::script('assets/js/bootstrap.min.js') }}

    {{ HTML::script('assets/js/jquery-ui-1.9.2.custom.min.js') }}
   
   	{{ HTML::script('script/chosen/chosen.jquery.min.js') }}
    {{ HTML::script('script/chosen/prism.js') }}
    {{ HTML::script('assets/js/admin.js') }}
    {{ HTML::script('assets/js/jquery.number.min.js') }}
  </body>
</html>