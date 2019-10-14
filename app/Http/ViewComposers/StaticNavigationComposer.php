<?php
namespace Webdev\Http\ViewComposers;

use Illuminate\View\View;

class StaticNavigationComposer{
    
    public function compose(View $view){
        //Use Model scope
        $only_published = \Webdev\Models\BlogwdStaticPage::isPublished()->get();
        //   
        $view->with('staticPages',$only_published);
    }
}