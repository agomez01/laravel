<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
	
	# Controlador Prueba
	Route::get(		'/prueba', 	'PruebaController@index');


	# Rutas de control de acceso
	Route::get(		'/', 		'Login\LoginController@index');
	Route::post(	'/login', 	'Login\LoginController@logearse');

	Route::post('/ajax', 'PruebaController@ajax');
	

	# Ruta enlace externo, sin TOKEN
	Route::post('/externo', 'Login\LoginController@logexterno');


	# Rutas del Sistema
	Route::group(['middleware' => 'auth'], function(){


		Route::get('/home', 	'Home\HomeController@index');
		Route::any('/logout', 	'Login\LoginController@logout');

		Route::any('/eventos', 	'Calendario\EventosController@EventosJson');
		Route::any('/eventos/{id}', 	'Calendario\EventosController@getEvento')->where('id', '[0-9]+');

		

		# Acceso ROL SUPER ADMINISTRADOR
		Route::group(['middleware' => 'isSuperAdmin'], function(){
			//Route::get(	'/alumno/evaluacion', 	'Alumno\AlumnoController@index');

		});

		# Acceso ROL WEBCLASS MANAGER
		Route::group(['middleware' => 'isWcManager'], function(){

		});

		Route::group(['middleware' => 'isCapacitador'], function(){ /**/ });
		Route::group(['middleware' => 'isFinanzas'], function(){ /**/ });
		Route::group(['middleware' => 'isSostenedor'], function(){ /**/ });
		Route::group(['middleware' => 'isDirector'], function(){ /**/ });
		Route::group(['middleware' => 'isUtp'], function(){ /**/ });
		Route::group(['middleware' => 'isProfesor'], function(){ /**/ });
		Route::group(['middleware' => 'isInsGeneral'], function(){ /**/ });
		Route::group(['middleware' => 'isApoderado'], function(){ /**/ });
		
		Route::group(['middleware' => 'isAlumno'], function(){ 

			Route::get('/evaluacion/{id}/{action?}', 'Evaluacion\EvaluacionController@index');
			Route::get('/evaluacion/feed/{test}/{pregunta}/{tipo}', 'Evaluacion\FeedBack@getFeed');
			Route::post('evaluacion', ['as' => 'evaluacion', 'uses' => 'Evaluacion\EvaluacionController@procesarRespuesta']);
			
		});		
	});