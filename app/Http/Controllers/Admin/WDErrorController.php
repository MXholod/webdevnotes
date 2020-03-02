<?php

namespace Webdev\Http\Controllers\Admin;

use Webdev\Models\BlogwdErrorPage;
use Illuminate\Http\Request;
use Webdev\Http\Controllers\Admin\WDBlogBaseController;
//use Webdev\Http\Controllers\Controller;

class WDErrorController extends WDBlogBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.error-pages.index',[
            'errorPages'=> BlogwdErrorPage::orderBy('id','asc')->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Webdev\Models\BlogwdErrorPage  $blogwdErrorPage
     * @return \Illuminate\Http\Response
     */
    public function show(BlogwdErrorPage $blogwdErrorPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Webdev\Models\BlogwdErrorPage  $blogwdErrorPage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //We've got the whole list of file paths
        $filesCss = $this->getAllFiles("css/additional_css");
        //We've got the whole list of file paths
        $files = $this->getAllFiles("js/additional_js");
        //Model name    
        $model = "Webdev\Models\BlogwdErrorPage";
        $erPage = BlogwdErrorPage::find($id);
         return view('admin.error-pages.edit',[
            // ’files’ и  'activeScripts' – данные для Vue компонентов
            'files'=>$this->getUnlikeDBPaths($files,$erPage->scripts,$id,$model),
            'activeScripts'=>$this->getDbPreparedData($erPage->scripts),
             // ’filesCss’ и  'activeCss' – данные для Vue компонентов
            'filesCss'=>$this->getUnlikeDBPaths($filesCss,$erPage->styles,$id,$model),
            'activeCss'=>$this->getDbPreparedData($erPage->styles,"css"),
            'errorPage'=> $erPage
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Webdev\Models\BlogwdErrorPage  $blogwdErrorPage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'title' => 'required',
            'meta_keywords' => 'required',
            'meta_description' => 'required',
            'description' => 'required',
            'full_text' => 'required',
        ]);
        $stPage = BlogwdErrorPage::find($id);
            $stPage->published = $request->get('published');
            $stPage->title = $request->get('title');
            
            $stPage->meta_description = $request->get('meta_description');
            $stPage->meta_keywords = $request->get('meta_keywords');
            $stPage->description = $request->get('description');
            $stPage->full_text = $request->get('full_text');
        $stPage->save();
        //Update header_or_footer field in table 'blogwd_scripts'.
        $scripts_h_f = $this->updateScripts($request);
           if(count($scripts_h_f) > 0){
               for($j=0;$j<count($scripts_h_f);$j++){
                   \Webdev\Models\BlogwdScript::where('id',$scripts_h_f[$j]['id'])
                        ->where('scriptable_id',$id)
                        ->update($scripts_h_f[$j]);
                 }
           }
        return redirect()->route('admin.error-page.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Webdev\Models\BlogwdErrorPage  $blogwdErrorPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogwdErrorPage $blogwdErrorPage)
    {
        //
    }
}
