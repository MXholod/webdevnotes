<?php

namespace Webdev\Http\Controllers\Admin;

use Webdev\Models\BlogwdCategory;
use Webdev\Models\BlogwdPost;
use Illuminate\Http\Request;
use Webdev\Http\Controllers\Controller;

class WDashboardController extends Controller
{
    //WDashboard
    public function wdashboard(){
        return view('admin.wdashboard',[
            'categories'=> BlogwdCategory::lastCategories(5),
            'posts'=> BlogwdPost::lastPosts(5),
            'amount_categories'=> BlogwdCategory::count(),
            'amount_posts'=> BlogwdPost::count()
        ]);
    }
}
