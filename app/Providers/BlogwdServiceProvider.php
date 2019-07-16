<?php

namespace Webdev\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        //
        $this->topMenu();
    }
    private $test = array(
        ["id"=>1,"title"=>"Первая категория","parent_id"=>0],
        ["id"=>2,"title"=>"Вторая","parent_id"=>1],
        ["id"=>3,"title"=>"Третья","parent_id"=>2],
        ["id"=>4,"title"=>"Четвёртая","parent_id"=>2],
        ["id"=>7,"title"=>"Пятая категория","parent_id"=>0],
        ["id"=>8,"title"=>"Шестая категория","parent_id"=>2]
    );
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
            $parents_arr[$value->parent_id][$value->id] = $child_arr;
        }
        //First parent array
        $treeElem = $parents_arr[0];
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
    /*
     * $arr_cat - is an Array where keys are identifiers of the parent categories
       $arr_cat = [
                    0=>[],
                    1=>[],
                    2=>[],
                    5=>[],
                ]
    
    public function prepareStructureTree($publishedItems){
        if(count($publishedItems) != 0){
            $arr_cat = array();
            foreach($publishedItems as $v1){
                //If parent is empty create an Array
                if(empty($arr_cat[$v1->parent_id])){
                    $arr_cat[$v1->parent_id] = array();//$arr_cat = [ 0=>array() ];
                }
                //If parent array is already exists save child category
                $arr_cat[$v1->parent_id][] = $v1;//= $v1->title." ".$v1->parent_id;
            }
            return $arr_cat;
        }
    }
    */
}