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

Route::get('/', "HomeController@index");

Route::get('/register', "RegisterController@index");
Route::post('/register', "RegisterController@register");

Route::get('/login', "LoginController@index");
Route::post('/login', "LoginController@logIn");
Route::get('/logout', "LoginController@logout");

Route::prefix('admin')->group(function () {
    
    Route::get('/dashboard', function(){
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/categories', "CategoriesController@index")->name('admin.categories');
    Route::post('/categories/fetch', "CategoriesController@fetch")->name('admin.categories.fetch');
    Route::post('/categories', "CategoriesController@store")->name('admin.categories.store');
    Route::post('/categories/update', "CategoriesController@update")->name('admin.categories.update');
    Route::post('/categories/seach', "CategoriesController@search")->name('admin.categories.search');
    Route::post('/categories/delete', "CategoriesController@delete")->name('admin.categories.delete');

    Route::get('/products', "ProductController@index")->name('admin.products');
    Route::post('/products', "ProductController@store")->name('admin.products.store');
    Route::post('/products/fetch', "ProductController@fetch")->name('admin.products.fetch');
    Route::post('/products/update', "ProductController@update")->name('admin.products.update');
    Route::post('/products/seach', "ProductController@search")->name('admin.products.search');
    Route::post('/products/delete', "ProductController@delete")->name('admin.products.delete');
    Route::get('/products/show/{id}', "ProductController@show")->name('admin.products.show');

    Route::get('/purchase', "PurchaseController@index")->name('admin.purchase');
    Route::get('/purchase/product/{id}', "PurchaseController@show")->name('admin.purchase.show');
    Route::post('/purchase/store', "PurchaseController@store")->name('admin.purchase.store');
    Route::post('/purchase/fetch', "PurchaseController@fetch")->name('admin.purchase.fetch');
    Route::post('/purchase/delete', "PurchaseController@delete")->name('admin.purchase.delete');

});