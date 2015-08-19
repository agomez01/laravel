@extends ('evaluacion/layout')

@section ('title') Rendir Evaluación @stop

@section ('content')

<div id="close-toggle2"></div>  


 <div id="wrapper">

        <!-- Page Content -->
        <div id="page-content-wrapper">


        
       <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog modal-sm">
        <div class="modal-content" style="text-align:center; padding:25px;">
          <img src="{{ asset('assets/img/loader.gif') }}" style="width:25%;"/ >
          <br>
          Guardando respuestas...
        </div>
      </div>
    </div>
    

    <input type='hidden' id='porpagina' value="{{ $test['porpagina'] }}">
    <input type='hidden' id='pag' value="1">

    <input type='hidden' id='idevaluacion' value='{{ base64_encode($test["id"]) }}' />
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id='tokenEvaluacion'>

    <div class='cortina_pause'>
        <div class='jumbotron'>
            <h2>Evaluación pausada!</h2>
            <div class='div_btn'>
                <button class='btn btn btn-primary btn-lg'  id='btn_continuar'>Continuar</button>
                <button class='btn btn-default btn-lg'      id='btn_pausar_salir'>Guardar y salir</button>
            </div>
                
        </div>
    </div>                          
                        
     <div class="col-md-9 col-sm-8 col-xs-12" id="eva-leftSection">

        <section id="eva-membretePrueba" >
            <ul class="list-group">
              <li class="list-group-item info-general">
                    <h3>

                        {{ $test["nombre"] }}

                    </h3>
              </li>
              <li class="list-group-item info-alumno">

                  <p>
                        Alumno: {{ Session::get('full-name') }}
                  </p>

                  <p>
                        Curso: {{ Session::get('nombre-curso') }}
                  </p>

                  <p>
                        Fecha: {{  date("d-m-Y", time())  }}
                  </p>

              </li>
              <li class="list-group-item info-instucciones">
              
                <strong>INSTRUCCIONES</strong><br><br>
                <p> <?=  $test["instrucciones"];  ?></p>
              </li>
              
            </ul>

        </secction>


        <section>

            @if (count($preguntas) > 0 )
            
                @foreach ($preguntas as $pos=>$val)


                    {!! Form::open( ['route' => ['evaluacion',''], 'method' => 'UPDATE', 'id' => 'resp_'.$val["data"]->id ] ) !!}

                    {!! Form::close() !!}
                    
                    
                    
                    @if( !isset( $val["respuestaAlumno"]->respuesta ) )

                        
                        <div  data-id="<?= $test['id'].'_'.$val['data']->id.'_'.$val['data']->tipo ?>" class="jumbotron div_pregunta eva-boxPregunta"> 
                        

                    @else
                        
                        
                        <div data-id="<?= $test['id'].'_'.$val['data']->id.'_'.$val['data']->tipo ?>" class="jumbotron div_pregunta eva-boxPreguntaResp"> 
                        

                    @endif                  
                            @if ($val["recurso"] != "")
                                <div class="eva-casillaImagen">
                                    @include('evaluacion/preguntas', ['test' => $test , 'pregunta' => $val, 'seccion' => 'recurso'])
                                </div>
                            @endif

                            <div class="eva-casillaTexto">

                                <h5>

                                    <strong> Pregunta N°{{ $val["numero"] }} - <?= $val["data"]->texto ?> </strong>

                                </h5>

                            </div>

                            <div class="eva-casillaCuerpo">

                                @include('evaluacion/preguntas', ['test' => $test , 'pregunta' => $val, 'seccion' => 'cuerpo'])

                            </div>

                            <p style="text-align:right;" id="respMessege{{ $val['data']->id }}">

                                    @if( !isset( $val["respuestaAlumno"]->respuesta ) ) 

                                        <a class="btn btn-primary btn-lg eva-btnEnviar" role="button" >Enviar respuesta</a>

                                    @else

                                        <input type="button" class="btn btn-success btn-md" value="Respuesta Enviada!!">

                                    @endif
                            </p>
                    </div>


                @endforeach
                
                
                <div id='navegacion'>
                    <button class='btn btn-success' id='pag_ant' disabled><span class='glyphicon glyphicon-backward' aria-hidden="true"></span></button>
                    <button class='btn btn-info'    id='num_pag'>1</button>
                    <button class='btn btn-success' id='pag_sig'><span class='glyphicon glyphicon-forward' aria-hidden="true"></span></button>
                </div>
                <a class="btn btn-primary btn-lg eva-btnEnviartododown"  role="button" id="eva-btnEnviarTodo" data-test='{{ $test["id"] }}'>Enviar Todo y Terminar</a>
                    

            @else
                No existen preguntas.

            @endif

        </section>
    </div>
     </div>
        <!-- /#page-content-wrapper -->
 <!-- Sidebar -->
<div id="sidebar-wrapper">
    <div id="eva-rightSection" class="col-md-3 col-sm-4 col-xs-12">
        <section class="eva-Indicadores" >
            
            <ul class="list-group">
                <li class="list-group-item info-prueba">
                    Id Evaluación: {{ $test["id"] }}<br>
                    Profesor: {{ $test["autor"] }}
                </li>
            
                <li class="list-group-item info-tiempo">
                    Tiempo disponible: <span id='duracion_test'>{{ $test["duracion"] }} minutos</span>
                    <br><br>
                    Tiempo Restante: <span id='cronometro'></span>
                </li>
            
                <li class="list-group-item">
                    Preguntas
                    
                    @if (count($preguntas) > 0 )
                        @include('evaluacion/preguntas', ['test' => $test , 'pregunta' => $val, 'seccion' => 'miniaturas'])
                    @endif
                </li>
            </ul>
            
        </secction>

        <section class="eva-controles" >
            <h3 style="text-align: center;">

                <a class="btn btn-primary btn-lg"  role="button" id="eva-btnEnviarTodo" data-test='{{ $test["id"] }}'>Enviar Todo y Terminar</a>

                <a class="btn btn-default btn-lg" role="button" id="pausa">Pausar <span class='glyphicon glyphicon-pause' aria-hidden="true"></span></a>

                <a class="btn btn-danger btn-lg" role="button" id="close-toggle">Ocultar <span class='glyphicon glyphicon-info-sign' aria-hidden="true"></span></a>
               


            </h3>
        </secction>
    </div>

    <button id="eva-lanzaLoader" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm" style="display:none;"></button>

   
    

    <input type='hidden' id='porpagina' value="{{ $test['porpagina'] }}">
    <input type='hidden' id='pag' value="1">

    <input type='hidden' id='idevaluacion' value='{{ base64_encode($test["id"]) }}' />
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id='tokenEvaluacion'>
    
     </div>
        <!-- /#sidebar-wrapper -->  
        

    </div>
    <a href="#menu-toggle" class="btn btn-default btn-lg glyphicon glyphicon-info-sign" id="menu-toggle"></a> <!-- Menu Toggle Script -->
    <!-- /#wrapper --> 
@stop