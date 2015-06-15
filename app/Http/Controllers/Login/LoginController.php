<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;


class LoginController extends Controller
{

    public function getIndex(){

        return view('login/login');
    }

}
