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
        //Get Post by 'slug'
        $postData = BlogwdPost::where('slug','=',$slug)->first();
        $scripts = [];
        //Sorts all the bound files and put them in two arrays 'header' and 'footer'
        foreach($postData->scripts as $script){
            if($script->header_or_footer == 0){
                $scripts['header'][] = $script->path_js;
            }else{
                $scripts['footer'][] = $script->path_js;
            }
        }
        return view('blogwd.post',[
            'scripts' => $scripts,
            'post' => $postData //BlogwdPost::where('slug','=',$slug)->first() 
        ]);
    }
}
