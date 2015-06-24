@extends ('evaluacion/layout')

@section ('title') Portada Evaluación @stop

<style>

.eval-bienvenida_evaluacion
{
	padding:50px !important;
}

.eval-panel-detalles
{
	list-style-type: none;
	padding:0;
	margin:0;
}

.eval-panel-detalles li
{
	list-style-type: none;
	
}

</style>

<div class="jumbotron eval-bienvenida_evaluacion">
  	<h2>Estas por comenzar la evaluación...Suerte!!!</h2>

  	<div class="panel eval-panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading" style="font-weight:bold;">Evaluación: {{ $test["nombre"] }}</div>
	  <div class="panel-body">
	    <ul class="panel-detalles">
	    	<li>
	    		Nivel: {{ $test["nivel"] }}
	    	</li>
	    	<li>
	    		Asignatura: {{ $test["asignatura"] }}
	    	</li>
	    	
	    	<li>
	    		Duración: {{ $test["duracion"] }}(min)
	    	</li>
	    </ul>
	  </div>
	</div>
	<div style="text-align:right;">
			<a class="btn btn-default btn-lg" href="/home" role="button">Volver</a>
			&nbsp; &nbsp; &nbsp; 
			<a class="btn btn-primary btn-lg" href="/evaluacion/<?= base64_encode($test["id"]) ?>/1" role="button">Comenzar</a>
	</div>
  	


</div>


	
