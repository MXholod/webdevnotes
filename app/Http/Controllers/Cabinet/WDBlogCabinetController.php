<?php

namespace Webdev\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use Webdev\Http\Controllers\Controller;

class WDBlogCabinetController extends Controller
{
    //
    public function index(){
        return view('blogwd.cabinet.user_cabinet');
    }
}
