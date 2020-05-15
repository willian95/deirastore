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

Route::get('/product/{slug}', "HomeController@show");
Route::get('/search', "HomeController@search");

Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/cart', 'CartController@store')->name('cart.store');
Route::post('/cart/update', 'CartController@update')->name('cart.update');
Route::get('/cart/products', 'CartController@getItems')->name('cart.items');
Route::post('/cart/delete', 'CartController@delete')->name('cart.delete');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/register', "RegisterController@index");
Route::post('/register', "RegisterController@register");

Route::get('/login', "LoginController@index");
Route::post('/login', "LoginController@logIn");
Route::get('/logout', "LoginController@logout");

Route::get('/password/recovery', "RecoveryPasswordController@index");
Route::post('/password/recovery/send', "RecoveryPasswordController@send");
Route::get('/password/recovery/restore/{recovery_hash}', "RecoveryPasswordController@restore");
Route::post('/password/recovery/update', "RecoveryPasswordController@update");

Route::get('/brands/all', 'BrandController@brands')->name('brands.all');
Route::post('/brands/fetch', "BrandController@fetch")->name('brands.fetch');
Route::get('brand/{slug}', "BrandController@slug")->name('brands.slug');
Route::post('/brand/products', "BrandController@products")->name('brands.products');
Route::get('/brands/fetch/all', "BrandController@fetchAll");

Route::get('/categories/all', "CategoriesController@categoriesAll");
Route::get('/categories/menu/{page}', "CategoriesController@megaMenu");

Route::get('/category/{slug}', "CategoriesController@slug");
Route::post('/category/products', "CategoriesController@products")->name('category.products');

Route::get('/checkout', 'CheckoutController@initTransaction')->name('checkout'); 
Route::post('/checkout/webpay/response', 'CheckoutController@response')->name('checkout.webpay.response');  
Route::post('/checkout/webpay/finish', 'CheckoutController@finish')->name('checkout.webpay.finish');

Route::get('/purchase', 'PurchaseController@myPurchase')->name('user.purchase');
Route::post('/purchase/fetch', 'PurchaseController@myPurchaseFetch')->name('user.purchase.fetch');

Route::post("/guestCart", "CartController@getGuestCarts");

Route::get("/guest/checkout", "GuestController@guestCheckoutIndex");
Route::post("/guest/store", "GuestController@store");

Route::get("products/destacados", "ProductController@highlighted");

Route::get('/validate/rut/{rut}', "RutController@validateRut");
Route::get('/confirm/email/{hash}', "RegisterController@confirmEmail");

Route::get('/ayuda', function(){
    return view('help');
});

Route::get('/cnet', "CnetController@index");
Route::get('/cnet/images', "CnetController@imagesDownload");
Route::get('/cnet/decode', "CnetController@decode");
Route::get('/cnet/compare', "CnetController@compare");

Route::get('/ingram/import', 'IngramController@import');

Route::get('/export/products', "CsvExportController@index");

Route::get('/test/categories', function(){

    dd(App\Category::has('products', '>', 0)->get());

});


Route::get('/terms', function(){
    return view('terms');
});

Route::prefix('admin')->group(function () {
    
    Route::get('/dashboard', function(){
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/brands', "BrandController@index")->name('admin.brands');
    Route::post('/brands/store', "BrandController@store")->name('admin.brands.store');
    Route::post('/brands/fetch', "BrandController@fetch")->name('admin.brands.fetch');
    Route::post('/brands/update', "BrandController@update")->name('admin.brands.update');
    Route::post('/brands/delete', "BrandController@delete")->name('admin.brands.delete');
    Route::post('/brands/seach', "BrandController@search")->name('admin.brands.search');

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

    Route::get('/sale', "SaleController@index")->name('admin.sale');
    Route::post('/sale/fetch', "SaleController@fetch")->name('admin.sale.fetch');

    Route::get('/dolar', "DolarController@index")->name('admin.dolar.index');

    Route::get('/banner/index', "BannerController@index")->name('admin.banner.index');
    Route::post('/banner/store', "BannerController@store")->name('admin.banner.store');
    Route::post('/banner/update', "BannerController@update")->name('admin.banner.update');
    Route::get('/banner/fetch/{page}', "BannerController@fetchAdmin");
    Route::post('/banner/delete', "BannerController@delete")->name('admin.banner.delete');
    
});

Route::get('/nexsys/{mark}', "NexsysController@index");