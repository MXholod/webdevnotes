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
        //
        $erPage = BlogwdErrorPage::find($id);
         return view('admin.error-pages.edit',[
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
