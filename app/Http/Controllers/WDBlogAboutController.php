<?php

namespace Webdev\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WDBlogAboutController extends Controller
{
    //
    public function index(Request $request){
        //Get URN path
        $path = $request->path();
        //The e function runs PHP's htmlspecialchars function with the double_encode option set to true by default
        $path = e($path);
        //Get data from DB for page according to the URN
        $pageData = DB::table('blogwd_static_pages')->where('path', $path)->first();
        if(!is_null($pageData)){
            //Apply the data to the View
            return view('blogwd.about',['pageData' => $pageData]);
        }else{
            //404
            abort(404,"Такой страницы не существует");
        }
    }
}
