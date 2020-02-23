<?php

namespace Webdev\Http\Controllers;

use Illuminate\Http\Request;

class WDBlogContactController extends WDBlogBaseController
{
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
        $scripts = [];
        //Sorts all the bound files and put them in two arrays 'header' and 'footer'
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
            return view('blogwd.contacts', [
                'scripts' => $scripts,
                'pageData' => $pageData
            ]);
        }else{
            //404
            abort(404,"Такой страницы не существует");
        }
    }
}
