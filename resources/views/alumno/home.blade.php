@extends ('layout')

@section ('title') Home Alumno @stop

@section ('content')
	<style>

		#sidebar-left
		{
			padding: 15px;
			position: relative;
			width: 25%;
			float: left;
		}

		#content-right-alumno
		{
			width: 75%;
			float: left;
		}

		#open-test-alumno button
		{
			width: 100%;
			padding: 12px;
			border: 0;
			text-align: left;
			color: #337ab7;
		}

		#closed-test-alumno button
		{	
			width: 100%;
			padding: 12px;		
			border: 0;	
			text-align: left;
			color: #337ab7;
		}

		.sidebar-alumno-dropdown
		{
			width: 100%;
			position:relative;
		}
		.test-box{
			border-bottom: 1px solid #CCC;
		}

	</style>

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
		    			<a role="menuitem" tabindex="-1" href="evaluacion/{{$test->idtest}}">
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