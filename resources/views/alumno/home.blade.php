@extends ('layout')

@section ('title') Home Alumno @stop


@section ('menu')
	@include ('alumno.menu')
@stop

@section ('content')

<div id="close-toggle2"></div>	

<div class="row">
    <div class="col-md-3 col-sm-4 sidebar-left" >

    	<ul class="nav nav-pills nav-stacked">
    		<li class="reloj">
    			<div id="reloj">00 : 00 : 00</div>
    			<div class="fecha">
    				<img src="../assets/img/reloj.png" alt="">

    				<script type="text/javascript"> 
    					var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
    					var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"); 
    					var f=new Date(); document.write(diasSemana[f.getDay()] + " " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    				</script>
    			</div>
    		</li>

			<li role="presentation" ><a class="alu-biblio" 	href="#">
			  	<img src="../assets/img/biblioteca.png" alt="">Biblioteca Alumno</a>
			</li>
		</ul>

		<div class="dropdown open" id="open-test-alumno">
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


    <div class="col-md-9 col-sm-8" >
    	<br><br><br>	

		<div class="page-header">

			<div class="pull-right form-inline">
				<div class="btn-group controla-hoy">
					<button class="btn controla" data-calendar-nav="prev"><img src="../assets/img/anterior.svg" alt="" width="20"></button>
					<button class="btn hoy" data-calendar-nav="today">Hoy</button>
					<button class="btn controla" data-calendar-nav="next"><img src="../assets/img/siguiente.svg" alt="" width="20"></button>
				</div>
				<div class="btn-group"><h3 class="h3-md"></h3></div>			
				<div class="btn-group controla-mes">
					<button class="btn btn-warning" data-calendar-view="year">Año</button>
					<button class="btn btn-warning active" data-calendar-view="month">Mes</button>
					<button class="btn btn-warning" data-calendar-view="week">Semana</button>
					<button class="btn btn-warning" data-calendar-view="day">Día</button>
				</div>

			</div>
			<h3 class="h3-xs"></h3>
					
		</div>

    	@include ('calendario')
	</div>
</div>
  
  

@stop