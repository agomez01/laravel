@extends ('layout')

@section ('title') Login | Webclass @stop

@section ('content')


    <div class="welcome">
        <h1>Bienvenido</h1>

		<!--
        @foreach ($alumnos as $alumno)
		    <p>Alumno {{ $alumno->usuario->nombre_usuario }}</p>
		@endforeach

		<?php echo $alumnos->render(); ?>
		-->
		
		<div class="alumnos">
			@foreach ($alumnos as $alumno)

			    <article>
			        <h2>{{ $alumno->usuario->nombre_usuario }}</h2>
			        {{ $alumno->id }}
			    </article>

			@endforeach

			<?php echo $alumnos->render(); ?>			
		</div>
			

    </div>

    <script>
	   

	    $(document).ready(function() {

	        $(document).on('click', '.pagination a', function (e) {
	            getPosts($(this).attr('href').split('page=')[1]);
	            e.preventDefault();
	        });


	        $(window).on('hashchange', function() {
		        if (window.location.hash) {
		            var page = window.location.hash.replace('#', '');
		            if (page == Number.NaN || page <= 0) {
		                return false;
		            } else {
		                getPosts(page);
		            }
		        }
		    });

		    function getPosts(page) {
		        $.ajax({

		            url : '?page=' + page,
		            dataType: 'json',
		            success: function(data){
		            	console.log(data);

						$('.alumnos').html(data);
		            	location.hash = page;
		            }
				});
		    }
	    });

	    
    </script>

@stop