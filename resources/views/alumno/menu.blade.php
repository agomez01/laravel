<li class="dropdown">

	<a href="#" class="dropdown-toggle hvr-overline-from-left" data-toggle="dropdown">Alumno<b class="caret"></b></a>
	
	<ul class="dropdown-menu">
		<li><a href="{{ Salir::link('alumno/mis_clases.php') }}" target='blank'>Mis Cuadernos</a></li>
		<li><a href="{{ Salir::link('libro_clases_alumno/notas_alumno.php') }}" target='blank'>Mis Notas</a></li>
		<li><a href="{{ Salir::link('libro_clases_alumno/asistencia_alumno.php') }}" target='blank'>Mi Asistencia</a></li>
		<li><a href="{{ Salir::link('libro_clases_alumno/anotaciones_alumno.php') }}" target='blank'>Mis anotaciones</a></li>
		<li><a href="{{ Salir::link('recursos/buscadoralumnos.php?page=0') }}" target='blank'>Explorar Recursos</a></li>
		<li><a href="{{ Salir::link('mensajeria') }}" target='blank'>Comunicación</a></li>				
	</ul>
</li>