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

	Route::get(		'/', 			'Login\LoginController@index');
	Route::post(	'/login', 		'Login\LoginController@logearse');



	Route::group(['middleware' => 'auth'], function(){

		Route::group(['middleware' => 'isWcManager'], function(){

			Route::get(	'/alumno', 	'Alumno\AlumnoController@index');

		});

		# Acceso por ROL
		Route::group(['middleware' => 'isSuperAdmin'], function(){
			Route::get(	'/prueba', 	'PruebaController@index');
			Route::get(	'/alumno', 	'Alumno\AlumnoController@index');	
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