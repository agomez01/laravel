@extends ('layout')

	@section ('title') Home UTP @stop

@section ('content')
	
	<h1>1</h1>

	<h1>Home UTP</h1>

	<div class='row'>

		<div class="form-group">

			<div class='col-md-3'>
				<label for='slc_profesor'>Profesor</label>
				<select id='slc_profesor' class='form-control'>
					<option value="0">Seleccione Profesor</option>
				</select>
			</div>

			<div class='col-md-3'>
				<label for='slc_sector'>Asignatura</label>
				<select id='slc_sector' class='form-control'>
					<option value="0">Seleccione Asignatura</option>
				</select>
			</div>

		</div>
	</div>
			

	
	<div class="row">
		
		<div class="table-responsive">
			<table class="table table-hover">

				<tr>
					<th>Bloque</th>
					<th>Lunes</th>
					<th>Martes</th>
					<th>Miercoles</th>
					<th>Jueves</th>
					<th>Viernes</th>
					<th>Sabado</th>
				</tr>
		  		
		  		<tr>
		  			<td>1</td>
		  			<td>2</td>
		  			<td>3</td>
		  			<td>4</td>
		  			<td>5</td>
		  			<td>6</td>
		  			<td>7</td>
		  		</tr>
		  		<tr>
		  			<td>1</td>
		  			<td>2</td>
		  			<td>3</td>
		  			<td>4</td>
		  			<td>5</td>
		  			<td>6</td>
		  			<td>7</td>
		  		</tr>
		  		<tr>
		  			<td>1</td>
		  			<td>2</td>
		  			<td>3</td>
		  			<td>4</td>
		  			<td>5</td>
		  			<td>6</td>
		  			<td>7</td>
		  		</tr>
		  		<tr>
		  			<td>1</td>
		  			<td>2</td>
		  			<td>3</td>
		  			<td>4</td>
		  			<td>5</td>
		  			<td>6</td>
		  			<td>7</td>
		  		</tr>
		  		<tr>
		  			<td>1</td>
		  			<td>2</td>
		  			<td>3</td>
		  			<td>4</td>
		  			<td>5</td>
		  			<td>6</td>
		  			<td>7</td>
		  		</tr>

			</table>
		</div>
	</div>

		

@stop