@extends ('evaluacion/layout')

@section ('title') Rendir Evaluación @stop

@section ('content')
	<style>

	#eva-leftSection
	{

		padding:10px;
		width: 80%;
		float:left;
		height: 100vh;

	}

	#eva-rightSection
	{

		width: 20%;
		float:left;
		background: #EEE;	
		height: 100vh;

	}

	#eva-membretePrueba
	{
		
		border-bottom: 1px dashed #CCC;	

	}

	.eva-boxPregunta
	{
		border-radius: 5px;
		padding: 5px !important;
		border: 1px dashed #CCC;

	}

	.eva-boxPreguntaResp{
		border-radius: 5px;
		padding: 5px !important;
		border: 1px dashed #CCC;
	}

	.eva-btnEnviar
	{

		font-size:14px !important;

	}


	.eva-casillaImagen
	{

		text-align: center;

	}

	.eva-casillaImagen:img 
	{

	 	display: block; margin: 0 auto;

	}

	.eva-casillaCuerpo
	{
		padding:25px;
	}

	.eva-checkAlternativa
	{
		width:3%;
	}

	.eva-textoAlternativa
	{
		width:94%;

	}

	.eva-letraAlternativa{
		width:3%;
	}

	.eva-parejas
	{
		list-style-type: none;
		margin:0;
		padding:0;
	}

	.eva-Indicadores{
		padding:25px;
	}

	.eva-btnMinPreg{
		border-radius: 26px !important;

	}

	</style>

	<div id="eva-leftSection">

		<section id="eva-membretePrueba" >
			<ul class="list-group">
			  <li class="list-group-item">
			  		<h2 style="text-align: center;">

						{{ $test["nombre"] }}

					</h2>
			  </li>
			  <li class="list-group-item">

				  <h5>
				  		Alumno: {{ Session::get('full-name') }}
				  </h5>

				  <h5>
				  		Curso: {{ Session::get('nombre-curso') }}
				  </h5>

				  <h5>
				  		Fecha: {{  date("d-m-Y", time())  }}
				  </h5>

			  </li>
			  <li class="list-group-item">
			  
			  	<h5><strong>Instrucciones</strong></h5>
			  	<?=  $test["instrucciones"];  ?>
			  </li>
			  
			</ul>

		</secction>

		<section>

			@if (count($preguntas) > 0 )
			
				@foreach ($preguntas as $pos=>$val)


					{!! Form::open( ['route' => ['evaluacion',''], 'method' => 'UPDATE', 'id' => 'resp_'.$val["data"]->id ] ) !!}

					{!! Form::close() !!}

					@if( !isset( $val["respuestaAlumno"]->respuesta ) )

						<div data-id="<?= $test['id'].'_'.$val['data']->id.'_'.$val['data']->tipo ?>" class="jumbotron eva-boxPregunta"> 

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

										Respuesta Enviada!!

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
				<li class="list-group-item">
					Id Evaluación: {{ $test["id"] }}<br>
					Profesor: {{ $test["autor"] }}
				</li>
			
				<li class="list-group-item">
					Tiempo disponible:<br><span id='duracion_test'>{{ $test["duracion"] }} minutos</span>
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

				<a class="btn btn-primary btn-lg" href="javasctipt:void(0)" role="button" id="eva-btnEnviarTodo">Enviar Todo y Terminar</a>

				<a class="btn btn-primary btn-lg" role="button" id="pausa">Pausar</a>



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


@stop