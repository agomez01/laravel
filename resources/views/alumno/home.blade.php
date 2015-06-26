@extends ('layout')

@section ('title') Home Alumno @stop


@section ('menu')
	@include ('alumno.menu')
@stop

@section ('content')

	

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


    <div class="container">
    	<br><br>
		<div id="content-right-alumno" class="">
     		<h2>{{ Session::get('idalumno') }}</h2>
     	</div>
		

		<div class="page-header">

		<div class="pull-right form-inline">
			<div class="btn-group">
				<button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
				<button class="btn" data-calendar-nav="today">Today</button>
				<button class="btn btn-primary" data-calendar-nav="next">Next >></button>
			</div>
			<div class="btn-group">
				<button class="btn btn-warning" data-calendar-view="year">Year</button>
				<button class="btn btn-warning active" data-calendar-view="month">Month</button>
				<button class="btn btn-warning" data-calendar-view="week">Week</button>
				<button class="btn btn-warning" data-calendar-view="day">Day</button>
			</div>
		</div>

		<h3></h3>
		<small>To see example with events navigate to march 2013</small>
	</div>

    	<div id="calendar">calendario</div>


		<div class="modal fade" id="events-modal">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                <h3>Event</h3>
		            </div>
		            <div class="modal-body" style="height: 400px">
		            </div>
		            <div class="modal-footer">
		                <a href="#" data-dismiss="modal" class="btn">Close</a>
		            </div>
		        </div>
		    </div>
		</div>


    </div>

    
  

@stop