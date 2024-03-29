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

Route::get('auth/google', 'SocialAuthController@redirectToGoogle');
Route::get('auth/google/callback', 'SocialAuthController@handleGoogleCallback');
/*Route::get('auth/google/checkout', 'SocialAuthController@redirectToGoogle');
Route::get('auth/google/checkout/callback', 'SocialAuthController@handleGoogleCallback');*/

Route::get('auth/facebook', 'SocialAuthController@redirectToFacebook');
Route::get('auth/facebook/callback', 'SocialAuthController@handleFacebookCallback');

Route::get('/', "HomeController@index");

Route::get('/recover-password/{email}', "RegisterController@resendEmail");

/*Route::get("/test/success", function(){

    return view("testSuccessPayment");

});*/

/*Route::get("/test/failed", function(){

    return view("failedPayment");

});*/

/*Route::get("/check/servertest", function(){

    $products = App\Product::where("picture", "like",  "%http://%")->get();
    
    foreach($products as $product){

        $productModel = App\Product::where("id", $product->id)->first();
        $productModel->picture = str_replace("http://", "https://", $product->picture);
        $productModel->update();

    }

});*/

/*Route::get("/test/mail", function(){

    $to_name = "Willian";
    $to_email = "rodriguezwillian95@gmail.com";
    \Mail::send("emails.purchaseTestMail", [], function($message) use ($to_name, $to_email) {

        $message->to($to_email, $to_name)->subject("¡Solo falta un paso tu registro!");
        $message->from("rodriguezwillian95@gmail.com","Deira");

    });


});*/

Route::get('/product/{slug}', "HomeController@show");
Route::get('/search', "HomeController@searchView");
Route::post('/search', "HomeController@search");

Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/cart', 'CartController@store')->name('cart.store');
Route::post('/cart/update', 'CartController@update')->name('cart.update');
Route::get('/cart/products', 'CartController@getItems')->name('cart.items');
Route::post('/cart/delete', 'CartController@delete')->name('cart.delete');

Route::get('/profile', 'ProfileController@index')->name('profile')->middleware("auth");
Route::post('/profile', 'ProfileController@update')->name('profile.update')->middleware("auth");

Route::get('/register', "RegisterController@index")->middleware("guest");
Route::post('/register', "RegisterController@register");

Route::get('/login', "LoginController@index")->name("login")->middleware("guest");
Route::post('/login', "LoginController@logIn");
Route::get('/logout', "LoginController@logout");

Route::get("/comune/by-region/{region_id}", "ComuneController@getComunesByRegion");

Route::get('/password/recovery', "RecoveryPasswordController@index");
Route::post('/password/recovery/send', "RecoveryPasswordController@send");
Route::get('/password/recovery/restore/{recovery_hash}', "RecoveryPasswordController@restore");
Route::post('/password/recovery/update', "RecoveryPasswordController@update");

Route::get('/brands/all', 'BrandController@brands')->name('brands.all');
Route::post('/brands/fetch', "BrandController@fetch")->name('brands.fetch');
Route::get('brand/{slug}', "BrandController@slug")->name('brands.slug');
Route::post('/brand/products', "BrandController@products")->name('brands.products');
Route::get('/brands/fetch/all', "BrandController@fetchAll");
Route::post("/brands/categories", "BrandController@fetchBrandCategories");

Route::get("best/stores", function(){

    return view("bestStores");

});

/*Route::get("/delete/duplicates", function(){
    ini_set('max_execution_time', 0);
    $duplicates = DB::table('products') ->select('sku', DB::raw('COUNT(*) as `count`')) ->groupBy('sku') ->havingRaw('COUNT(*) > 1') ->get();

    foreach($duplicates as $duplicate){
        
        $product = DB::table('products')->where("sku", $duplicate->sku)->delete();
        //$product = App\Product::where("id", $duplicate->id)->first();
        //dd($product);
        
    }

});*/

Route::get('/check/slug', function(){
    ini_set('max_execution_time', 0);
    $products = App\Product::where('slug', 'like', '%/%')->get();
    foreach($products as $product){

        $obj = App\Product::find($product->id);
        $obj->slug = str_replace("/", "-", $obj->slug);
        $obj->update();
    }
});

