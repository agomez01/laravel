<?php

namespace App\Http\Controllers\Auth;

use App\Http\Clases\generaLink;
use App\Http\Controllers\Controller;

use View;
use Input;
use Session;
use Request;
use Redirect;


class SalirController extends Controller
{

    static function link($modulo = '../'){

        $link = generaLink::getLink($modulo);

        return $link;
    }


}
