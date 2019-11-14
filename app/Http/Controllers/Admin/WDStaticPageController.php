<?php

namespace Webdev\Http\Controllers\Admin;

use Webdev\Models\BlogwdStaticPage;
use Illuminate\Http\Request;
use Webdev\Http\Controllers\Admin\WDBlogBaseController;
//use Webdev\Http\Controllers\Controller;

class WDStaticPageController extends WDBlogBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
        return view('admin.static-pages.index',[
            'staticPages'=> BlogwdStaticPage::orderBy('id','asc')->paginate(5)
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
     * @param  \Webdev\Models\BlogwdStaticPage  $blogwdStaticPage
     * @return \Illuminate\Http\Response
     */
    public function show(BlogwdStaticPage $blogwdStaticPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Webdev\Models\BlogwdStaticPage  $blogwdStaticPage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stPage = BlogwdStaticPage::find($id);
        return view('admin.static-pages.edit',[
            'stPage' => $stPage
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Webdev\Models\BlogwdStaticPage  $blogwdStaticPage
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
        ]);
        $stPage = BlogwdStaticPage::find($id);
            $stPage->published = $request->get('published');
            $stPage->title = $request->get('title');
            
            $stPage->meta_description = $request->get('meta_description');
            $stPage->meta_keywords = $request->get('meta_keywords');
            $stPage->description = $request->get('description');
            $stPage->full_text = $request->get('full_text');
        $stPage->save();
        return redirect()->route('admin.static-page.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Webdev\Models\BlogwdStaticPage  $blogwdStaticPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogwdStaticPage $blogwdStaticPage)
    {
        //
    }
}
