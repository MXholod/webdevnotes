<?php
namespace Webdev\Http\ViewComposers;

use Illuminate\View\View;

class StaticNavigationComposer{
    
    public function compose(View $view){
        //Use Model scope
        $only_published = \Webdev\Models\BlogwdStaticPage::isPublished()->get();
        // 
        foreach($only_published as $stPage){
            //IF slash doesn't stand at the first place concat it.
            if(strpos($stPage->path,'/') === FALSE){
                $stPage->path = "/".$stPage->path;
            }
        }
        $view->with('staticPages',$only_published);
    }
}