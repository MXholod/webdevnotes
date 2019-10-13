<?php

namespace Webdev\Http\Controllers;

use Illuminate\Http\Request;

class WDBlogContactsController extends Controller
{
    //
    public function index(){
        return view('blogwd.contacts');
    }
}
