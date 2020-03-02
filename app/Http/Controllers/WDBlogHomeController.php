<?php

namespace Webdev\Http\Controllers;

use Illuminate\Http\Request;


class WDBlogHomeController extends WDBlogBaseController
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Draw the data from DB in the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return view or abort
     */
    public function index(Request $request)
    {
        //Get data for this page according to the request
        $pageData = $this->getStaticPageData($request);
        //Styles by default
        $styles = [];
        //Sort all the bound CSS files for this page
        foreach($pageData->styles as $style){
            $styles[] = $style->path_css;
        }
        //Scripts by default
        $scripts = [];
        //Sorts all the bound JS files and put them in two arrays 'header' and 'footer'
        foreach($pageData->scripts as $script){
            if($script->header_or_footer == 0){
                $scripts['header'][] = $script->path_js;
            }else{
                $scripts['footer'][] = $script->path_js;
            }
        }
        //Check incoming page data
        if(!is_null($pageData)){
            //Apply the data to the View
            return view('blogwd.home', [
                'styles' => $styles,
                'scripts' => $scripts,
                'pageData' => $pageData
            ]);
        }else{
            //404
            abort(404,"Такой страницы не существует");
        }
    }
}
