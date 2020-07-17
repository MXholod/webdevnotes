<?php

namespace Webdev\Http\Controllers\Admin;

use Webdev\Models\BlogwdCategory;
use Illuminate\Http\Request;
use Webdev\Http\Controllers\Admin\WDBlogBaseController;
use DB;
//use Webdev\Http\Controllers\Controller;

class WDCategoryController extends WDBlogBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Для отображения списка Категорий
        //return view('admin.wdashboard',[
            //Five Categories per page
        //    'categories' => BlogwdCategory::paginate(5)
        //]);
        return response()->view('admin.categories.index',[
            'categories' => BlogwdCategory::paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //We've got the whole list of CSS file paths
        $filesCss = $this->getAllFiles("css/additional_css");
        //We've got the whole list of JS file paths
        $files = $this->getAllFiles("js/additional_js");
        //Model name
        $model = "Webdev\Models\BlogwdCategory";
        //Отвечает за открытие формы создания Категории
        return response()->view('admin.categories.create',[
            'firstFiles'=>$this->prepareFilesBeforeCreate($files,0,$model),
            'firstScripts'=>array(),
            'firstCssFiles'=>$this->prepareFilesBeforeCreate($filesCss,0,$model),
            'firstCss'=>array(),
            'category' => [],
            'categories' => BlogwdCategory::with('children')->where('parent_id','0')->get(),
            'delimiter' => ''
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
        //Отвечает за создание записи в таблице
        //Model name
        $model = "Webdev\Models\BlogwdCategory";
        $category = BlogwdCategory::create($request->all());
        //Get current resource ID from '$post->id'. It is needed for 'blogwd_scripts' table
        $arrayToInsert = $this->insertPathsWhenCreated($request->paths, $request->dbscripts, $category->id, $model);
        //If array isn't empty. It means JS file/s was/were added to a resource.
        if(!empty($arrayToInsert)){
            //Multiple inserts or one insert it depends on incomind data
            DB::table('blogwd_scripts')->insert($arrayToInsert);
        }
        //Get current resource ID from '$post->id'. It is needed for 'blogwd_styles' table
        $arrayToInsertCss = $this->insertPathsWhenCreated($request->pathsCss, $request->dbscripts, $category->id, $model, "css");
        //If array isn't empty. It means JS file/s was/were added to a resource.
        if(!empty($arrayToInsertCss)){
            //Multiple inserts or one insert it depends on incomind data
            DB::table('blogwd_styles')->insert($arrayToInsertCss);
        }
        //BlogwdCategory::create($request->all());
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Webdev\Models\BlogwdCategory  $blogwdCategory
     * @return \Illuminate\Http\Response
     */
    public function show(BlogwdCategory $blogwdCategory)
    {
        //Отвечает за вывод конкретного ресурса
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Webdev\Models\BlogwdCategory  $blogwdCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //We've got the whole list of file paths
        $files = $this->getAllFiles("js/additional_js");
        //We've got the whole list of file paths
        $filesCss = $this->getAllFiles("css/additional_css");
        //Model name
        $model = "Webdev\Models\BlogwdCategory";
        $category = BlogwdCategory::find($id);
        //Отвечает за открытие формы обновления
        return response()->view('admin.categories.edit',[
            // ’files’ и  'activeScripts' – данные для Vue компонентов
            'files'=>$this->getUnlikeDBPaths($files,$category->scripts,$id,$model),
            'activeScripts'=>$this->getDbPreparedData($category->scripts),
            // ’filesCss’ и  'activeCss' – данные для Vue компонентов
            'filesCss'=>$this->getUnlikeDBPaths($filesCss,$category->styles,$id,$model),
            'activeCss'=>$this->getDbPreparedData($category->styles,"css"),
            'category' => $category,
            'categories' => BlogwdCategory::with('children')->where('parent_id','0')->get(),
            'delimiter' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Webdev\Models\BlogwdCategory  $blogwdCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $category = BlogwdCategory::find($id);
            $category->published = $request->get('published');
            $category->title = $request->get('title');
            $category->meta_keywords = $request->get('meta_k');
            $category->meta_description = $request->get('meta_d');
            $category->menu_label = $request->get('menu_label');
            $category->description = $request->get('description');
            $category->parent_id = $request->get('parent_id');
        $category->save();
        //Update header_or_footer field in table 'blogwd_scripts'.
        $scripts_h_f = $this->updateScripts($request);
           if(count($scripts_h_f) > 0){
               for($j=0;$j<count($scripts_h_f);$j++){
                   \Webdev\Models\BlogwdScript::where('id',$scripts_h_f[$j]['id'])
                           ->where('scriptable_id',$id)
                           ->update($scripts_h_f[$j]);
                 }
           }
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Webdev\Models\BlogwdCategory  $blogwdCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Отвечает за удаление
        $category = BlogwdCategory::findOrFail($id);
        $category->delete();
        DB::table('blogwd_scripts')->where('scriptable_id', '=', $id)->delete();
        DB::table('blogwd_styles')->where('styleable_id', '=', $id)->delete();
        return redirect()->route('admin.category.index');
    }
}