/*Route::get('/change/http', function(){

    ini_set('max_execution_time', 0);
    $products = App\Product::where("picture", "like", '%'."http://".'%')->get();

    foreach($products as $product){
        
        $modelProduct = App\Product::where("id", $product->id)->first();
        $modelProduct->picture = str_replace("http://", "https://", $product->picture);
        $modelProduct->update();

    }

});*/

//Route::get("file_update", "FileController@update");

/*Route::get('/check/slug/slash', function(){
    ini_set('max_execution_time', 0);
    $products = App\Product::where('slug','-')->get();
    foreach($products as $product){

        $slug = str_replace("/", "-", $product->name);
        $slug = str_replace(" ", "-", $slug);

        $obj = App\Product::find($product->id);
        $obj->slug = $slug;
        $obj->update();
    }
});*/

Route::get('/categories/all', "CategoriesController@categoriesAll");
Route::get('/categories/menu/{page}', "CategoriesController@megaMenu");

Route::get('/category/{slug}', "CategoriesController@slug");
Route::post('/category/products', "CategoriesController@products")->name('category.products');
Route::post("/category/brands", "CategoriesController@fetchCategoriesBrands");

Route::get('/checkout', 'CheckoutController@initTransaction')->name('checkout'); 
Route::post('/checkout/webpay/response', 'CheckoutController@response')->name('checkout.webpay.response');  
Route::post('/checkout/webpay/finish', 'CheckoutController@finish')->name('checkout.webpay.finish');

Route::get('/purchase', 'PurchaseController@myPurchase')->name('user.purchase');
Route::post('/purchase/fetch', 'PurchaseController@myPurchaseFetch')->name('user.purchase.fetch');

Route::post("/guestCart", "CartController@getGuestCarts");

Route::get("/guest/checkout", "GuestController@guestCheckoutIndex");
Route::post("/guest/store", "GuestController@store");
Route::post("/guest/carts/prices", "GuestController@cartPrices");

Route::get("/cart/shipping", "CartController@cartShippingView");
Route::post("/cart/shipping-price", "CartController@updateShippingPrice");
Route::post("/cart/shipping-price/location", "CartController@updateCartLocation");

Route::post("/comment", "CommentController@store")->middleware('auth');
Route::post("/comment/fetch", "CommentController@fetch");

Route::post("/checkout/store-session", "CheckoutController@storeSession");
Route::get("/checkout/factura", "CheckoutController@factura");

Route::get("/cart/ticket", function(){
    return view("cartTicket");
});

Route::post("/cart/bill/type", "CartController@billType");

Route::get("products/destacados", "ProductController@highlighted");
Route::post("products/destacados/fetch", "HighlightedProductController@userFetch");

Route::get('/validate/rut/{rut}', "RutController@validateRut");
Route::get('/confirm/email/{hash}', "RegisterController@confirmEmail");

Route::get('/ayuda', function(){
    return view('help');
});

Route::get('/somos', function(){
    return view('about');
});

/*Route::get('/cnet', "CnetController@index");
Route::get('/cnet/images', "CnetController@imagesDownload");*/
//Route::get('/cnet/decode', "CnetController@decode");
//Route::get('/cnet/compare', "CnetController@compare");
//Route::get('/categories/import', "CategoriesController@import");

//Route::get('/ingram/import', 'IngramController@import');

/*Route::get('/export/products', "CsvExportController@index");

Route::get('/test/categories', function(){

    dd(App\Category::has('products', '>', 0)->get());

});*/


Route::get('/terms', function(){
    return view('terms');
});

/*para ver la page xD  */

Route::get('/categories', function(){
    return view('categories');
});

Route::get("wishlist", "WishlistController@index");
Route::get("wishlist-fetch-products", "WishlistController@fetch");
Route::post("wishlist-add", "WishlistController@add");
Route::post("wishlist-remove", "WishlistController@remove");
Route::post("wishlist-check", "WishlistController@checkProduct");


