<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">

    <title>@yield('title', 'WebClass')</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

    <script src="{{ asset('assets/js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    
  </head>
  <body>
    
    <style>

      #container-alumno{
          width:100%; margin:0; padding:0;
      }

    </style>
    
    <div id="wrap">
      <div class="container" id="container-alumno">
        @yield('content')
      </div>
    </div>
    
    
  </body>
</html>