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
    public function edit(BlogwdCategory $blogwdCategory)
    {
        //Отвечает за открытие формы обновления
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Webdev\Models\BlogwdCategory  $blogwdCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogwdCategory $blogwdCategory)
    {
        //Отвечает за обновление в таблице
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