Route::prefix('admin')->middleware('admin')->group(function () {
    
    Route::get('/dashboard', function(){
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get("/categories/searchPosition", function(){

        $categories = App\Category::orderBy("esp_name", "asc")->get();
        $index = 1;
        foreach($categories as $category){

            $category->search_position = $index;
            $category->update();
            $index++;
        }

    });

    Route::post("/products/hard/delete", "ProductController@hardDelete");

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
    Route::post('/categories/restore', "CategoriesController@restore")->name('admin.categories.restore');

    Route::get('/products', "ProductController@index")->name('admin.products');
    Route::post('/products', "ProductController@store")->name('admin.products.store');
    Route::post('/products/fetch', "ProductController@fetch")->name('admin.products.fetch');
    Route::post('/products/update', "ProductController@update")->name('admin.products.update');
    Route::post('/products/seach', "ProductController@search")->name('admin.products.search');
    Route::post('/products/delete', "ProductController@delete")->name('admin.products.delete');
    Route::post('/products/restore', "ProductController@restore")->name('admin.products.restore');
    Route::get('/products/show/{id}', "ProductController@show")->name('admin.products.show');

    Route::get('/feature/{productId}', "FeatureController@index");
    Route::get('/feature/fetch/{productId}', "FeatureController@fetch");
    Route::post('/feature/store', "FeatureController@store");
    Route::post('/feature/update', "FeatureController@update");
    Route::post('/feature/delete', "FeatureController@delete");

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

    Route::get("/text/index", "TextController@index");
    Route::get('/text/fetch/{page}', "TextController@fetch");
    Route::post('/text/update', "TextController@update");

    Route::get("/best-store/index", "BestStoreController@index");
    Route::get("/best-store/fetch", "BestStoreController@fetch");
    Route::post("/best-store/store", "BestStoreController@store");
    Route::post("/best-store/delete", "BestStoreController@delete");

    Route::get("/best-category/index", "BestCategoryController@index");
    Route::get("/best-category/fetch", "BestCategoryController@fetch");
    Route::post("/best-category/store", "BestCategoryController@store");
    Route::post("/best-category/delete", "BestCategoryController@delete");

    Route::get("/highlighted-product/index", "HighlightedProductController@index");
    Route::get("/highlighted-product/fetch", "HighlightedProductController@fetch");
    Route::post("/highlighted-product/search", "HighlightedProductController@search");
    Route::post("/highlighted-product/store", "HighlightedProductController@store");
    Route::post("/highlighted-product/delete", "HighlightedProductController@delete");

    Route::get("/help-center/index", "HelpCenterController@index");
    Route::get("/help-center/fetch", "HelpCenterController@fetch");
    Route::post("/help-center/search", "HelpCenterController@search");
    Route::post("/help-center/update", "HelpCenterController@update");
    Route::post("/help-center/store", "HelpCenterController@store");
    Route::post("/help-center/delete", "HelpCenterController@delete");

    Route::get("/maintenance/index", "MaintenanceController@index");
    Route::get("/maintenance/check", "MaintenanceController@check");
    Route::post("/maintenance/activate", "MaintenanceController@activate");
    Route::post("/maintenance/deactivate", "MaintenanceController@deactivate");

    Route::get("/range-profit/index", "RangeProfitController@index");
    Route::get("/range-profit/fetch/{page}", "RangeProfitController@fetch");
    Route::post("/range-profit/apply", "RangeProfitController@apply");

    Route::get("sales/export/{fromDate}/to/{toDate}", "SaleController@export");
    Route::post('/sales/notify/pickup', "SaleController@pickup");
    Route::post('/sales/notify/shipping', "SaleController@shipping");

    Route::get("users/registered", "UserController@index");
    Route::get("users/guest", "UserController@guest");
    Route::get("users/registered/fetch/{page}", "UserController@fetchRegisterd");
    Route::get("users/guest/fetch/{page}", "UserController@fetchGuest");

    Route::get("search/options", "AdminSearchController@index");
    Route::post("search/options/update", "AdminSearchController@update");

    Route::get("pop-up", "ModalController@index");
    Route::get("pop-up/fetch", "ModalController@fetch");
    Route::post("pop-up/update", "ModalController@update");

});

Route::get('/nexsys/{mark}', "NexsysController@index");