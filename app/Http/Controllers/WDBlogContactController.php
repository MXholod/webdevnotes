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
        //Check incoming page data
        if(!is_null($pageData)){
            //Apply the data to the View
            return view('blogwd.contacts', ['pageData' => $pageData]);
        }else{
            //404
            abort(404,"Такой страницы не существует");
        }
    }
}
