<?php

namespace Webdev\Http\Controllers;
use Webdev\Models\BlogwdCategory;
use Webdev\Models\BlogwdPost;
use Illuminate\Http\Request;

class WDBlogController extends Controller
{
    //
    public function category($slug){
        $category = BlogwdCategory::where('slug','=',$slug)->first();
        return view('blogwd.category',[
            'category' => $category,
            'posts' => $category->posts()->where('published',1)->paginate(7) 
        ]);
    }
    
    public function post($slug){
        return view('blogwd.post',[
            'post' => BlogwdPost::where('slug','=',$slug)->first() 
        ]);
    }
}
