@extends ('evaluacion/layout')

@section ('title') Rendir Evaluación @stop

@section ('content')

	<style>
		.cortina_pause{
			background-color: rgba(0,0,0,0.9);
			display: none;
			height: 100%;
			position: fixed;
			width: 100%;
			z-index: 900;
		}

		.cortina_pause > div{
			height: 40%;
			margin: 10% auto;
			text-align: center;
			width: 60%;
		}

		.btn{
			margin: 10% auto;
		}
	</style>


	<div id="eva-leftSection">

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

						<div  data-id="<?= $test['id'].'_'.$val['data']->id.'_'.$val['data']->tipo ?>" class="jumbotron eva-boxPregunta"> 

					@else

						<div data-id="<?= $test['id'].'_'.$val['data']->id.'_'.$val['data']->tipo ?>" class="jumbotron eva-boxPreguntaResp"> 

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

										<a class="btn btn-primary btn-lg eva-btnEnviar" href="javasctipt:void(0)" role="button" >Enviar respuesta</a>

									@else

										<button class="btn btn-success btn-md"> Respuesta Enviada!!</button>

									@endif
						    </p>
							
					</div>


				@endforeach

			@else
				No existen preguntas.

			@endif

		</section>
	</div>

	<div id="eva-rightSection">
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

				<a class="btn btn-primary btn-md"  role="button" id="eva-btnEnviarTodo">Enviar Todo y Terminar</a>

				<a class="btn btn-default btn-md" role="button" id="pausa">Pausar <strong style="font-weight:extra-bold;">||</strong></a>



			</h3>
		</secction>
	</div>

	<button id="eva-lanzaLoader" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm" style="display:none;"></button>

	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content" style="text-align:center; padding:25px;">
	      <img src="{{ asset('assets/img/loader.gif') }}" style="width:25%;"/ >
	      <br>
	      Guardando respuestas...
	    </div>
	  </div>
	</div>

	<input type='hidden' id='idevaluacion' value='{{ base64_encode($test["id"]) }}' />

	<div class='cortina_pause'>
		<div class='jumbotron'>
			<h2>Evaluación pausada!</h2>

			<button class='btn btn btn-primary btn-lg' 	id='btn_continuar'>Continuar</button>
			<button class='btn btn-default btn-lg' 		id='btn_volver'>Guardar y salir</button>
		</div>
	</div>
@stop