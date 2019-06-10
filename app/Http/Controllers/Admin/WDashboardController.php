<?php

namespace Webdev\Http\Controllers\Admin;

use Webdev\Models\BlogwdAdminMenu;
use Illuminate\Http\Request;
use Webdev\Http\Controllers\Controller;

class WDashboardController extends Controller
{
    //WDashboard
    public function wdashboard(){
        /*$menu = BlogwdAdminMenu::all();
        dump($menu);
        foreach($menu as $item){
            echo $item->title." <br />";
        }
        return;*/
        return view('admin.wdashboard');
        /*return view('admin.wdashboard',[
            'categories' => BlogwdAdminMenu::all()
            //'categories' => ['Categories','Materials','Users']
        ]);*/
    }
}
