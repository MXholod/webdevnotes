<?php

namespace Webdev\Http\Controllers;

use Illuminate\Http\Request;

class WDBlogAboutController extends Controller
{
    //
    public function index(){
        return view('blogwd.about');
    }
}
