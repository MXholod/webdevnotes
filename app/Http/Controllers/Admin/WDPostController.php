<?php

namespace Webdev\Http\Controllers\Admin;

use Webdev\Models\BlogwdPost;
use Webdev\Models\BlogwdCategory;
use Illuminate\Http\Request;
use Webdev\Http\Controllers\Controller;

class WDPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.posts.index',[
            'posts'=> BlogwdPost::orderBy('created_at','desc')->paginate(5)
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
        return view('admin.posts.create',[
            'post'=> [],
            'categories'=> BlogwdCategory::with('children')->where('parent_id',0)->get(),
            'delimiter'=> ''
        ]);
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
        $post = BlogwdPost::create($request->all());
        //Categories
        if($request->input('categories')){
            $post->categories()->attach($request->input('categories'));
        }
        return redirect()->route('admin.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
     * @return \Illuminate\Http\Response
     */
    public function show(BlogwdPost $blogwdPost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogwdPost $blogwdPost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogwdPost $blogwdPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogwdPost $blogwdPost)
    {
        //
    }
}
