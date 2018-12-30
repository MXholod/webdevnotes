<?php

namespace Webdev\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webdev\Http\Controllers\Controller;

class WDashboardController extends Controller
{
    //WDashboard
    public function wdashboard(){
        return view('admin.wdashboard');
    }
}
