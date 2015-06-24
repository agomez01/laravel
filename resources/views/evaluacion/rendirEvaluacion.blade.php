@extends ('evaluacion/layout')

@section ('title') Rendir Evaluación @stop

<style>

#eva-leftSection{

	padding:10px;
	width: 80%;
	float:left;
	height: 100vh;

}

#eva-rightSection{

	width: 20%;
	float:left;
	background: #EEE;	
	height: 100vh;

}

#eva-membretePrueba
{
	
	border-bottom: 1px dashed #CCC;	

}

.eva-boxPregunta{

	padding:5px !important;

}

.eva-btnEnviar{

	font-size:14px !important;

}


#eva-casillaImagen{

	text-align: center;

}

#eva-casillaImagen:img {

 	display: block; margin: 0 auto;

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

			<div id="" class="jumbotron eva-boxPregunta"> 
				
					@if ($val["imagen"] != "")
					    
					<div id="eva-casillaImagen">					    

						<img src='http://proyecto.webescuela.cl/sistema/webclass/home/recursos/{{ $val["imagen"] }}'/>

					</div>
					
					@endif

					<div id="eva-casillaTexto">

						<h5>

							<strong> Pregunta N°{{ $val["numero"] }} - <?= $val["data"]->texto ?> [id: <?= $val["data"]->id ?>]</strong>

						</h5>

					</div>

					<div id="eva-casillaCuerpo">

						@include('evaluacion/preguntas', ['test' => $test , 'pregunta' => $val])

					</div>

					<div style="text-align:right; ">
							
							<a class="btn btn-primary btn-lg eva-btnEnviar" href="javasctipt:void(0)" role="button" id="<?= $test['id'].'_'.$val['data']->id.'_'.$val['data']->tipo ?>">Enviar respuesta</a>
					</div>
			</div>


		@endforeach

	</section>
</div>

<div id="eva-rightSection">
	<section id="eva-Indicadores" >
		<h3 style="text-align: center;">

			Aqui los indicadores 

		</h3>
	</secction>

	<section id="eva-controles" >
		<h3 style="text-align: center;">

			Aqui los controles 

		</h3>
	</secction>
</div>
	
