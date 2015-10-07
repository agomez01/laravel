<?php
	namespace App\Http\Controllers\Utp;

	use App\Http\Controllers\Controller;	
	
	use Session;
	use Request;
	
	class UtpController extends Controller
	{

		public function index()
		{
			return view('utp/home');
		}
	}