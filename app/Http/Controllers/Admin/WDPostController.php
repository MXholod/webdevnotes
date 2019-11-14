<?php

namespace Webdev\Http\Controllers\Admin;

use Webdev\Models\BlogwdPost;
use Webdev\Models\BlogwdCategory;
use Illuminate\Http\Request;
use Webdev\Http\Controllers\Admin\WDBlogBaseController;
//use Webdev\Http\Controllers\Controller;

class WDPostController extends WDBlogBaseController
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
            //Attach fields in database 'blogwd_categoryables'
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
    public function edit($id)
    {
        //
        $post = BlogwdPost::find($id);
        return view('admin.posts.edit',[
            'post' => $post,
            'categories'=> BlogwdCategory::with('children')->where('parent_id',0)->get(),
            'delimiter'=> ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
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
        $post = BlogwdPost::find($id);
            $post->modified_by = $request->get('modified_by');
            $post->published = $request->get('published');
            $post->title = $request->get('title');
            //Detach fields in database 'blogwd_categoryables'
            $post->categories()->detach();
            if($request->get('categories')){
                //Attach fields in database 'blogwd_categoryables' again
                $post->categories()->attach($request->get('categories'));
            }
            $post->meta_description = $request->get('meta_description');
            $post->meta_keywords = $request->get('meta_keywords');
            $post->description = $request->get('description');
            $post->full_text = $request->get('full_text');
        $post->save();
        return redirect()->route('admin.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogwdPost::findOrFail($id);
        //Detach fields in database 'blogwd_categoryables'
        $post->categories()->detach();
        //Delete current Post
        $post->delete();
        return redirect()->route('admin.post.index');
    }
}
