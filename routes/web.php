<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Routes for Administrative zone*/
Route::group([
    'prefix'=>'admin', //Part in URI
    'namespace'=>'Admin',//As folder name 'Admin' where Controllers lay
    'middleware'=>['auth']],//From file Kernel, it allows don't write in Controllers
    function(){
        Route::get('/','WDashboardController@wdashboard')->name('admin.index');
        Route::resource('/category','WDCategoryController',['as'=>'admin']);
        Route::resource('/post','WDPostController',['as'=>'admin']);
        Route::group([
            // Full prefix is - admin/user_managment - because user_managment is nested.
            'prefix'=>'user_managment',
            // Full namespace is - Admin\UserManagement - because UserManagement is nested.
            'namespace'=>'UserManagement'
            ],
            function(){
               Route::resource('/user','WDUserController',['as'=>'admin.user_management']); 
            }
         );
    }
);
Auth::routes();
//Main page of the site
Route::get('/',function(){
    return view('blogwd.home');
});
//
Route::get('/category/{slug?}','WDBlogController@category')->name('category');
Route::get('/post/{slug?}','WDBlogController@post')->name('post');
//Route::view('/', 'welcome');
//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/register', 'Auth\MyRegisterController@form')->name('register');
//Route::post('/register', 'Auth\MyRegisterController@register');
