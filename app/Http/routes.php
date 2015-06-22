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
	
	# Ruta enlace externo,
	# se espera como argumento el id de usuario, el modulo al cual se dirige y el token de comprobación de la sesión
	Route::get(		'/externo/{id}/{modulo}/{token}', 'Login\LoginController@logexterno')->where('id', '[0-9]+');

	# Rutas del Sistema
	Route::group(['middleware' => 'auth'], function(){

		Route::get('/home', 'Home\HomeController@index');
		Route::any('/logout', 'Login\LoginController@logout');

		# Acceso ROL SUPER ADMINISTRADOR
		Route::group(['middleware' => 'isSuperAdmin'], function(){
			Route::get(	'/alumno', 	'Alumno\AlumnoController@index');
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
		Route::group(['middleware' => 'isAlumno'], function(){ /**/ });		
		
	});