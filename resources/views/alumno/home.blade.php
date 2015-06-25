@extends ('layout')

@section ('title') Home Alumno @stop

@section ('content')

	@include ('alumno.menu') 

    <div id="sidebar-left" >
        
    	<ul class="nav nav-pills nav-stacked">

			  
			  <li role="presentation"><a href="#">El reloj</a></li>
			  <li role="presentation"><a href="#">Biblioteca Alumno</a></li>

		</ul>

		<div class="dropdown" id="open-test-alumno">
		    <button class="btn btn-default dropdown-toggle" type="button" id="open-test" data-toggle="dropdown">Evaluaciones Abiertas ({{count($testAbiertos)}})
		    <span class="caret"></span></button>
		    <ul class="dropdown-menu sidebar-alumno-dropdown" role="menu" aria-labelledby="open-test">

		    	@foreach ($testAbiertos as $test)
		    		<li role="presentation" class="test-box">
		    			<a role="menuitem" tabindex="-1" href="/evaluacion/<?= base64_encode($test->idtest); ?>/0 ">
			    			<h5>
			    				Id: {{ $test->idtest }}
			    			</h5>
			    			<h6>
			    				Nombre: {{ $test->nombre }}
			    			</h6>
			    			<h6>
			    				Asignatura: {{$test->asignatura}}
			    			</h6>
		    			</a>
		    			
		    		</li>
			  	@endforeach
		      
		    
		    </ul>
	  </div>

		<div class="dropdown" id="closed-test-alumno">
		    <button class="btn btn-default dropdown-toggle" type="button" id="closed-test" data-toggle="dropdown">Evaluaciones Cerradas ({{count($testCerrados)}})
		    <span class="caret"></span></button>
		    <ul class="dropdown-menu sidebar-alumno-dropdown" role="menu" aria-labelledby="closed-test">
		      
		      	@foreach ($testCerrados as $test)
		    		<li role="presentation" class="test-box">
		    			<a role="menuitem" tabindex="-1" href="javascript:void(0)">
			    			<h5>
			    				Id: {{$test->idtest}}
			    			</h5>
			    			<h6>
			    				Nombre: {{$test->nombre}}
			    			</h6>
			    			<h6>
			    				Asignatura: {{$test->asignatura}}
			    			</h6>
		    			</a>
		    			
		    		</li>
			  	@endforeach

		    </ul>
		  </div>	
			

    </div>

    <div id="content-right-alumno" class="">
     
		<h2>
			 
			 <br>
			 {{ Session::get('idalumno') }}
		</h2>
			

    </div>
  

@stop