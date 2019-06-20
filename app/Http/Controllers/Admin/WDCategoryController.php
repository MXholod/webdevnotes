<?php

namespace Webdev\Http\Controllers\Admin;

use Webdev\Models\BlogwdCategory;
use Illuminate\Http\Request;
use Webdev\Http\Controllers\Controller;

class WDCategoryController extends Controller
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
        return view('admin.categories.index',[
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
        //Отвечает за открытие формы создания Категории
        return view('admin.categories.create',[
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
        //Method create() is for bulk filling
        BlogwdCategory::create($request->all());
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
        $category = BlogwdCategory::find($id);
        //Отвечает за открытие формы обновления
        return view('admin.categories.edit',[
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
            $category->description = $request->get('description');
            $category->parent_id = $request->get('parent_id');
        $category->save();
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Webdev\Models\BlogwdCategory  $blogwdCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogwdCategory $blogwdCategory)
    {
        //Отвечает за удаление
    }
}
