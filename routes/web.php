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
Auth::routes(['verify' => true]);
/*Routes for Administrative zone*/
Route::group([
    'prefix'=>'admin', //Part in URI
    'namespace'=>'Admin',//As folder name 'Admin' where Controllers lay
    'middleware'=>['auth','verified','admin.panel.access']],//From file Kernel, it allows don't write in Controllers
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

//Main page of the site
Route::get('/',function(){
    return view('blogwd.home');
});
//User's cabinet
Route::get('/email-notifier','Auth\EmailAffirmationController@afterRegistration')->name('after_register');
Route::get('/cabinet','Cabinet\WDBlogCabinetController@index')->name('user_cabinet')->middleware(['auth','verified','admin.panel.cabinet']);

Route::get('/category/{slug?}','WDBlogController@category')->name('category');
Route::get('/post/{slug?}','WDBlogController@post')->name('post');
