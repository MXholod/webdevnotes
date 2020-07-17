<?php

namespace Webdev\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Webdev\Http\ViewComposers\StaticNavigationComposer;
class BlogwdServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //Top multilevel menu
        $this->topMenu();
        //Static pages menu
        view()->composer('layouts.static_pages_menu', StaticNavigationComposer::class);
        //Static pages menu
        //$this->staticPages();
    }
    //Dynamic multilevel menu
    public function topMenu(){
        //Facade View
        View::composer('layouts.header', function($view){
            //1. Variable name is 'categories' passes into a template
            //2. Variable value
            //Get all the highest level parent categories and published and put to the var 'categories'
            //$view->with('categories', \Webdev\Models\BlogwdCategory::where('parent_id',0)->where('published',1)->get());
            $only_published = \Webdev\Models\BlogwdCategory::isPublished()->get();
            $prepare_categories = $this->prepareMenuTree($only_published);
            $view->with('categories',$prepare_categories);//$prepare_categories $menu_categories
        });
    }
    private function prepareMenuTree($publishedItems){
        $parents_arr = array();
        foreach($publishedItems as $key=>$value){
            //Create child array for the parent array
            $child_arr = array();
                $child_arr['id'] = $value->id;
                $child_arr['parent_id'] = $value->parent_id;
                $child_arr['title'] = $value->title;
                $child_arr['slug'] = $value->slug;
                $child_arr['menu_label'] = $value->menu_label;
            $parents_arr[$value->parent_id][$value->id] = $child_arr;
        }
        //First parent array
        if(empty($parents_arr[0])){
            $treeElem = [];
        }else{
            $treeElem = $parents_arr[0];
        }
        $this->generateMenuTree($treeElem,$parents_arr);
        return $treeElem;
    }
    private function generateMenuTree(&$treeElem,$parents_arr){
        foreach($treeElem as $key=>$value){
            if(!isset($value['sublevel'])){
                //Variable $key - is a children index
                $treeElem[$key]['sublevel'] = array();
            }
            //Find child for current parent
            if(array_key_exists($key, $parents_arr)){
                $treeElem[$key]['sublevel'] = $parents_arr[$key];
                $this->generateMenuTree($treeElem[$key]['sublevel'],$parents_arr);
            }
        }
    }
    //Menu for static pages
    /*public function staticPages(){
        //Facade View
        View::composer('layouts.static_pages_menu', function($view){

            $only_published = \Webdev\Models\BlogwdStaticPage::isPublished()->get();

            $view->with('staticPages',$only_published);//$prepare_categories $menu_categories
        });
    }*/
}
