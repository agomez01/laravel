@extends ('evaluacion/layout')

@section ('title') Rendir Evaluación @stop

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
;
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
	width:97%;

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

		<h2 style="text-align: center;">

			Prueba id: {{ $test["prueba"] }}

		</h2>

	</secction>

	<section>
		
		@foreach ($preguntas as $pos=>$val)


			{!! Form::open( ['route' => ['evaluacion',''], 'method' => 'UPDATE', 'id' => 'resp_'.$val["data"]->id ] ) !!}

			{!! Form::close() !!}


			<div data-id="<?= $test['id'].'_'.$val['data']->id.'_'.$val['data']->tipo ?>" class="jumbotron eva-boxPregunta"> 
				
					@if ($val["recurso"] != "")
					    
					<div class="eva-casillaImagen">					    

						@include('evaluacion/preguntas', ['test' => $test , 'pregunta' => $val, 'seccion' => 'recurso'])
						
					</div>
					
					@endif

					<div class="eva-casillaTexto">

						<h5>

							<strong> Pregunta N°{{ $val["numero"] }} - <?= $val["data"]->texto ?> [id: <?= $val["data"]->id ?>]</strong>

						</h5>

					</div>

					<div class="eva-casillaCuerpo">

						@include('evaluacion/preguntas', ['test' => $test , 'pregunta' => $val, 'seccion' => 'cuerpo'])

					</div>

					<p style="text-align:right;" >

							<a class="btn btn-primary btn-lg eva-btnEnviar" href="javasctipt:void(0)" role="button" >Enviar respuesta</a>

				    </p>
					
			</div>


		@endforeach

	</section>
</div>

<div id="eva-rightSection">
	<section class="eva-Indicadores" >
		
		<ul class="list-group">
		  <li class="list-group-item">
		  	Id Evaluación: {{ $test["id"] }}
		  	<br>
		  	Profesor: {{ $test["autor"] }}
		  </li>
		  <li class="list-group-item">
		  	Tiempo Restante
		  </li>
		  <li class="list-group-item">
		  	Preguntas

		  	@include('evaluacion/preguntas', ['test' => $test , 'pregunta' => $val, 'seccion' => 'miniaturas'])

		  </li>
		  <li class="list-group-item">leyenda</li>
		  
		</ul>
		
	</secction>

	<section class="eva-controles" >
		<h3 style="text-align: center;">

			Aqui los controles 

		</h3>
	</secction>
</div>


