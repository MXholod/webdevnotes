<?php

namespace Webdev\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WDBlogBaseController extends Controller
{
    /**
     * Get the data from DB according to the request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\DB
     */
    protected function getStaticPageData(Request $request)
    {
        //Get URN path
        $path = $request->path();
        //The e function runs PHP's htmlspecialchars function with the double_encode option set to true by default
        $pathIsCleared = e($path);
        //Get data from DB for page according to the URN
        $pathWithSlash = "/".$pathIsCleared;
        //Get data from DB for page according to the URN
        $pageData = DB::table('blogwd_static_pages')->where('path', $pathIsCleared)->orWhere('path',$pathWithSlash)->first();
        //Return data for static page
        return $pageData; 
    }
}
