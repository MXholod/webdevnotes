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

/*Route::get('/', function () {
    return view('welcome');
});*/
/*Routes for Administrative zone*/
Route::group([
    'prefix'=>'admin', //Part in URI
    'namespace'=>'Admin',//As folder name 'Admin' where Controllers lay
    'middleware'=>['auth']],//From file Kernel, it allows don't write in Controllers
    function(){
        Route::get('/','WDashboardController@wdashboard')->name('admin.index');
        Route::resource('/category','WDCategoryController',['as'=>'admin']);
    }
);

Route::view('/', 'welcome');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
